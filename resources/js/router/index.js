
import { createRouter, createWebHistory } from 'vue-router';
import store from '../store';
import Login from '../components/auth/Login.vue';
import Dashboard from '../components/dashboard/Dashboard.vue';

const routes = [
    {
        path: '/',
        redirect: { name: 'Login' }
    },
    {
        path: '/login',
        name: 'Login',
        component: Login,
        meta: { requiresAuth: false },
    },
    {
        path: '/dashboard',
        name: 'Dashboard',
        component: Dashboard,
        meta: { requiresAuth: true },
    }
];

const router = createRouter({
    history: createWebHistory('/'),
    routes
});

router.beforeEach(async (to, from, next) => {

    if (to.meta.requiresAuth && !store.getters['auth/isAuthenticated']) {
      await store.dispatch('auth/fetchUser');

      if (!store.getters['auth/isAuthenticated']) {
        next({ name: 'Login' });
      } else {
        next();
      }

    } else if (to.name === 'Login') {
        if (store.getters['auth/isAuthenticated']) {
            next({ name: 'Dashboard' });
        } else {
            await store.dispatch('auth/fetchUser');

            if (store.getters['auth/isAuthenticated']) {
                next({ name: 'Dashboard' });
            } else {
                next();
            }
        }
    } else {
        next();
    }
  });

export default router;
