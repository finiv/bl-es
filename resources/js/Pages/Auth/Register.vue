<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div>
            <h1 class="text-3xl font-semibold">Register</h1>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <form @submit.prevent="submit" class="w-full max-w-md mx-auto">
                <div>
                    <label for="name" class="block font-medium text-sm text-gray-700">Name</label>
                    <input
                        id="name"
                        type="text"
                        v-model="form.name"
                        required
                        autofocus
                        class="mt-1 block w-12 mx-auto border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200"
                    />
                </div>

                <div class="mt-4">
                    <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                    <input
                        id="email"
                        type="email"
                        v-model="form.email"
                        required
                        class="mt-1 block w-12 mx-auto border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200"
                    />
                </div>

                <div class="mt-4">
                    <label for="password" class="block font-medium text-sm text-gray-700">Password</label>
                    <input
                        id="password"
                        type="password"
                        v-model="form.password"
                        required
                        class="mt-1 block w-12 mx-auto border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200"
                    />
                </div>

                <div class="mt-4">
                    <label for="password_confirmation" class="block font-medium text-sm text-gray-700">Confirm Password</label>
                    <input
                        id="password_confirmation"
                        type="password"
                        v-model="form.password_confirmation"
                        required
                        class="mt-1 block w-12 mx-auto border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200"
                    />
                </div>

                <div class="mt-6">
                    <button
                        type="submit"
                        class="w-12 mx-auto block inline-flex items-center justify-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                    >
                        Register
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { useForm } from '@inertiajs/inertia-vue3';

export default {
    setup() {
        const form = useForm({
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
        });

        const submit = () => {
            form.post('/register');
        };

        return { form, submit };
    },
};
</script>

<style scoped>
/* Основні стилі для форми реєстрації */
.min-h-screen {
    min-height: 100vh;
}
.bg-gray-100 {
    background-color: #f7fafc;
}
.bg-white {
    background-color: #ffffff;
}
.shadow-md {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}
.sm\:rounded-lg {
    border-radius: 0.5rem;
}

/* Стилі для заголовка */
.text-3xl {
    font-size: 1.875rem;
}
.font-semibold {
    font-weight: 600;
}

/* Стилі для інпутів */
.block {
    display: block;
}
.mt-1 {
    margin-top: 0.25rem;
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
.w-12 {
    width: 50%;
}
.mx-auto {
    margin-left: auto;
    margin-right: auto;
}

/* Стилі для кнопки */
.bg-blue-500 {
    background-color: #3b82f6;
}
.text-white {
    color: #ffffff;
}
.hover\:bg-blue-700:hover {
    background-color: #2563eb;
}
.active\:bg-blue-900:active {
    background-color: #1e3a8a;
}
.focus\:outline-none:focus {
    outline: 2px solid transparent;
    outline-offset: 2px;
}
.focus\:border-blue-900:focus {
    border-color: #1e3a8a;
}
.focus\:ring {
    outline: 2px solid transparent;
    outline-offset: 2px;
}
.disabled\:opacity-25:disabled {
    opacity: 0.25;
}
.transition {
    transition: all 0.2s;
}
.ease-in-out {
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}
.duration-150 {
    transition-duration: 150ms;
}
</style>
