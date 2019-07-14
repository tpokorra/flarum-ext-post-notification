import SettingsModal from 'flarum/components/SettingsModal';

export default class PostNotificationSettingsModal extends SettingsModal {
    className() {
        return 'PostNotificationSettingsModal Modal--medium';
    }

    title() {
        return app.translator.trans('tpokorra-post-notification.admin.settings.title');
    }

    form() {
        return [
            <div className="Form-group">
                <label>{app.translator.trans('tpokorra-post-notification.admin.settings.recipients.to')}</label>
                <input required className="FormControl" type="text" length="50" bidi={this.setting('PostNotification.recipients.to', 'forum-updates@example.org')} />
            </div>,

            <div className="Form-group">
                <label>{app.translator.trans('tpokorra-post-notification.admin.settings.recipients.bcc')}</label>
                <input required className="FormControl" type="text" length="100" bidi={this.setting('PostNotification.recipients.bcc', 'person1@example.org, person2@example.org')} />
            </div>,

            <div className="Form-group">
                <label>{app.translator.trans('tpokorra-post-notification.admin.settings.new_post')}</label>
                <input required className="FormControl" type="text" length="100" bidi={this.setting('PostNotification.new_post', 'A new message has been posted by %s:')} />
            </div>,

            <div className="Form-group">
                <label>{app.translator.trans('tpokorra-post-notification.admin.settings.revised_post')}</label>
                <input required className="FormControl" type="text" length="100" bidi={this.setting('PostNotification.revised_post', 'A message has been revised by %s:')} />
            </div>,

        ];
    }
}
