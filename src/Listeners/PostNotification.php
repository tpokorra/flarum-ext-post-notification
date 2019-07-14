<?php
/*
 * This file is part of the flarum extension flarum-ext-post-notification.
 *
 * (c) Timotheus Pokorra <timotheus.pokorra@solidcharity.com>
 *
 * For the full copyright and license information, please view the license.md
 * file that was distributed with this source code.
 */

namespace tpokorra\PostNotification\Listeners;

use Flarum\Settings\SettingsRepositoryInterface;
use Flarum\Post\Event\Posted;
use Flarum\Post\Event\Revised;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Mail\Message;

class PostNotification
{
    /**
     * @var SettingsRepositoryInterface
     */
    protected $settings;

    protected $mailer;

    /**
     * @param SettingsRepositoryInterface $settings
     */
    public function __construct(SettingsRepositoryInterface $settings, Mailer $mailer)
    {
        $this->settings = $settings;
        $this->mailer = $mailer;
    }

    /**
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(Posted::class, [$this, 'PostWasPosted']);
        $events->listen(Revised::class, [$this, 'PostWasRevised']);
    }

    public function PostWasPosted(Posted $event) {
        $this->SendNotification($event->post, true);
    }

    public function PostWasRevised(Revised $event) {
        $this->SendNotification($event->post, false);
    }

    private function SendNotification($post, bool $new_post) {

        if ($post->is_private) {
            # don't notify private posts here
            return;
        }

        if ($new_post) {
            //$first_sentence = "There's a new post by %s on my forum";
            $first_sentence = $this->settings->get('PostNotification.new_post');
        } else {
            //$first_sentence = "A post has been edited by %s on my forum";
            $first_sentence = $this->settings->get('PostNotification.revised_post');
        }
        $first_sentence = sprintf($first_sentence, $post->user()->getResults()->username);
        $content =  $first_sentence."\n\n\n" .
                $post->content;
        $this->mailer->raw($content, function (Message $message) use ($post) {
                // $recipient = 'me@example.com, you@example.com';
                $recipients = explode(',', str_replace(' ', '', $this->settings->get('PostNotification.recipients.to')));
                $message->to($recipients);
                $recipients = explode(',', str_replace(' ', '', $this->settings->get('PostNotification.recipients.bcc')));
                $message->bcc($recipients);
                $forum_name = $this->settings->get('forum_title');
                $message->subject("[$forum_name] " . $post->discussion->title);
        });
    }
}
