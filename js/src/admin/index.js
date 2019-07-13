import app from 'flarum/app';
import PostNotificationSettingsModal from './components/PostNotificationSettingsModal';

app.initializers.add('post-notification', () => {
        app.extensionSettings['post-notification'] = () => app.modal.show(new PostNotificationSettingsModal());
});
