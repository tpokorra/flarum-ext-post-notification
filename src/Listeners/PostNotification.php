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
use Flarum\Event\PostWasPosted;
use Flarum\Event\PostWasRevised;
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
        $events->listen(PostWasPosted::class, [$this, 'PostWasPosted']);
        $events->listen(PostWasRevised::class, [$this, 'PostWasRevised']);
    }

    public function PostWasPosted(PostWasPosted $event) {
        $this->SendNotification($event->post, true);
    }

    public function PostWasRevised(PostWasRevised $event) {
        $this->SendNotification($event->post, false);
    }

    private function SendNotification($post, bool $new_post) {
        if ($new_post) {
            //$first_sentence = "There's a new post on my forum";
            $first_sentence = $this->settings->get('PostNotification.new_post');
        } else {
            //$first_sentence = "A post has been edited on my forum";
            $first_sentence = $this->settings->get('PostNotification.revised_post');
        }
        $content =  $first_sentence."\n\n\n" .
                $post->content;
        $this->mailer->raw($content, function (Message $message) use ($post) {
                // $recipient = 'me@example.com, you@example.com';
                $recipients = $this->settings->get('PostNotification.recipients');
                $message->to($recipients);
                $forum_name = $this->settings->get('PostNotification.forumname');
                $message->subject("[$forum_name] " . $post->discussion->title);
        });
    }
}
