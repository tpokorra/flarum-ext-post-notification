import Extend from 'flarum/common/extenders';
import app from 'flarum/app';

const translationPrefix = 'tpokorra-post-notification.admin.settings.';
const settingsPrefix = 'PostNotification.';

export default [
  new Extend.Admin()
    .setting(() => ({
      label: app.translator.trans(translationPrefix + 'recipients.post_approval.to'),
      setting: settingsPrefix + 'recipients.post_approval.to',
      type: 'text',
    }))
    .setting(() => ({
      label: app.translator.trans(translationPrefix + 'recipients.new_discussion.to'),
      setting: settingsPrefix + 'recipients.new_discussion.to',
      type: 'text',
    }))
    .setting(() => ({
      label: app.translator.trans(translationPrefix + 'recipients.new_discussion.bcc'),
      setting: settingsPrefix + 'recipients.new_discussion.bcc',
      type: 'text',
    }))
    .setting(() => ({
      label: app.translator.trans(translationPrefix + 'recipients.new_post.to'),
      setting: settingsPrefix + 'recipients.new_post.to',
      type: 'text',
    }))
    .setting(() => ({
      label: app.translator.trans(translationPrefix + 'recipients.new_post.bcc'),
      setting: settingsPrefix + 'recipients.new_post.bcc',
      type: 'text',
    }))
    .setting(() => ({
      label: app.translator.trans(translationPrefix + 'recipients.revised_post.to'),
      setting: settingsPrefix + 'recipients.revised_post.to',
      type: 'text',
    }))
    .setting(() => ({
      label: app.translator.trans(translationPrefix + 'recipients.revised_post.bcc'),
      setting: settingsPrefix + 'recipients.revised_post.bcc',
      type: 'text',
    }))
    .setting(() => ({
      label: app.translator.trans(translationPrefix + 'post_approval'),
      setting: settingsPrefix + 'post_approval',
      type: 'text',
      default: 'A new post by %s needs to be approved:',
    }))
    .setting(() => ({
      label: app.translator.trans(translationPrefix + 'new_discussion'),
      setting: settingsPrefix + 'new_discussion',
      type: 'text',
      default: 'A new discussion has been started by %s:',
    }))
    .setting(() => ({
      label: app.translator.trans(translationPrefix + 'new_post'),
      setting: settingsPrefix + 'new_post',
      type: 'text',
      default: 'A new message has been posted by %s:',
    }))
    .setting(() => ({
      label: app.translator.trans(translationPrefix + 'revised_post'),
      setting: settingsPrefix + 'revised_post',
      type: 'text',
      default: 'A message has been revised by %s:',
    })),
];
