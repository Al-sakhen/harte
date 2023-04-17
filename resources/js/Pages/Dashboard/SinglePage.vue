
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';


</script>

<script>
export default {
    // components: { AuthenticatedLayout }
}
</script>



<template>
    <Head title="Single" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Single page
            </h2>
        </template>


        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">{{ $page.component }}</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

