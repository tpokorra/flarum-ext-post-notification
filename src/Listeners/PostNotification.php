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
use Illuminate\Support\Arr;

class PostNotification
{
    /**
     * @var SettingsRepositoryInterface
     */
    protected $settings;

    protected $mailer;

    protected static $flarumConfig;

    /**
     * @param SettingsRepositoryInterface $settings
     */
    public function __construct(SettingsRepositoryInterface $settings, Mailer $mailer)
    {
        $this->settings = $settings;
        $this->mailer = $mailer;
        static::$flarumConfig = app('flarum.config');
        $this->update_0_3_0();
    }

    // compatibility with older version (0.2.2, 2019-11)
    private function update_0_3_0() {
        $recipients_new_to = $this->settings->get('PostNotification.recipients.new_post.to');
        $recipients_new_bcc = $this->settings->get('PostNotification.recipients.new_post.bcc');
        $recipients_revised_to = $this->settings->get('PostNotification.recipients.revised_post.to');
        $recipients_revised_bcc = $this->settings->get('PostNotification.recipients.revised_post.bcc');

        if (empty($recipients_new_to) && empty($recipients_new_bcc) && empty($recipients_revised_bcc) && empty($recipients_revised_bcc)) {
            $this->settings->set('PostNotification.recipients.new_post.to', $this->settings->get('PostNotification.recipients.to'));
            $this->settings->set('PostNotification.recipients.new_post.bcc', $this->settings->get('PostNotification.recipients.bcc'));
            $this->settings->set('PostNotification.recipients.revised_post.to', $this->settings->get('PostNotification.recipients.to'));
            $this->settings->set('PostNotification.recipients.revised_post.bcc', $this->settings->get('PostNotification.recipients.bcc'));
        }

        $recipients_new_to = $this->settings->get('PostNotification.recipients.new_discussion.to');
        $recipients_new_bcc = $this->settings->get('PostNotification.recipients.new_discussion.bcc');
        if (empty($recipients_new_to) && empty($recipients_new_bcc)) {
            $this->settings->set('PostNotification.recipients.new_discussion.to', $this->settings->get('PostNotification.recipients.to'));
            $this->settings->set('PostNotification.recipients.new_discussion.bcc', $this->settings->get('PostNotification.recipients.bcc'));
        }
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

        $new_discussion = ($post->number == 1 && $new_post);

        if ($new_discussion) {
            //$first_sentence = "There's a new discussion by %s on my forum";
            $first_sentence = $this->settings->get('PostNotification.new_discussion', 'A new discussion has been started by %s:');
            $recipients_to = $this->settings->get('PostNotification.recipients.new_discussion.to');
            $recipients_bcc = $this->settings->get('PostNotification.recipients.new_discussion.bcc');
        }
        else if ($new_post) {
            //$first_sentence = "There's a new post by %s on my forum";
            $first_sentence = $this->settings->get('PostNotification.new_post');
            $recipients_to = $this->settings->get('PostNotification.recipients.new_post.to');
            $recipients_bcc = $this->settings->get('PostNotification.recipients.new_post.bcc');
        } else {
            //$first_sentence = "A post has been edited by %s on my forum";
            $first_sentence = $this->settings->get('PostNotification.revised_post');
            $recipients_to = $this->settings->get('PostNotification.recipients.revised_post.to');
            $recipients_bcc = $this->settings->get('PostNotification.recipients.revised_post.bcc');
        }
        $first_sentence = sprintf($first_sentence, $post->user()->getResults()->username);
        $content =  $first_sentence."\n\n\n" .
                Arr::get(static::$flarumConfig, 'url').
                '/d/'.$post->discussion->id.'-'.$post->discussion->slug.'/'.$post->number.
                "\n\n".
                $post->content;
        if (!empty($recipients_to)) {
            $this->mailer->raw($content, function (Message $message) use ($post, $recipients_to, $recipients_bcc) {
                // $recipients_to = 'me@example.com, you@example.com';
                $recipients = explode(',', str_replace(' ', '', $recipients_to));
                $message->to($recipients);
                $recipients = explode(',', str_replace(' ', '', $recipients_bcc));
                if (!empty($recipients)) {
                    $message->bcc($recipients);
                }
                $forum_name = $this->settings->get('forum_title');
                $message->subject("[$forum_name] " . $post->discussion->title);
            });
        }
    }
}
