<template>
    <div class="p-6 max-w-3xl mx-auto bg-white rounded shadow-md">
        <BackToListLink />
        <div v-if="isLoading" class="flex justify-center items-center">
            <ColorLoadingSpinner />
        </div>
        <div class="mt-4" v-else>
            <h1 class="text-3xl font-bold text-gray-800">{{ event?.title }}</h1>
            <div class="mt-2 flex items-center text-gray-600">
                <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 4h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span>{{ formatDate(event?.start_date) }}</span>
            </div>
            <div class="mt-2 flex items-center text-gray-600">
                <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2C8.686 2 6 4.686 6 8c0 4.418 6 12 6 12s6-7.582 6-12c0-3.314-2.686-6-6-6zM12 10a2 2 0 110-4 2 2 0 010 4z"></path>
                </svg>
                <span>{{ event?.location ?? notAvailableString }}</span>
            </div>
            <div class="mt-2 flex items-center text-gray-600">
                <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A1 1 0 016 17h12a1 1 0 01.879 1.516l-6 10a1 1 0 01-1.758 0l-6-10A1 1 0 015.121 17.804zM12 2a5 5 0 100 10 5 5 0 000-10z"></path>
                </svg>
                <b>{{ event?.user?.name }}</b>
            </div>
            <div class="mt-4 text-gray-700" v-show="event?.description">
                <p>{{ event?.description }}</p>
            </div>
        </div>
    </div>
</template>
<script setup>
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import { showErrorToast } from '@/utils/notifications';
import { notAvailableString } from '@/utils/constants';
import ColorLoadingSpinner from '@/components/commons/ColorLoadingSpinner.vue';
import BackToListLink from '@/components/dashboard/events/BackToListLink.vue';

const router = useRouter();

const event = ref(null);
const isLoading = ref(false);

onMounted(async () => {
    const eventId = router.currentRoute.value.params.id;

    isLoading.value = true;

    try {
        const { data } = await axios.get(`/api/events/${eventId}`);
        event.value = data.data;
    } catch (error) {
        showErrorToast('Failed to fetch event details.');
    } finally {
        isLoading.value = false;
    }
});

const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
    return new Date(dateString).toLocaleDateString(undefined, options);
};
</script>
