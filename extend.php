<?php
/*
 * This file is part of the flarum extension flarum-ext-post-notification.
 *
 * (c) Timotheus Pokorra <timotheus.pokorra@solidcharity.com>
 *
 * For the full copyright and license information, please view the license.md
 * file that was distributed with this source code.
 */

namespace tpokorra\PostNotification;

use Flarum\Extend;
use Flarum\Settings\SettingsRepositoryInterface;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\View\Factory;

return [
    (new Extend\Frontend('admin'))
        ->js(__DIR__.'/js/dist/admin.js'),

    (new Extend\Settings())
        ->serializeToForum('PostNotification.recipients.post_approval.to', 'PostNotification.recipients.post_approval.to')
        ->serializeToForum('PostNotification.recipients.new_discussion.to', 'PostNotification.recipients.new_discussion.to')
        ->serializeToForum('PostNotification.recipients.new_discussion.bcc', 'PostNotification.recipients.new_discussion.bcc')
        ->serializeToForum('PostNotification.recipients.new_post.to', 'PostNotification.recipients.new_post.to')
        ->serializeToForum('PostNotification.recipients.new_post.bcc', 'PostNotification.recipients.new_post.bcc')
        ->serializeToForum('PostNotification.recipients.revised_post.to', 'PostNotification.recipients.revised_post.to')
        ->serializeToForum('PostNotification.recipients.revised_post.bcc', 'PostNotification.recipients.revised_post.bcc')
        ->serializeToForum('PostNotification.post_approval', 'PostNotification.post_approval')
        ->serializeToForum('PostNotification.new_discussion', 'PostNotification.new_discussion')
        ->serializeToForum('PostNotification.new_post', 'PostNotification.new_post')
        ->serializeToForum('PostNotification.revised_post', 'PostNotification.revised_post'),

    new Extend\Locales(__DIR__.'/resources/locale'),
    function(Dispatcher $events, Factory $view) {
        $events->subscribe(Listeners\PostNotification::class);
    }
];
