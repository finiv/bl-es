<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post('/login', {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />
        <div class="max-w-md mx-auto mt-8 p-6 bg-white shadow-md rounded-md">
            <form @submit.prevent="submit">
                <div>
                    <InputLabel for="email" value="Email" />
                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200"
                        v-model="form.email"
                        required
                        autofocus
                        autocomplete="username"
                    />
                    <InputError class="mt-2 text-red-600" :message="form.errors.email" />
                </div>

                <div class="mt-4">
                    <InputLabel for="password" value="Password" />
                    <TextInput
                        id="password"
                        type="password"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200"
                        v-model="form.password"
                        required
                        autocomplete="current-password"
                    />
                    <InputError class="mt-2 text-red-600" :message="form.errors.password" />
                </div>

                <div class="block mt-4">
                    <label class="flex items-center">
                        <Checkbox name="remember" v-model:checked="form.remember" />
                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <Link
                        v-if="canResetPassword"
                        :href="route('password.request')"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Forgot your password?
                    </Link>

                    <PrimaryButton class="ml-4 login-btn" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Log in
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </GuestLayout>
</template>

<style scoped>
.login-btn {
    color: black !important;
}
.max-w-md {
    max-width: 28rem;
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

<!--<script setup>-->
<!--import Checkbox from '@/Components/Checkbox.vue';-->
<!--import GuestLayout from '@/Layouts/GuestLayout.vue';-->
<!--import InputError from '@/Components/InputError.vue';-->
<!--import InputLabel from '@/Components/InputLabel.vue';-->
<!--import PrimaryButton from '@/Components/PrimaryButton.vue';-->
<!--import TextInput from '@/Components/TextInput.vue';-->
<!--import { Head, Link, useForm } from '@inertiajs/vue3';-->
<!--// import { route } from 'ziggy';-->

<!--defineProps({-->
<!--    canResetPassword: {-->
<!--        type: Boolean,-->
<!--    },-->
<!--    status: {-->
<!--        type: String,-->
<!--    },-->
<!--});-->

<!--const form = useForm({-->
<!--    email: '',-->
<!--    password: '',-->
<!--    remember: false,-->
<!--});-->

<!--const submit = () => {-->
<!--    form.post('/login', {-->
<!--        onFinish: () => form.reset('password'),-->
<!--    });-->
<!--};-->
<!--</script>-->

<!--<template>-->
<!--    <Head title="Log in" />-->
<!--    <form @submit.prevent="submit">-->
<!--        <div>-->
<!--            <InputLabel for="email" value="Email" />-->

<!--            <TextInput-->
<!--                id="email"-->
<!--                type="email"-->
<!--                class="mt-1 block w-full"-->
<!--                v-model="form.email"-->
<!--                required-->
<!--                autofocus-->
<!--                autocomplete="username"-->
<!--            />-->

<!--            <InputError class="mt-2" :message="form.errors.email" />-->
<!--        </div>-->

<!--        <div class="mt-4">-->
<!--            <InputLabel for="password" value="Password" />-->

<!--            <TextInput-->
<!--                id="password"-->
<!--                type="password"-->
<!--                class="mt-1 block w-full"-->
<!--                v-model="form.password"-->
<!--                required-->
<!--                autocomplete="current-password"-->
<!--            />-->

<!--            <InputError class="mt-2" :message="form.errors.password" />-->
<!--        </div>-->

<!--        <div class="block mt-4">-->
<!--            <label class="flex items-center">-->
<!--                <Checkbox name="remember" v-model:checked="form.remember" />-->
<!--                <span class="ms-2 text-sm text-gray-600">Remember me</span>-->
<!--            </label>-->
<!--        </div>-->

<!--        <div class="flex items-center justify-end mt-4">-->
<!--            <Link-->
<!--                v-if="canResetPassword"-->
<!--                :href="route('password.request')"-->
<!--                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"-->
<!--            >-->
<!--                Forgot your password?-->
<!--            </Link>-->

<!--            <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">-->
<!--                Log in-->
<!--            </PrimaryButton>-->
<!--        </div>-->
<!--    </form>-->
<!--</template>-->
