import SettingsModal from 'flarum/components/SettingsModal';

export default class PostNotificationSettingsModal extends SettingsModal {
    className() {
        return 'PostNotificationSettingsModal Modal--medium';
    }

    title() {
        return app.translator.trans('post-notification.admin.settings.title');
    }

    form() {
        return [
            <div className="Form-group">
                <label>{app.translator.trans('post-notification.admin.settings.forumname')}</label>
                <input required className="FormControl" type="text" bidi={this.setting('PostNotification.forumname')} />
            </div>,

            <div className="Form-group">
                <label>{app.translator.trans('post-notification.admin.settings.recipients.to')}</label>
                <input required className="FormControl" type="text" length="50" bidi={this.setting('PostNotification.recipients.to')} />
            </div>,

        ];
    }
}