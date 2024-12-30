<template>
    <div class="flex items-center justify-center bg-gray-100 pt-10">
        <div class="w-full max-w-5xl p-6 bg-white rounded-md shadow-md">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold">Event List</h1>
                <button
                    class="px-4 py-2 text-sm font-semibold text-white bg-indigo-500 rounded hover:bg-indigo-600 focus:outline-none focus:ring focus:ring-indigo-200"
                    @click="navigateToCreate"
                >
                    + Create Event
                </button>
            </div>
            <div v-if="isLoading" class="flex justify-center items-center">
                <svg class="animate-spin h-8 w-8 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
            <table v-else class="w-full table-auto border-collapse border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600 border border-gray-200">#</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600 border border-gray-200">Title</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600 border border-gray-200">Date/Time</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600 border border-gray-200">Location</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600 border border-gray-200">Created By</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600 border border-gray-200">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <EventRow
                        v-for="(event, index) in events.data"
                        :key="event.id"
                        :event="event"
                        :index="index + 1"
                        :userId="store.getters['auth/user']?.id"
                        @view="viewEvent"
                        @edit="editEvent"
                        @delete="deleteEvent"
                    />
                </tbody>
            </table>
            <div class="mt-4 flex justify-center">
                <TailwindPagination
                    :data="events"
                    @pagination-change-page="fetchEvents"
                    class="mt-4"
                />
            </div>
        </div>
    </div>
</template>

<script setup>
import { TailwindPagination } from 'laravel-vue-pagination';
import { onMounted, ref } from "vue";
import { useRouter } from "vue-router";
import EventRow from "./EventRow.vue";
import { useStore } from 'vuex';
import { showErrorToast } from '@/utils/notifications';


const router = useRouter();
const store = useStore();

const events = ref([]);
const isLoading = ref(false);

onMounted(() => {
    fetchEvents();
});

const fetchEvents = async(page = 1) => {

    isLoading.value = true;

    try {
        const { data } = await axios.get(`/api/events?page=${page}`);
        events.value = data.data;
    } catch (error) {
        showErrorToast('Failed to fetch events.');
    } finally {
        isLoading.value = false;
    }
};

const navigateToCreate = () => {
    router.push("/dashboard/events/create");
};

const viewEvent = (id) => {
    console.log(`Viewing event ${id}`);
};

const editEvent = (id) => {
    console.log(`Editing event ${id}`);
};

const deleteEvent = (id) => {
    console.log(`Deleting event ${id}`);
};
  </script>
