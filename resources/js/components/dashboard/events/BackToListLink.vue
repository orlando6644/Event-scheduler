<template>
    <div class="mb-4">
        <button
            @click="goBack"
            class="flex items-center text-sm font-medium text-blue-500 hover:underline"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-4 h-4 mr-1"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15 19l-7-7 7-7"
                />
            </svg>
            Back to List
        </button>
    </div>
</template>
<script setup>
import { useRouter } from "vue-router";

const router = useRouter();

const goBack = () => {
    router.push("/dashboard/events");
};
</script>
