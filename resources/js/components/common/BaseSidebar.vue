<template>
    <aside class="w-64">
        <div class="h-full px-3 py-4 overflow-y-auto">
            <ul class="space-y-2 font-medium">
                <li>
                    <router-link to="/profile" class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-gray-100 hover:bg-gray-700">
                        <span class="ml-3">Profile</span>
                    </router-link>
                </li>
                <li>
                    <router-link to="/im" class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-gray-100 hover:bg-gray-700">
                        <span class="ml-3">Messenger</span>
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
}
</style>
