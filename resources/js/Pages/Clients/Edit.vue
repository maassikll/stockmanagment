<template>
    <head title="Edit" />
    <AuthenticatedLayout>
        <template #header>
            <BackButton :href="route('clients.index')" ></BackButton>
            Modifier les informations d'un client 
        </template>


        <form @submit.prevent="updateProduct">
            <div>
                <InputLabel for="first_name" value="Nom" />
                <TextInput id="first_name" type="text" class="mt-1 block w-full" v-model="form.first_name"  autocomplete="first_name" />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>


            <div>
                <InputLabel for="last_name" value="Prénom" />
                <TextInput id="last_name" type="text" class="mt-1 block w-full" v-model="form.last_name"  autocomplete="last_name" />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="phone" value="Numéro téléphone" />
                <TextInput id="phone" type="text" class="mt-1 block w-full" v-model="form.phone"  autocomplete="phone" />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="adresse" value="Adresse" />
                <TextInput id="adresse" type="text" class="mt-1 block w-full" v-model="form.adresse"  autocomplete="adresse" />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>


            <div class="mt-3">
                <InputLabel for="description" value="Description(Facultatif)" />
                <TextInput id="description" type="text" class="mt-1 block w-full" v-model="form.description" autocomplete="description" />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>




            <div class="flex flex-row p-10">
                <div class="basis-1/2"></div>
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Mettre à jour
                </PrimaryButton>
            </div>
        </form>
    </AuthenticatedLayout>
</template>

<script setup>
import {Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import BackButton from '@/Components/BackButton.vue';


const props = defineProps({
    client: Object
});

const form = useForm({
    first_name: props.client.first_name,
    last_name: props.client.last_name,
    phone: props.client.phone,
    adresse: props.client.adresse,
    description: props.client.description,
});

const updateProduct = () => {
    form.put(route('clients.update', props.client.id), {
        onFinish: () => form.reset()
    });
};
</script>