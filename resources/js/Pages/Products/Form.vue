<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import SelectOption from '@/Components/SelectOption.vue';
import HTMLEditor from '@/Components/HTMLEditor.vue';
import FileInput from '@/Components/FileInput.vue';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import Dashboard from '@/Pages/Dashboard.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    categories: {
        type: Object
    }
});

const form = useForm({
    name: '',
    description: '',
    category: '',
    images: '',
    datetime: new Date(),
});

const formStep = ref(1);

const submit = () => {
    form.post(route('product.store'));
};

const nextStep = () => {
    form.transform((data) => ({
        ...data,
        'step' : formStep.value
    }))
    .post(route('product.validate'), {
        onSuccess: () => {
            formStep.value++;
        }
    })
}

const prevStep = () => {
    formStep.value--;
}

</script>

<template>
    <Dashboard>
        <Head title="Create Product" />

        <form @submit.prevent="submit">
            <section v-show="formStep === 1">
                <div>
                    <InputLabel for="name" value="Name" />

                    <TextInput
                        id="name"
                        type="text"
                        v-model="form.name"
                    />

                    <InputError :message="form.errors.name" />
                </div>

                <div>
                    <InputLabel for="email" value="Category" />

                    <SelectInput
                        id="category"
                        v-model="form.category"
                    >
                        <SelectOption v-for="category in categories" :option="category.name" />
                    </SelectInput>

                    <InputError :message="form.errors.category" />
                </div>

                <div>
                    <InputLabel for="description" value="Description" />

                    <HTMLEditor 
                        id="description"
                        v-model="form.description"
                    />

                    <InputError :message="form.errors.description" />
                </div>
            </section>

            <section v-show="formStep === 2">
                <div>
                    <InputLabel for="images" value="Image" />

                    <FileInput 
                        id="images"
                        canMultiple
                        accept="image/jpg, image/jpeg, image/png"
                        @file-changed="(images) => form.images = images"
                    />

                    <InputError :message="form.errors.image" />
                </div>
            </section>

            <section v-show="formStep === 3">
                <div>
                    <InputLabel for="datetime" value="Datetime" />

                    <VueDatePicker
                        id="datetime"
                        v-model="form.datetime"
                        readonly
                    />
                    <VueDatePicker
                        id="datetime"
                        v-model="form.datetime"
                        inline auto-apply dark required
                    />

                    <InputError :message="form.errors.datetime" />
                </div>
            </section>

            <div class="flex items-center justify-end mt-4">

                <PrimaryButton class="ms-4" v-show="formStep !== 1" type="button" @click="prevStep">
                    Prev
                </PrimaryButton>
                <PrimaryButton class="ms-4" v-show="formStep !== 3" type="button" @click="nextStep">
                    Next
                </PrimaryButton>
                <PrimaryButton class="ms-4" v-show="formStep === 3" type="button" @click="submit">
                    Create
                </PrimaryButton>
            </div>
        </form>
    </Dashboard>
</template>
