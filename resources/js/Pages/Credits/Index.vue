<template>
  <Head title="Credits" />

  <AuthenticatedLayout>
      <template #header>
          Credits clients
      </template>

      
      <form @submit.prevent="searchCredits" class="mb-4 flex ">
          <input
              type="text"
              v-model="form.search"
              placeholder="Chercher une facture..."
              class="w-full rounded-md border border-gray-300 p-2 m-1"
              @input="searchCredits"
          />

      </form>


      <div class="inline-block min-w-full overflow-hidden rounded-lg shadow">
          <table class="w-full whitespace-no-wrap">
              <thead>
                  <tr class="border-b bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                      <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                          Nom client
                      </th>                      
                      <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                          Total Crédit
                      </th>
                      <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                          Status
                      </th>
                  </tr>
              </thead>
              <tbody>
                  <tr v-for="facture in factures.data" :key="facture.id" class="text-gray-700">
                  
                      
                      <td v-if="facture.client" class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                          <p class="text-gray-900 whitespace-no-wrap">{{ facture.client ? `${facture.client.first_name} ${facture.client.last_name}` : '' }}</p>
                      </td>
                      
                      <td v-else class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                          <p class="text-gray-900 whitespace-no-wrap">Passager</p>
                      </td>
                      <td v-if="facture.total_credit>0" class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                          <p class="text-red-500 whitespace-no-wrap">{{ facture.total_credit }}</p>
                      </td>
                      
                      <td v-else class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                          <p class="text-green-500 whitespace-no-wrap">{{ facture.total_credit }}</p>
                      </td>

                      <td v-if="facture.total_credit==0" class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                          <p class="text-green-500 whitespace-no-wrap">Payer</p>
                      </td>
                      
                      <td v-else class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                          <p class="text-red-500 whitespace-no-wrap">Non Payer</p>
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

const searchCredits = debounce(() => {
  form.get(route('credits.index'), { preserveState: true, replace: true });
}, 300);

</script>
