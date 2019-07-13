import app from 'flarum/app';
import { extend } from 'flarum/extend';
import PostNotificationSettingsModal from './components/PostNotificationSettingsModal';

app.initializers.add('tpokorra/post-notification', () => {
	extend(PostNotificationSettingsModal.prototype, 'fields', function(items) {
		items.add('p', <p>Your Text.</p>, -30);
	});
});
