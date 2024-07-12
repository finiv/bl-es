<template>
    <div class="max-w-3xl mx-auto mt-8">
        <h1 class="text-2xl font-bold mb-4">{{ post.title }}</h1>
        <p class="text-gray-600 mb-4">{{ post.created_at }}</p>
        <p class="mb-4">{{ post.body }}</p>
        <Link href="/dashboard" class="text-blue-500 hover:underline">Go to Home</Link>
    </div>
</template>

<script setup>
import {Link} from '@inertiajs/vue3';

const props = defineProps({
    post: Object,
});

</script>
