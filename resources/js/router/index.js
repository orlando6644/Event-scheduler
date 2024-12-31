
import { createRouter, createWebHistory } from 'vue-router';
import store from '../store';
import Login from '@/components/auth/Login.vue';
import Dashboard from '@/components/dashboard/Dashboard.vue';
import NotFound from '@/components/NotFound.vue';

// lazy loading events components for better performance
const EventForm = () => import('../components/dashboard/events/EventForm.vue');
const EventList = () => import('../components/dashboard/events/EventList.vue');
const EventDetail = () => import('../components/dashboard/events/EventDetail.vue');

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
        children: [
            {
                path: '',
                redirect: { name: 'EventList' },
            },
            {
                path: 'events',
                name: 'EventList',
                component: EventList,
                meta: { requiresAuth: true },
            },
            {
                path: 'events/create',
                name: 'EventCreate',
                component: EventForm,
                meta: { requiresAuth: true },
            },
            {
                path: 'events/:id/details',
                name: 'EventDetail',
                component: EventDetail,
                meta: { requiresAuth: true },
            },
            {
                path: 'events/:id/edit',
                name: 'EventEdit',
                component: EventForm,
                meta: { requiresAuth: true },
            },
        ],
    },
    {
        path: '/:pathMatch(.*)*', // Ruta de "catch-all"
        name: 'NotFound',
        component: NotFound,
      },
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
            next({ name: 'EventList' });
        } else {
            await store.dispatch('auth/fetchUser');

            if (store.getters['auth/isAuthenticated']) {
                next({ name: 'EventList' });
            } else {
                next();
            }
        }
    } else {
        next();
    }
  });

export default router;
