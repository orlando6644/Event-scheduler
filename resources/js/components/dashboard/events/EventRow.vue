<template>
    <tr class="hover:bg-gray-50">
      <td class="px-4 py-2 text-sm text-gray-700 border border-gray-200">{{ event.id }}</td>
      <td class="px-4 py-2 text-sm text-gray-700 border border-gray-200">{{ event.title }}</td>
      <td class="px-4 py-2 text-sm text-gray-700 border border-gray-200">{{ event.start_date }}</td>
      <td class="px-4 py-2 text-sm text-gray-700 border border-gray-200">{{ event.location ?? notAvailableString }}</td>
      <td class="px-4 py-2 text-sm text-gray-700 border border-gray-200">{{ getUserName(event.user) }}</td>
      <td class="px-4 py-2 text-sm text-gray-700 border border-gray-200">
        <button
          class="px-2 py-1 text-xs font-semibold text-white bg-blue-500 rounded hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-200"
          @click="$emit('view', event.id)"
        >
          View
        </button>
        <button
            v-if="isUserEvent()"
            class="px-2 py-1 ml-2 text-xs font-semibold text-white bg-yellow-500 rounded hover:bg-yellow-600 focus:outline-none focus:ring focus:ring-yellow-200"
            @click="$emit('edit', event.id)"
        >
          Edit
        </button>
        <button
            v-if="isUserEvent()"
            class="px-2 py-1 ml-2 text-xs font-semibold text-white bg-red-500 rounded hover:bg-red-600 focus:outline-none focus:ring focus:ring-red-200"
            @click="$emit('delete', event.id)"
        >
          Delete
        </button>
      </td>
    </tr>
  </template>

<script setup>
import { defineProps } from 'vue';
import { notAvailableString } from '@/utils/constants';

const props = defineProps({
    event: Object,
    index: Number,
    userId: {
        type: Number,
        default: 0,
    }
});
const getUserName = (user) => {
    if (user) {
        return isUserEvent() ? 'Me' : user.name;
    }

    return 'Unknown';
}

const isUserEvent = () => {
    return props.userId === props.event.user_id;
}

</script>
