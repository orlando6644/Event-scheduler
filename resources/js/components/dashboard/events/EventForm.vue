<template>
    <div class="flex items-center justify-center bg-gray-100 pt-10">
        <div class="w-full max-w-lg p-6 bg-white rounded-md shadow-md">
            <BackToListLink />
            <h1 class="mb-6 text-2xl font-bold text-center">{{ formTitle }}</h1>
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
                <form-submit-button :loading="loading" :buttonText="buttonTitle" />
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
import { onMounted, reactive, ref } from "vue";
import { useRouter } from "vue-router";
import { useStore } from 'vuex';
import FormSubmitButton from '@/components/commons/FormSubmitButton.vue';
import { showSuccessToast, showErrorToast } from '@/utils/notifications';
import BackToListLink from "./BackToListLink.vue";
import { formatDateToDateTimeLocal } from "@/utils/dateUtils";

const router = useRouter();
const store = useStore();

const eventId = router.currentRoute.value.params.id || null;

const formTitle = eventId ? "Edit Event" : "Create Event";
const buttonTitle = eventId ? "Update Event" : "Create Event";

const errors = ref(null);
const loading = ref(false);
const form = reactive({
  title: "",
  description: "",
  start_date: "",
  location: "",
});

onMounted(async() => {
    if (eventId) {
        try {
            const { data } = await axios.get(`/api/events/${eventId}`);

            if (data.data.user_id !== store.getters['auth/user']?.id) {
                showErrorToast('You are not authorized to edit this event.');
                router.push({ name: 'EventList' });
            }

            form.title = data.data.title;
            form.description = data.data.description;
            form.start_date = formatDateToDateTimeLocal(data.data.start_date)
            form.location = data.data.location;
        } catch (error) {
            showErrorToast('The event was not found.');
            router.push({ name: 'EventList' });
        } finally {
            loading.value = false;
        }
    }
});

const submitEvent = async(e) => {
    e.preventDefault();
    clearFormError();

    loading.value = true;

    try {
        const { data } = await axios({
            method: eventId ? 'PUT' : 'POST',
            url: eventId ? `/api/events/${eventId}` : '/api/events',
            data: form
        });
        showSuccessToast(data.message);
        clearForm();
        router.push({ name: 'EventList' });

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
}

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
