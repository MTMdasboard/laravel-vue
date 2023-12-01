<script setup>
import RouterButton from "@/Components/RouterButton.vue";
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head } from '@inertiajs/vue3';

</script>

<template>
    <GuestLayout>
        <Head :title="$t('Error')" />

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex justify-center">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div
                    class="p-2 sm:p-6 text-gray-600 text-center font-semibold"
                >
                    <h1 class="text-lg text-red-700">{{ $t('Error') }}</h1>
                    
                    <p>{{ $page.props.error }}</p>

                    <RouterButton
                        :href="route('welcome')"
                        class="mt-4"
                    >
                        {{ $t("To home") }}
                    </RouterButton>
                </div>
            </div>
        </div>

    </GuestLayout>
</template>
