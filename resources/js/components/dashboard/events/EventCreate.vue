<template>
    <div class="flex items-center justify-center bg-gray-100 pt-10">
        <div class="w-full max-w-lg p-6 bg-white rounded-md shadow-md">
            <h1 class="mb-6 text-2xl font-bold text-center">Create New Event</h1>
            <form @submit.prevent="submitEvent">
                <div class="mb-4">
                    <label for="title" class="block mb-2 text-sm font-medium text-gray-700">
                        Title <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="title"
                        v-model="form.title"
                        class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-200"
                        placeholder="Event Title"
                        required
                        maxlength="255"
                    />
                </div>
                <div class="mb-4">
                    <label for="description" class="block mb-2 text-sm font-medium text-gray-700">
                        Description
                    </label>
                    <textarea
                        id="description"
                        v-model="form.description"
                        class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-200"
                        placeholder="Event Description"
                        rows="4"
                    ></textarea>
                </div>
                <div class="mb-4">
                    <label for="start_date" class="block mb-2 text-sm font-medium text-gray-700">
                        Date & Time <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="datetime-local"
                        id="start_date"
                        v-model="form.start_date"
                        class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-200"
                        required
                    />
                </div>
                <div class="mb-6">
                    <label for="location" class="block mb-2 text-sm font-medium text-gray-700">
                        Location
                    </label>
                    <input
                        type="text"
                        id="location"
                        v-model="form.location"
                        class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-200"
                        placeholder="Event Location"
                        maxlength="255"
                    />
                </div>
                <form-submit-button :loading="loading" buttonText="Create Event" />
            </form>
            <div v-if="errors" class="mt-4 text-center text-red-500">
                <ul>
                    <li v-for="(err, index) in errors" :key="index">{{ err }}</li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script setup>
import { reactive, ref } from "vue";
import FormSubmitButton from '@/components/commons/FormSubmitButton.vue';
import { showSuccessToast } from "@/utils/notifications";

const errors = ref(null);
const loading = ref(false);

const form = reactive({
  title: "",
  description: "",
  start_date: "",
  location: "",
});

const submitEvent = async (e) => {
    e.preventDefault();
    clearFormError();

    loading.value = true;

    try {
        const { data } = await axios.post('/api/events', form);
        showSuccessToast(data.message);
        clearForm();

    } catch (error) {
        if(error.response.status === 422) {
            const validationErrors = error.response.data.errors || {};
            errors.value = Object.values(validationErrors).flat();
        } else {
            errors.value = [error.response.data.message || 'An error occurred. Please try again.'];
        }
    } finally {
        loading.value = false;
    }
};

const clearFormError = () => {
    errors.value = null;
};

const clearForm = () => {
    form.title = "";
    form.description = "";
    form.start_date = "";
    form.location = "";
};
</script>
