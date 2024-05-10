<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    username: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <form @submit.prevent="submit">
            <span class="h4 fw-bold">Register</span>
            <div class="container p-0">
                <div class="row">
                    <div class="col-12 mt-4">
                        <TextInput
                            id="name"
                            type="text"
                            class="mt-1 w-100"
                            v-model="form.name"
                            required
                            autocomplete="name"
                            placeholder="Name"
                        />

                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 mt-3">
                        <TextInput
                            id="email"
                            type="email"
                            class="mt-1 w-100"
                            v-model="form.email"
                            required
                            autocomplete="email"
                            placeholder="Email"
                        />

                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div class="col-6 mt-3">
                        <TextInput
                            id="username"
                            type="text"
                            class="mt-1"
                            v-model="form.username"
                            required
                            autocomplete="username"
                            placeholder="Username"
                        />

                        <InputError class="mt-2" :message="form.errors.username" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 mt-3">
                        <TextInput
                            id="password"
                            type="password"
                            class="mt-1 w-100"
                            v-model="form.password"
                            required
                            autocomplete="new-password"
                            placeholder="Password"
                        />

                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>

                    <div class="col-6 mt-3">
                        <TextInput
                            id="password_confirmation"
                            type="password"
                            class="mt-1 w-100"
                            v-model="form.password_confirmation"
                            required
                            autocomplete="new-password"
                            placeholder="Confirm Password"
                        />

                        <InputError class="mt-2" :message="form.errors.password_confirmation" />
                    </div>

                </div>
            </div>

            <div class="flex items-center justify-end mt-4">
                <button class="btn btn-warning w-100 mx-auto p-1 border border-dark fw-semibold" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register
                </button>
            </div>

            <div class="mt-2">
                <Link
                    :href="route('login')"
            >
                Already registered?
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>
