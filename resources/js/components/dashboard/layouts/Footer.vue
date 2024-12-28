<template>
    <footer class="p-4 bg-white shadow-md">
        <div class="text-center text-gray-600">© Copyright {{ currentYear }}</div>
    </footer>
</template>

<script setup>
const currentYear = new Date().getFullYear();
</script>
