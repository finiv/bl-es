<template>
    <AuthenticatedLayout>
        <Head title="Dashboard"/>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-between items-center mb-6">
                            <h1 class="text-2xl font-bold">Posts</h1>
                            <input v-model="searchQuery" @input="handleSearchInput" placeholder="Search posts..." class="border rounded px-4 py-2"/>
                            <Link :href="'/posts/create'" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                Create post
                            </Link>
                        </div>
                        <ul>
                            <li v-for="post in posts" :key="post.id" class="mb-4 border-b pb-4">
                                <Link :href="`/posts/${post.id}`" class="text-xl font-semibold text-blue-500 hover:underline">
                                    <strong>{{ post.id }}</strong><br>{{ post.title }}
                                </Link>
                                <p class="mt-2 text-gray-700">{{ post.body ? post.body.substring(0, 100) : '' }}...</p>
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
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import axios from 'axios';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const page = usePage();
const data = page.props.data;
const posts = ref(data.posts);
const pagination = ref(data.pagination);
const searchQuery = ref('');

function handleSearchInput(event) {
    // Оновлюємо URL згідно з новим пошуковим запитом
    const urlParams = new URLSearchParams(window.location.search);
    urlParams.set('q', searchQuery.value);
    urlParams.set('page', '1'); // Стартуємо з першої сторінки при новому пошуковому запиті
    window.history.replaceState({}, '', `${window.location.pathname}?${urlParams}`);

    searchPosts(1); // Здійснюємо пошук знову при введенні нового запиту
}

async function searchPosts(page = 1) {
    try {
        let url = '/api/posts';
        if (searchQuery.value.length > 0) {
            url = `/api/posts/search?q=${searchQuery.value}`;
        }
        const response = await axios.get(`${url}&page=${page}`);
        posts.value = response.data.posts;
        pagination.value = response.data.pagination;

        const urlParams = new URLSearchParams(window.location.search);
        urlParams.set('q', searchQuery.value);
        urlParams.set('page', page.toString());
        window.history.replaceState({}, '', `${window.location.pathname}?${urlParams}`);

    } catch (error) {
        console.error('Error searching posts:', error);
    }
}
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
</style>
