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
                <label>{app.translator.trans('tpokorra-post-notification.admin.settings.recipients.post_approval.to')}</label>
                <input className="FormControl" type="text" length="50" bidi={this.setting('PostNotification.recipients.post_approval.to')} />
            </div>,

            <div className="Form-group">
                <label>{app.translator.trans('tpokorra-post-notification.admin.settings.recipients.new_discussion.to')}</label>
                <input className="FormControl" type="text" length="50" bidi={this.setting('PostNotification.recipients.new_discussion.to')} />
            </div>,

            <div className="Form-group">
                <label>{app.translator.trans('tpokorra-post-notification.admin.settings.recipients.new_discussion.bcc')}</label>
                <input className="FormControl" type="text" length="100" bidi={this.setting('PostNotification.recipients.new_discussion.bcc')} />
            </div>,

            <div className="Form-group">
                <label>{app.translator.trans('tpokorra-post-notification.admin.settings.recipients.new_post.to')}</label>
                <input className="FormControl" type="text" length="50" bidi={this.setting('PostNotification.recipients.new_post.to')} />
            </div>,

            <div className="Form-group">
                <label>{app.translator.trans('tpokorra-post-notification.admin.settings.recipients.new_post.bcc')}</label>
                <input className="FormControl" type="text" length="100" bidi={this.setting('PostNotification.recipients.new_post.bcc')} />
            </div>,

            <div className="Form-group">
                <label>{app.translator.trans('tpokorra-post-notification.admin.settings.recipients.revised_post.to')}</label>
                <input className="FormControl" type="text" length="50" bidi={this.setting('PostNotification.recipients.revised_post.to')} />
            </div>,

            <div className="Form-group">
                <label>{app.translator.trans('tpokorra-post-notification.admin.settings.recipients.revised_post.bcc')}</label>
                <input className="FormControl" type="text" length="100" bidi={this.setting('PostNotification.recipients.revised_post.bcc')} />
            </div>,

            <div className="Form-group">
                <label>{app.translator.trans('tpokorra-post-notification.admin.settings.post_approval')}</label>
                <input required className="FormControl" type="text" length="100" bidi={this.setting('PostNotification.post_approval', 'A new post by %s needs to be approved:')} />
            </div>,

            <div className="Form-group">
                <label>{app.translator.trans('tpokorra-post-notification.admin.settings.new_discussion')}</label>
                <input required className="FormControl" type="text" length="100" bidi={this.setting('PostNotification.new_discussion', 'A new discussion has been started by %s:')} />
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
