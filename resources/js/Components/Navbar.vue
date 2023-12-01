<script setup>
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import LocaleSelector from "@/Components/LocaleSelector.vue";
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import ApplicationLogo from "@/Components/media/ApplicationLogo.vue";
import { Bars3Icon, ChevronDownIcon, XMarkIcon } from "@heroicons/vue/24/solid";
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";

const showingNavigationDropdown = ref(false);
</script>

<template>
    <nav class="bg-white border-b border-gray-100 navbar">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex h-16">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <Link :href="route('dashboard')">
                        <ApplicationLogo
                            class="block h-9 w-auto fill-current text-gray-800"
                        />
                    </Link>
                </div>

                <div class="grid w-full grid-cols-2">
                    <!-- Navigation Links -->
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <NavLink
                            :href="route('welcome')"
                            :active="route().current('welcome')"
                        >
                            {{ $t("home") }}
                        </NavLink>

                        <NavLink
                            v-if="$page.props.auth.user"
                            :href="route('dashboard')"
                            :active="route().current('dashboard')"
                        >
                            {{ $t("Dashboard") }}
                        </NavLink>

                        <NavLink
                            :href="route('files')"
                            :active="route().current('files')"
                        >
                            {{ $t("Files") }}
                        </NavLink>

                        <NavLink
                            :href="route('news')"
                            :active="route().current('news')"
                        >
                            {{ $t("News") }}
                        </NavLink>
                    </div>

                    <div class="col-start-2 flex justify-end items-center">
                        <!-- Locale Selector -->
                        <LocaleSelector />

                        <!-- --- -->
                        <div v-if="$page.props.auth.user">
                            <div class="hidden sm:flex sm:items-center sm:ms-6">
                                <!-- Settings Dropdown -->
                                <div class="ms-3 relative">
                                    <Dropdown align="right" width="48">
                                        <template #trigger>
                                            <span
                                                class="inline-flex rounded-md"
                                            >
                                                <button
                                                    type="button"
                                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                                >
                                                    {{
                                                        $page.props.auth.user
                                                            .name
                                                    }}

                                                    <ChevronDownIcon
                                                        class="ms-2 -me-0.5 h-4 w-4"
                                                        fill="currentColor"
                                                    />
                                                </button>
                                            </span>
                                        </template>

                                        <template #content>
                                            <DropdownLink
                                                :href="route('profile.edit')"
                                            >
                                                {{ $t("Profile") }}
                                            </DropdownLink>
                                            <DropdownLink
                                                :href="route('logout')"
                                                method="post"
                                                as="button"
                                            >
                                                {{ $t("Log Out") }}
                                            </DropdownLink>
                                        </template>
                                    </Dropdown>
                                </div>
                            </div>

                            <!-- Hamburger -->
                            <div class="-me-2 flex items-center sm:hidden">
                                <button
                                    @click="
                                        showingNavigationDropdown =
                                            !showingNavigationDropdown
                                    "
                                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                                >
                                    <XMarkIcon
                                        v-if="showingNavigationDropdown"
                                        class="h-6 w-6"
                                        stroke="currentColor"
                                        fill="none"
                                    />
                                    <Bars3Icon
                                        v-else
                                        class="h-6 w-6"
                                        stroke="currentColor"
                                        fill="none"
                                    />
                                </button>
                            </div>
                        </div>

                        <!-- --- -->
                        <template v-else>
                            <div
                                class="space-x-2 sm:space-x-8 sm:-my-px sm:ms-10 flex"
                            >
                                <NavLink
                                    :href="route('login')"
                                    :active="route().current('login')"
                                >
                                    {{ $t("Login") }}
                                </NavLink>

                                <NavLink
                                    :href="route('register')"
                                    :active="route().current('register')"
                                >
                                    {{ $t("Register") }}
                                </NavLink>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div
            v-if="$page.props.auth.user"
            :class="{
                block: showingNavigationDropdown,
                hidden: !showingNavigationDropdown,
            }"
            class="sm:hidden"
        >
            <div class="pt-2 pb-3 space-y-1">
                <ResponsiveNavLink
                    :href="route('dashboard')"
                    :active="route().current('dashboard')"
                >
                    {{ $t("Dashboard") }}
                </ResponsiveNavLink>
                <ResponsiveNavLink
                    :href="route('files')"
                    :active="route().current('files')"
                >
                    {{ $t("Files") }}
                </ResponsiveNavLink>
                <ResponsiveNavLink
                    :href="route('news')"
                    :active="route().current('news')"
                >
                    {{ $t("News") }}
                </ResponsiveNavLink>
            </div>

            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">
                        {{ $page.props.auth.user.name }}
                    </div>
                    <div class="font-medium text-sm text-gray-500">
                        {{ $page.props.auth.user.email }}
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <ResponsiveNavLink :href="route('profile.edit')">
                        {{ $t("Profile") }}
                    </ResponsiveNavLink>
                    <ResponsiveNavLink
                        :href="route('logout')"
                        method="post"
                        as="button"
                    >
                        {{ $t("Log Out") }}
                    </ResponsiveNavLink>
                </div>
            </div>
        </div>
    </nav>
</template>
