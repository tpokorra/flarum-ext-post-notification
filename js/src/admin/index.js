import app from 'flarum/app';

const translationPrefix = 'tpokorra-post-notification.admin.settings.';
const settingsPrefix = 'PostNotification.';


app.initializers.add('tpokorra-post-notification', () => {
    app.extensionData
        .for('tpokorra-post-notification')

        .registerSetting({
            label: app.translator.trans(translationPrefix + 'recipients.post_approval.to'),
            setting: settingsPrefix + 'recipients.post_approval.to',
            type: 'text',
        })
        .registerSetting({
            label: app.translator.trans(translationPrefix + 'recipients.new_discussion.to'),
            setting: settingsPrefix + 'recipients.new_discussion.to',
            type: 'text',
        })
        .registerSetting({
            label: app.translator.trans(translationPrefix + 'recipients.new_discussion.bcc'),
            setting: settingsPrefix + 'recipients.new_discussion.bcc',
            type: 'text',
        })
        .registerSetting({
            label: app.translator.trans(translationPrefix + 'recipients.new_post.to'),
            setting: settingsPrefix + 'recipients.new_post.to',
            type: 'text',
        })
        .registerSetting({
            label: app.translator.trans(translationPrefix + 'recipients.new_post.bcc'),
            setting: settingsPrefix + 'recipients.new_post.bcc',
            type: 'text',
        })
        .registerSetting({
            label: app.translator.trans(translationPrefix + 'recipients.revised_post.to'),
            setting: settingsPrefix + 'recipients.revised_post.to',
            type: 'text',
        })
        .registerSetting({
            label: app.translator.trans(translationPrefix + 'recipients.revised_post.bcc'),
            setting: settingsPrefix + 'recipients.revised_post.bcc',
            type: 'text',
        })
        .registerSetting({
            label: app.translator.trans(translationPrefix + 'post_approval'),
            setting: settingsPrefix + 'post_approval',
            type: 'text',
            default: 'A new post by %s needs to be approved:',
        })
        .registerSetting({
            label: app.translator.trans(translationPrefix + 'new_discussion'),
            setting: settingsPrefix + 'new_discussion',
            type: 'text',
            default: 'A new discussion has been started by %s:',
        })
        .registerSetting({
            label: app.translator.trans(translationPrefix + 'new_post'),
            setting: settingsPrefix + 'new_post',
            type: 'text',
            default: 'A new message has been posted by %s:',
        })
        .registerSetting({
            label: app.translator.trans(translationPrefix + 'revised_post'),
            setting: settingsPrefix + 'revised_post',
            type: 'text',
            default: 'A message has been revised by %s:',
        });
});
