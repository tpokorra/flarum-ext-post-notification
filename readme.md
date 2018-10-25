# Notification for each post

This is used in a closed forum, where all members should receive an email whenever a message is posted or modified.

### installation

Install manually:

```bash
composer require tpokorra/flarum-ext-post-notification
```

### configuration

This currently happens via SQL:

```sql
insert into fl_settings values ('PostNotification.forumname', 'My Forum');
insert into fl_settings values ('PostNotification.recipients.to', 'forum@example.com');
insert into fl_settings values ('PostNotification.recipients.bcc', 'me@example.com, you@example.com');
insert into fl_settings values ('PostNotification.new_post', 'A new message has been posted:');
insert into fl_settings values ('PostNotification.revised_post', 'A message has been revised:');
```

### license

This extension is licensed under the MIT license.
