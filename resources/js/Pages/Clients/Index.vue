<template>
    <Head title="Clients" />

    <AuthenticatedLayout>
        <template #header>
            Clients enrengistrer
        </template>

        
        <form @submit.prevent="searchProducts" class="mb-4 flex ">
            <input
                type="text"
                v-model="form.search"
                placeholder="Chercher un client..."
                class="w-full rounded-md border border-gray-300 p-2 m-1"
                @input="searchClients"
            />

        </form>

        <div class="flex justify-end">
            <LinkButton :href="route('clients.create')" :active="route().current('clients.create')">Ajout client</LinkButton>
            <LinkButton :href="route('clients.restore')">Restorer</LinkButton>
        </div>


        <div class="inline-block min-w-full overflow-hidden rounded-lg shadow">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr class="border-b bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                        <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Nom 
                        </th>
                        <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Prénom
                        </th>
                        <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Téléphone
                        </th>
                        <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600"></th>
                    
                        <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="client in clients.data" :key="client.id" class="text-gray-700">
                        <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ client.first_name }}</p>
                        </td>
                        <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ client.last_name }}</p>
                        </td>
                        <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ client.phone }}</p>
                        </td>

                        <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                        </td>

                        <td class="border-b border-gray-200 bg-white   px-0 py-2 text-xxs flex ">
                            <LinkButton :href="route('clients.show', { id: client.id })" :active="route().current('clients.show')">Detailes</LinkButton>
                            <LinkButton :href="route('clients.edit', { id: client.id })" :active="route().current('clients.edit')">Modifier</LinkButton>
                            <LinkButton :href="route('clients.destroy',client.id)"  method="DELETE">Supprimer</LinkButton>
                   
                        </td>


                    </tr>
                </tbody>
            </table>

            <div class="flex flex-col items-center border-t bg-white px-5 py-5 xs:flex-row xs:justify-between">
                <pagination :links="clients.links" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Pagination from '@/Components/Pagination.vue'
import { Head, useForm } from '@inertiajs/vue3';
import LinkButton from '@/Components/LinkButton.vue'
import debounce from 'lodash.debounce'

const props = defineProps({
    clients: Object,
    search: String
});


const form = useForm({
    search: props.search || '',
});

const searchClients = debounce(() => {
    form.get(route('clients.index'), { preserveState: true, replace: true });
}, 300);

</script>
