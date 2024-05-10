<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    username_email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <span class="h4 fw-bold">Login</span>
            <div class="mt-4">
                <TextInput
                    id="username_email"
                    type="text"
                    class="mt-1 w-100"
                    v-model="form.username_email"
                    required
                    autofocus
                    autocomplete="username_email"
                    placeholder="Username/Email"
                />

                <InputError class="mt-2" :message="form.errors.username" />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 w-100"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                    placeholder="Password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ms-2 text-sm text-gray-600">Remember me</span>
                </label>
            </div>

            <Link :href="route('register')">
                Don't have an account?
            </Link>

            <div class="flex items-center justify-end mt-4">
                <button class="btn btn-warning w-100 mx-auto p-1 border border-dark fw-semibold" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Log in
                </button>
            </div>
        </form>
    </GuestLayout>
</template>
