<template>
    <header class="flex items-center justify-between p-4 bg-white shadow-md">
        <div class="text-xl">Welcome, <b>{{ userName }}</b></div>
        <button @click="logout" class="px-4 py-2 font-semibold text-white bg-red-600 rounded-md hover:bg-red-700">Logout</button>
    </header>
</template>
<script setup>
import { computed } from 'vue';
import { useRouter } from 'vue-router';
import { useStore } from 'vuex';

const store = useStore();
const router = useRouter();

const userName = computed(() => store.getters['auth/user']?.name);

const logout = async () => {
    await store.dispatch('auth/logout');
    router.push({ name: 'Login' });
};
</script>
