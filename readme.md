# Notification for each post

This is used in a closed forum, where all members should receive an email whenever a message is posted or modified.

### installation

Install manually:

```bash
composer require tpokorra/flarum-ext-post-notification
```

Don't forget to activate the extension in the admin panel of your Flarum!

### configuration

This currently happens via SQL:

```sql
insert into fl_settings values ('PostNotification.forumname', 'My Forum');
insert into fl_settings values ('PostNotification.recipients.to', 'forum@example.com');
insert into fl_settings values ('PostNotification.recipients.bcc', 'me@example.com, you@example.com');
insert into fl_settings values ('PostNotification.new_post', 'A new message has been posted by %s:');
insert into fl_settings values ('PostNotification.revised_post', 'A message has been revised by %s:');
```

### license

This extension is licensed under the MIT license.
