<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link, usePage} from '@inertiajs/vue3';
import {ref} from 'vue';

const route = usePage();

const props = defineProps({
    posts: Object,
});

const currentPage = ref(props.posts.current_page);
const lastPage = ref(props.posts.last_page);
const links = ref(props.posts.links);

function goToPage(url) {
    if (url) {
        window.location.href = url;
    }
}
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Dashboard"/>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h1 class="text-xl font-bold mb-4">Posts</h1>
                        <Link :href="'/posts/' + 'create'" class="text-blue-500 hover:underline">
                            Create post
                        </Link>
                        <ul>
                            <li v-for="post in props.posts.data" :key="post.id" class="mb-4">
                                <a :href="/posts/ + post.id" class="text-blue-500 hover:underline">
                                    {{ post.title }}
                                </a>
                                <p>{{ post.body ? post.body.substring(0, 100) : '' }}...</p>
                            </li>
                        </ul>
                        <div class="mt-4">
                            <button
                                v-for="link in links"
                                :key="link.label"
                                @click="goToPage(link.url)"
                                :class="['mx-1', link.active ? 'text-bold' : '']"
                                :disabled="!link.url"
                            >
                                {{ link.label }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
