<template>
    <aside class="w-64">
        <div class="h-full px-3 py-4 overflow-y-auto">
            <ul class="space-y-2 font-medium">
                <li>
                    <router-link to="/" class="flex group items-center p-2 text-white rounded-lg dark:text-white hover:bg-gray-700">
                        <span class="ml-3 transition group-hover:translate-x-2">Home</span>
                    </router-link>
                </li>
                <li>
                    <router-link to="/profile" class="flex group items-center p-2 text-white rounded-lg dark:text-white hover:bg-gray-700">
                        <span class="ml-3 transition group-hover:translate-x-2">Profile</span>
                    </router-link>
                </li>
                <li>
                    <router-link to="/im" class="flex group items-center p-2 text-white rounded-lg dark:text-white hover:bg-gray-700">
                        <span class="ml-3 transition group-hover:translate-x-2">Messenger</span>
                    </router-link>
                </li>
                <li>
                    <router-link to="/followers" class="flex group items-center p-2 text-white rounded-lg dark:text-white hover:bg-gray-700">
                        <span class="ml-3 transition group-hover:translate-x-2">Followers</span>
                    </router-link>
                </li>
                <li>
                    <router-link to="/following" class="flex group items-center p-2 text-white rounded-lg dark:text-white hover:bg-gray-700">
                        <span class="ml-3 transition group-hover:translate-x-2">Following</span>
                    </router-link>
                </li>
            </ul>
        </div>
    </aside>
</template>

<script setup>

</script>

<style lang="scss" scoped>
.router-link-active {
    @apply bg-gray-700;
    span {
        transform: none !important;
    }

}
</style>
