import './bootstrap';
import { createApp } from 'vue';
import router from './router';
import store from './store';
import Layout from './components/Layout.vue';

const app = createApp(Layout);

app.use(router);
app.use(store);
app.mount('#app');
