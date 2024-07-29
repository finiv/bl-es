<template>
    <AuthenticatedLayout>
        <Head title="Dashboard"/>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex flex-col sm:flex-row sm:justify-between items-center mb-6">
                            <h1 class="text-2xl font-bold mb-4 sm:mb-0">Posts</h1>
                            <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-4 w-full filters">
                                <div style="display: flex; margin: 5px;">
                                    <input v-model="searchQuery" @input="handleSearchInput" placeholder="Search posts..." class="input-field mb-4 sm:mb-0 sm:flex-1"/>
                                    <multiselect
                                        v-model="selectedCategories"
                                        :options="categories"
                                        :multiple="true"
                                        label="name"
                                        track-by="id"
                                        placeholder="Select categories"
                                        @select="handleCategoryChange"
                                        class="input-field mb-4 sm:mb-0 sm:flex-1"
                                    />
                                </div>

                                <Link :href="'/posts/create'" class="create-post-btn mb-4 sm:mb-0">
                                    Create post
                                </Link>
                            </div>
                        </div>
                        <ul class="space-y-6">
                            <li v-for="post in posts" :key="post.id" class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-md">
                                <div class="flex">
                                    <img src="/path-to-placeholder-image.jpg" alt="Post Image" class="w-1/3 object-cover h-48">
                                    <div class="p-4 w-2/3">
                                        <Link :href="`/posts/${post.id}`" class="text-xl font-semibold text-blue-500 hover:underline">
                                            <strong>{{ post.categories }}</strong><br>{{ post.title }}
                                        </Link>
                                        <p class="mt-2 text-gray-700">{{ post.body ? post.body.substring(0, 100) : '' }}...</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="mt-6 flex justify-between items-center" v-if="pagination && pagination.links">
                            <button
                                v-if="pagination.links.prev"
                                @click="searchPosts(pagination.current_page - 1)"
                                class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300"
                            >
                                Previous
                            </button>
                            <span>Page {{ pagination.current_page }} of {{ pagination.last_page }}</span>
                            <button
                                v-if="pagination.links.next"
                                @click="searchPosts(pagination.current_page + 1)"
                                class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300"
                            >
                                Next
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import {Head, Link, usePage} from '@inertiajs/vue3';
import {ref, onMounted} from 'vue';
import axios from 'axios';
import Multiselect from 'vue-multiselect';
import 'vue-multiselect/dist/vue-multiselect.css';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const page = usePage();
const data = page.props.data;
const posts = ref(data.posts);
const pagination = ref(data.pagination);
const searchQuery = ref('');
const selectedCategories = ref([]);
const categories = ref(data.categories);

function handleCategoryChange(event) {
    searchPosts();
}

function handleSearchInput(event) {
    searchPosts();
}

async function searchPosts(page = 1) {
    try {
        let url = '/api/posts/search?';
        const queryParams = new URLSearchParams();

        if (searchQuery.value.length > 0) {
            queryParams.append('q', searchQuery.value);
        }

        if (selectedCategories.value.length > 0) {
            queryParams.append('c', selectedCategories.value.map(cat => cat.id).join(','));
        }

        queryParams.append('page', page);

        const response = await axios.get(`${url}?${queryParams.toString()}`);
        posts.value = response.data.posts;
        pagination.value = response.data.pagination;

        const urlParams = new URLSearchParams(window.location.search);
        urlParams.set('q', searchQuery.value);
        urlParams.set('page', page.toString());
        if (selectedCategories.value.length > 0) {
            urlParams.set('c', selectedCategories.value.map(cat => cat.id).join(','));
        }
        window.history.replaceState({}, '', `${window.location.pathname}?${urlParams}`);
    } catch (error) {
        console.error('Error searching posts:', error);
    }
}

onMounted(() => {
    const urlParams = new URLSearchParams(window.location.search);
    searchQuery.value = urlParams.get('q') || '';

    const categoryIds = urlParams.get('c') ? urlParams.get('c').split(',').map(Number) : [];
    selectedCategories.value = categories.value.filter(category => categoryIds.includes(category.id));

    const page = parseInt(urlParams.get('page')) || 1;
    searchPosts(page);
});
</script>

<style scoped>
.post {
    margin-bottom: 1.5rem;
}

.pagination {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 2rem;
}

button {
    padding: 0.5rem 1rem;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:disabled {
    background-color: #6c757d;
    cursor: not-allowed;
}

/* Common styles for input and select fields */
.input-field,
.multiselect {
    border: 1px solid #ccc;
    border-radius: 4px;
    padding: 0.5rem;
    font-size: 1rem;
    width: 100%;
    max-width: 300px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    transition: border-color 0.2s;
    height: 40px; /* Ensuring the same height */
    display: flex;
    align-items: center;
}

.input-field:focus,
.multiselect:focus {
    border-color: #007bff;
    outline: none;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}

.create-post-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background-color: #007bff;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 4px;
    text-decoration: none;
    height: 40px; /* Ensuring the same height */
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    transition: background-color 0.2s;
}

.create-post-btn:hover {
    background-color: #0056b3;
}

.filters {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
}
</style>
