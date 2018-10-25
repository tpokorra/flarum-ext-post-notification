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

use Illuminate\Contracts\Events\Dispatcher;

return function(Dispatcher $events) {
	$events->subscribe(Listeners\PostNotification::class);
};
