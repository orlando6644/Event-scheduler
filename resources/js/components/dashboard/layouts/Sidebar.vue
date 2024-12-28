<template>
    <aside class="w-64 bg-black text-white">
        <div class="p-4 text-2xl font-bold">
            Dashboard
        </div>
        <nav class="mt-4">
            <ul>
                <router-link
                    to="/dashboard/events"
                    v-slot="{ navigate }"
                >
                    <li @click="navigate" class="px-4 py-2 cursor-pointer hover:bg-gray-800">
                        Events
                    </li>
                </router-link>
            </ul>
        </nav>
    </aside>
</template>
