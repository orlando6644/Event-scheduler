<template>
    <Layout>
        <router-view></router-view>
    </Layout>
</template>

<script setup>
import Layout from './layouts/Layout.vue'
import { onMounted } from 'vue';
import { pusher } from '@/plugins/pusher';
import { showEventUpdateToast } from '@/utils/notifications';
import eventBus from '@/plugins/eventBus';

onMounted(() => {
    subscribeToPusherChannels();
});

/*
* Subscribe to pusher channels to listen for event updates.
*/
const subscribeToPusherChannels = () => {
    console.log("Subscribing to pusher channels...");
    const channel = pusher.subscribe('events');

    channel.bind('event.created', (data) => {
        eventBus.emit('event-created', data.event);
        showEventUpdateToast(`New event "${data.event.title}" has been created!`);
    });

    channel.bind('event.updated', (data) => {
        eventBus.emit('event-updated', data.event);
        showEventUpdateToast(`Event "${data.event.title}" has been updated!`);
    });

    channel.bind('event.deleted', (data) => {
        eventBus.emit('event-deleted', data.event);
        showEventUpdateToast(`Event "${data.event.title}" has been deleted!`);
    });
};
</script>
