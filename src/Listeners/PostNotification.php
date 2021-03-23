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
use Flarum\Approval\Event\PostWasApproved;
use Flarum\Post\Event\Saving;
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
    }

    /**
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(Posted::class, [$this, 'PostWasPosted']);
        $events->listen(Revised::class, [$this, 'PostWasRevised']);
        $events->listen(PostWasApproved::class, [$this, 'PostWasApproved']);
        $events->listen(Saving::class, [$this, 'PostNeedsApproval']);
    }

    public function PostWasPosted(Posted $event) {
        $this->SendNotification($event->post, true);
    }

    public function PostWasRevised(Revised $event) {
        $this->SendNotification($event->post, false);
    }

    public function PostWasApproved(PostWasApproved $event) {
        $this->SendNotification($event->post, true);
    }

    public function PostNeedsApproval(Saving $event) {
        if ($event->post->is_approved == false) {
            $this->SendNotification($event->post, true, true);
        }
    }

    private function SendNotification($post, bool $new_post, bool $needs_approval = false) {

        if ($post->is_private) {
            # don't notify private posts here
            return;
        }

        $new_discussion = ($post->number == 1 && $new_post);

        if ($needs_approval) {
            $first_sentence = $this->settings->get('PostNotification.post_approval', 'A new post by %s needs to be approved:');
            $recipients_to = $this->settings->get('PostNotification.recipients.post_approval.to');
            $recipients_bcc = "";
        }
        else if ($new_discussion) {
            //$first_sentence = "There's a new discussion by %s on my forum";
            $first_sentence = $this->settings->get('PostNotification.new_discussion');
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
                if (!empty($recipients_bcc)) {
                    $recipients = explode(',', str_replace(' ', '', $recipients_bcc));
                    $message->bcc($recipients);
                }
                $forum_name = $this->settings->get('forum_title');
                $message->subject("[$forum_name] " . $post->discussion->title);
            });
        }
    }
}
