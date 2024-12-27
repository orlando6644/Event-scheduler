
import { createRouter, createWebHistory } from 'vue-router';
import store from '../store';
import Login from '../components/auth/Login.vue';
import Dashboard from '../components/dashboard/Dashboard.vue';

const isAuthenticated = () => {
    return store.getters.isAuthenticated;
}

const routes = [
    {
        path: '/',
        redirect: { name: 'Login' }
    },
    {
        path: '/login',
        name: 'Login',
        component: Login,
        beforeEnter: (to, from, next) => {
            if (isAuthenticated()) {
                next({ name: 'Dashboard' });
            } else {
                next();
            }
        }
    },
    {
        path: '/dashboard',
        name: 'Dashboard',
        component: Dashboard,
        beforeEnter: (to, from, next) => {
            if (!isAuthenticated()) {
                next({ name: 'Login' });
            } else {
                next();
            }
        }
    }
];

const router = createRouter({
  history: createWebHistory(import.meta.env.VITE_APP_URL || '/'),
  routes
});

export default router;
