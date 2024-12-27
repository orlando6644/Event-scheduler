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
                        class="w-full py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400"
                    >
                        Log in
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

import axios from "axios";
import { ref } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();
const error = ref(null);
const email = ref("");
const password = ref("");

const handleSubmit = async (e) => {
    e.preventDefault();

    if (!validateForm()) return;

    try {
        const { data } = await axios.post("/api/login", {
            email: email.value,
            password: password.value,
        });

        // Save token to local storage

        router.push({ name: "Dashboard" });

    } catch (err) {
        error.value = err.response?.data?.message;
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
