<template>
    <head title="Create" />
    <AuthenticatedLayout>

        <template #header>
            <BackButton :href="route('clients.index')" ></BackButton>
            Ajouter un Client
        </template>


        <form @submit.prevent="submit">
            <div>
                <InputLabel for="first_name" value="Nom" />
                <TextInput id="first_name" type="text" class="mt-1 block w-full" v-model="form.first_name" required autofocus autocomplete="first_name" />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="last_name" value="Prénom" />
                <TextInput id="last_name" type="text" class="mt-1 block w-full" v-model="form.last_name" required autofocus autocomplete="last_name" />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="phone" value="Téléphone" />
                <TextInput id="phone" type="text" class="mt-1 block w-full" v-model="form.phone" autofocus autocomplete="phone" />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            
            <div>
                <InputLabel for="adresse" value="Adresse" />
                <TextInput id="adresse" type="text" class="mt-1 block w-full" v-model="form.adresse" autofocus autocomplete="adresse" />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>
         
            <div class="mt-3">
                <InputLabel for="description" value="Description(Facultatif)" />
                <TextInput id="description" type="text" class="mt-1 block w-full" v-model="form.description" required autocomplete="description" />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>




            <div class="flex flex-row p-10">
                <div class="basis-1/2"></div>
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Créer
                </PrimaryButton>
            </div>
        </form>
        
        



       
    </AuthenticatedLayout>
</template>

<script setup>

import {Head, Link,useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import BackButton from '@/Components/BackButton.vue';





const props = defineProps({
    client: Object
})

const form = useForm({
    first_name: '',
    last_name: '',
    phone:'',
    adresse:'',
    description:'',  
    
});


const submit = () => {
    form.post(route('clients.store'), {
        onFinish: () => form.reset()}
    );
};


</script>