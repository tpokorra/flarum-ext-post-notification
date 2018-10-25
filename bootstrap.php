<?php

namespace Flagrow\PostNotification;

use Flarum\Core;
use Flarum\Core\Repository\UserRepository;
use Flarum\Settings\SettingsRepositoryInterface;
use Flarum\Event\PostWasPosted;
use Flarum\Event\PostWasRevised;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Mail\Message;

function SendNotification(Post $post, Mailer $mailer) {
	$first_sentence = "There's a new discussion on my forum"; // TODO in config file
	$content =  $first_sentence."\n\n\n" .
                $post->content;
	$mailer->raw($content, function (Message $message) use ($post) {
		$recipient = "me@example.com"; // TODO in config file
		$message->to($recipient);
		$forum_name = "My-Forum"; // TODO in config file
		$message->subject("[$forum_name] " . $post->discussion->title);
	}
}	

return function(Dispatcher $events, Mailer $mailer) {
	$events->listen(PostWasPosted::class, function (PostWasPosted $event) use ($mailer) {
		SendNotification($event->post, $mailer);
	}
	$events->listen(PostWasRevised::class, function (PostWasRevised $event) use ($mailer) {
		SendNotification($event->post, $mailer);
	}
};
