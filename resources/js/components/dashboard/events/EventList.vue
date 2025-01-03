<template>
    <div class="flex items-center justify-center bg-gray-100 pt-10">
        <div class="w-full max-w-5xl p-6 bg-white rounded-md shadow-md">
            <div class="flex items-center justify-between mb-6">
                <select v-model="sortOrder" @change="handleSortChange" class="mr-4 px-4 py-2 border rounded-md focus:outline-none focus:ring focus:ring-indigo-200">
                    <option value="recent">Created Recently</option>
                    <option value="upcoming">Upcoming Events</option>
                </select>
                <button
                    class="px-4 py-2 text-sm font-semibold text-white bg-indigo-500 rounded hover:bg-indigo-600 focus:outline-none focus:ring focus:ring-indigo-200"
                    @click="navigateToCreate"
                >
                    + Create Event
                </button>
            </div>
            <div v-if="isLoading" class="flex justify-center items-center">
                <ColorLoadingSpinner />
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
                <tbody v-if="events.data?.length > 0 && !isLoading">
                    <EventRow
                        v-for="(event, index) in events.data"
                        :key="event.id"
                        :event="event"
                        :index="index + 1"
                        :userId="store.getters['auth/user']?.id"
                        @view="viewEvent"
                        @edit="editEvent"
                        @delete="confirmDeleteEvent"
                    />
                </tbody>
                <tbody v-else>
                    <tr>
                        <td class="px-4 py-2 text-center text-sm font-medium text-gray-600 border border-gray-200" colspan="6">No events found.</td>
                    </tr>
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
import { showErrorToast, showConfirmationDialog, showSuccessToast } from '@/utils/notifications';
import ColorLoadingSpinner from '@/components/commons/ColorLoadingSpinner.vue';
import eventBus from '@/plugins/eventBus';

const router = useRouter();
const store = useStore();

const events = ref([]);
const isLoading = ref(false);
const sortOrder = ref('recent');

onMounted(() => {
    fetchEvents();

    eventBus.on('event-updated', handleEventUpdate);
    eventBus.on('event-created', handleEventCreate);
    eventBus.on('event-deleted', handleEventDelete);
});

const fetchEvents = async(page = 1) => {

    isLoading.value = true;

    try {
        const { data } = await axios.get(`/api/events?page=${page}&sortBy=${sortOrder.value}`);
        events.value = data.data;
    } catch (error) {
        showErrorToast('Failed to fetch events.');
    } finally {
        isLoading.value = false;
    }
};

/**
 * Users can sort events by recent or upcoming.
 */
const handleSortChange = () => {
    fetchEvents();
};

const navigateToCreate = () => {
    router.push("/dashboard/events/create");
};

const viewEvent = (id) => {
    router.push({ name: 'EventDetail', params: { id } });
};

const editEvent = (id) => {
    router.push({ name: 'EventEdit', params: { id } });
};

const confirmDeleteEvent = async(id) => {
    const result = await showConfirmationDialog('Are you sure?', 'You won\'t be able to revert this!');
    if (result.isConfirmed) {
        deleteEvent(id);
    }
};

const deleteEvent = async(id) => {

    isLoading.value = true;

    try {
        const { data } = await axios.delete(`/api/events/${id}`);
        fetchEvents();
        showSuccessToast(data.message);
    } catch (error) {
        showErrorToast('Failed to delete event.');
    } finally {
        isLoading.value = false;
    }
};

const handleEventUpdate = (event) => {
    const index = events.value.data.findIndex(e => e.id === event.id);
    if (index !== -1) {
        events.value.data[index] = event;
    }
};

const handleEventCreate = (event) => {
    events.value.data.unshift(event);
};

const handleEventDelete = (event) => {
    events.value.data = events.value.data.filter(e => e.id !== event.id);
};

</script>
