<template>
    <AuthenticatedLayout>
        <Head title="Dashboard"/>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-between items-center mb-6">
                            <h1 class="text-2xl font-bold">Posts</h1>
                            <Link :href="'/posts/create'" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                Create post
                            </Link>
                        </div>
                        <ul>
                            <li v-for="post in posts" :key="post.id" class="mb-4 border-b pb-4">
                                <Link :href="`/posts/${post.id}`" class="text-xl font-semibold text-blue-500 hover:underline">
                                    {{ post.title }}
                                </Link>
                                <p class="mt-2 text-gray-700">{{ post.body ? post.body.substring(0, 100) : '' }}...</p>
                            </li>
                        </ul>
                        <div class="mt-6 flex justify-between items-center">
                            <button
                                v-if="links.prev"
                                @click="goToPage(links.prev)"
                                class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300"
                            >
                                Previous
                            </button>
                            <span>Page {{ current_page }} of {{ last_page }}</span>
                            <button
                                v-if="links.next"
                                @click="goToPage(links.next)"
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

const page = usePage();
const posts = ref(page.props.posts);
const current_page = ref(page.props.current_page);
const last_page = ref(page.props.last_page);
const links = ref(page.props.links);

function goToPage(url) {
    if (url) {
        window.location.href = url;
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
