<template>
    <Head title="Factures" />

    <AuthenticatedLayout>
        <template #header>
            Factures Magasin
        </template>

        
        <form @submit.prevent="searchFactures" class="mb-4 flex ">
            <input
                type="text"
                v-model="form.search"
                placeholder="Chercher une facture..."
                class="w-full rounded-md border border-gray-300 p-2 m-1"
                @input="searchFactures"
            />

        </form>

        <div class="flex justify-end">
            <LinkButton :href="route('factures.facture')">Facturer</LinkButton>
            <LinkButton >Restorer</LinkButton>
        </div>


        <div class="inline-block min-w-full overflow-hidden rounded-lg shadow">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr class="border-b bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                        <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            N°Facture
                        </th>
                        <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Nom facture
                        </th>
                        
                        <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="facture in factures.data" :key="facture.id" class="text-gray-700">
                        <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ facture.id }}</p>
                        </td>
                        
                        <td v-if="facture.client" class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ facture.client ? `${facture.client.first_name} ${facture.client.last_name}` : '' }}_{{ truncateText(facture.created_at, 10)}}</p>
                        </td>
                        <td v-else class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">Passager_{{ truncateText(facture.created_at,10) }}</p>
                        </td>
                        

                        
                        <td v-if="facture.credit>0" class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                            <a :href="route('credits.index')" class="text-red-500 whitespace-no-wrap">Non payer</a>
                        </td>

                        <td v-else class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                            <p class="text-green-500 whitespace-no-wrap">Payer</p>
                        </td>
                        

                    </tr>
                </tbody>
            </table>

            <div class="flex flex-col items-center border-t bg-white px-5 py-5 xs:flex-row xs:justify-between">
                <pagination :links="factures.links" />
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
    factures: Object,
    search: String
});


const form = useForm({
    search: props.search || '',
});

const searchFactures = debounce(() => {
    form.get(route('factures.index'), { preserveState: true, replace: true });
}, 300);

function truncateText(text, length = 50, suffix = '') {
    return text.length > length ? text.substring(0, length) + suffix : text;
}

</script>
