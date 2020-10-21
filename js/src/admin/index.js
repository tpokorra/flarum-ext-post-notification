import app from 'flarum/app';
import PostNotificationSettingsModal from './components/PostNotificationSettingsModal';

app.initializers.add('tpokorra-post-notification', () => {
        app.extensionSettings['tpokorra-post-notification'] = () => app.modal.show(PostNotificationSettingsModal);
});
