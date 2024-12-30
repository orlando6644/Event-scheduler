<template>
    <button
        type="submit"
        :disabled="loading"
        class="w-full px-4 py-2 font-semibold text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring focus:ring-indigo-200"
    >
        <span v-if="loading" class="flex items-center justify-center">
            <loading-spinner />
            {{ loadingText }}
        </span>
        <span v-else>{{ buttonText }}</span>
    </button>
</template>
<script setup>
import { defineProps } from 'vue';
import LoadingSpinner from '@/components/commons/LoadingSpinner.vue';

const props = defineProps({
    loading: {
        type: Boolean,
        default: false,
    },
    buttonText: {
        type: String,
        default: 'Submit',
    },
    loadingText: {
        type: String,
        default: 'Loading...',
    },

});
</script>
