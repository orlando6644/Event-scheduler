<template>
    <div class="flex min-h-screen bg-gray-100">
        <!-- Sidebar -->
        <Sidebar />

        <!-- Main Content -->
        <div class="flex flex-col flex-1">
            <!-- Header -->
            <Header />

            <!-- Content -->
            <main class="flex-1 p-4">
                <slot />
            </main>

            <!-- Footer -->
            <Footer />
        </div>
    </div>
</template>

<script setup>
import Sidebar from './Sidebar.vue'
import Header from './Header.vue'
import Footer from './Footer.vue'
</script>
