<script setup>
import Navbar from "@/Components/Navbar.vue";
</script>

<template>
    <div>
        <div
            class="min-h-screen flex flex-col items-center justify-between bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900"
        >
            <div class="w-full">
                <!-- Navbar -->
                <Navbar />

                <!-- Page Heading -->
                <header class="bg-white shadow" v-if="$slots.header">
                    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                        <slot name="header" />
                    </div>
                </header>
            </div>

            <!-- Page Content -->
            <main class="flex w-full">
                <slot />
            </main>

            <!-- Page Footer -->
            <footer class="bg-white shadow flex w-full">
                <div
                    class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 text-gray-500 text-center"
                >
                    <span class="font-bold">©</span>
                    <span> {{ $t("Created for demonstration") }} </span>
                    <span class="font-semibold"> Мажитов Т. М.</span>
                </div>
            </footer>
        </div>
    </div>
</template>

<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}

@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style>
