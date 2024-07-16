<template>
    <AuthenticatedLayout>
        <Head title="Dashboard"/>
        <div class="max-w-3xl mx-auto mt-8 p-6 bg-white shadow-md rounded-md">
            <h1 class="text-2xl font-bold mb-4">Create a New Post</h1>
            <form @submit.prevent="handleSubmit">
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 font-medium">Title</label>
                    <input
                        id="title"
                        v-model="title"
                        type="text"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200"
                        required
                    />
                </div>

                <div class="mb-4">
                    <label for="body" class="block text-gray-700 font-medium">Body</label>
                    <textarea
                        id="body"
                        v-model="body"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200"
                        rows="5"
                        required
                    ></textarea>
                </div>

                <div class="mb-4">
                    <label for="categories" class="block text-gray-700 font-medium">Categories</label>
                    <select
                        id="categories"
                        v-model="selectedCategories"
                        multiple
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200"
                    >
                        <option v-for="category in props.categories" :key="category.id" :value="category.id">
                            {{ category.name }}
                        </option>
                    </select>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-200">
                        Create Post
                    </button>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";

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
/* Стилі для основної форми */
.max-w-3xl {
    max-width: 768px;
}
.mt-8 {
    margin-top: 2rem;
}
.p-6 {
    padding: 1.5rem;
}
.bg-white {
    background-color: #ffffff;
}
.shadow-md {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}
.rounded-md {
    border-radius: 0.375rem;
}

/* Стилі для текстових елементів */
.text-2xl {
    font-size: 1.5rem;
}
.font-bold {
    font-weight: 700;
}
.mb-4 {
    margin-bottom: 1rem;
}
.text-gray-700 {
    color: #4a5568;
}
.font-medium {
    font-weight: 500;
}

/* Стилі для інпутів і текстових областей */
.block {
    display: block;
}
.w-full {
    width: 100%;
}
.mt-1 {
    margin-top: 0.25rem;
}
.border {
    border-width: 1px;
}
.border-gray-300 {
    border-color: #d2d6dc;
}
.rounded-md {
    border-radius: 0.375rem;
}
.shadow-sm {
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
}
.focus\:ring {
    outline: 2px solid transparent;
    outline-offset: 2px;
}
.focus\:ring-blue-200 {
    box-shadow: 0 0 0 2px rgba(191, 219, 254, 1);
}

/* Стилі для кнопок */
.bg-blue-500 {
    background-color: #3b82f6;
}
.text-white {
    color: #ffffff;
}
.hover\:bg-blue-600:hover {
    background-color: #2563eb;
}
.focus\:outline-none {
    outline: 0;
}
.focus\:ring-blue-200 {
    box-shadow: 0 0 0 2px rgba(191, 219, 254, 1);
}
</style>
