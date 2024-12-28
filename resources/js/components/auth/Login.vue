<template>
    <div class="min-h-screen bg-gray-100 flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-sm">
            <h2 class="text-2xl font-semibold text-center text-gray-700 mb-6">
                Log in
            </h2>
            <form @submit="handleSubmit">
                <div class="mb-4">
                    <label for="email" class="block text-gray-600">Email</label>
                    <input
                        id="email"
                        type="email"
                        class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
                        placeholder="Enter your email"
                        v-model="email"
                        @input="clearFormError"
                        required
                    />
                </div>
                <div class="mb-6">
                    <label for="password" class="block text-gray-600">Password</label>
                    <input
                        id="password"
                        type="password"
                        class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
                        placeholder="Enter your password"
                        v-model="password"
                        @input="clearFormError"
                        required
                    />
                </div>
                <div>
                    <button
                        type="submit"
                        :disabled="isLoading"
                        class="w-full px-4 py-2 font-semibold text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring focus:ring-indigo-200"
                    >
                        <span v-if="isLoading" class="flex items-center justify-center">
                            <loading-spinner />
                            Loading...
                        </span>
                        <span v-else>Login</span>
                    </button>
                </div>
            </form>
            <div v-if="error" class="mt-4 text-center text-red-500">
                <p>{{ error }}</p>
            </div>
        </div>
    </div>
</template>
<script setup>

import { ref } from "vue";
import { useRouter } from "vue-router";
import { useStore } from 'vuex';
import LoadingSpinner from "@/components/commons/LoadingSpinner.vue";

const store = useStore();
const router = useRouter();
const email = ref("");
const password = ref("");
const error = ref(null);
const isLoading = ref(false);

const handleSubmit = async (e) => {
    e.preventDefault();

    if (!validateForm()) return;

    isLoading.value = true;

    try {
        await store.dispatch('auth/login', {
            email: email.value,
            password: password.value,
        });

        router.push({ name: 'Dashboard' });
    } catch (err) {
        error.value = err.message;
    } finally {
        isLoading.value = false;
    }
};

const validateForm = () => {
    if (!email.value || !password.value) {
        error.value = "Please enter your email and password";
        return false;
    }

    return true;
};

const clearFormError = () => {
    error.value = null;
};

</script>
