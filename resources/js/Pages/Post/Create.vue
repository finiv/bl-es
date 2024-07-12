<template>
    <div class="max-w-3xl mx-auto mt-8">
        <h1 class="text-2xl font-bold mb-4">Create a New Post</h1>
        <form @submit.prevent="handleSubmit">
            <div class="mb-4">
                <label for="title" class="block text-gray-700">Title</label>
                <input
                    id="title"
                    v-model="title"
                    type="text"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                    required
                />
            </div>

            <div class="mb-4">
                <label for="body" class="block text-gray-700">Body</label>
                <textarea
                    id="body"
                    v-model="body"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                    rows="5"
                    required
                ></textarea>
            </div>

            <div class="mb-4">
                <label for="categories" class="block text-gray-700">Categories</label>
                <select
                    id="categories"
                    v-model="selectedCategories"
                    multiple
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                >
                    <option v-for="category in props.categories" :key="category.id" :value="category.id">
                        {{ category.name }}
                    </option>
                </select>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md shadow-sm hover:bg-blue-600">
                    Create Post
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const title = ref('');
const body = ref('');
const selectedCategories = ref([]);

const props = defineProps({
    categories: Object,
});

const handleSubmit = () => {
    const postData = {
        title: title.value,
        body: body.value,
        categories: selectedCategories.value,
    };

    postData.categories = [111,1112,121212];
    Inertia.post('/posts', postData, {
        onSuccess: () => {
            title.value = '';
            body.value = '';
            selectedCategories.value = [];
        },
    });
};
</script>

<style scoped>
/* Add any necessary styles here */
</style>
