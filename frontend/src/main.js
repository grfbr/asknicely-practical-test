import 'bootstrap/dist/css/bootstrap.min.css';
import Notifications from '@kyvg/vue3-notification'
import { createApp } from 'vue'
import App from './App.vue'

let app = createApp(App)
app.config.globalProperties.DOMAIN = 'http://127.0.0.1:8000'
app.use(Notifications).mount('#app')