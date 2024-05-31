<template>
  <AuthenticatedLayout>
    <template #header>
      Créer une Nouvelle Facture
    </template>
  
    <div class="flex justify-center">
      <div class="container">
        <div class="form-section pr-4">
          
          <form @submit.prevent="addProduct" class="w-full">
            <div class="mb-4">
              <label for="client" class="block text-gray-700 text-sm font-bold mb-2">Client(Facultatif):</label>
              <CustomDropdown v-model="selectedClient" :items="clientItems" placeholder="Séléctionner un client" searchPlaceholder="Rechercher un client" />
            </div>
  
            <div class="mb-4">
              <label for="product" class="block text-gray-700 text-sm font-bold mb-2">Produit:</label>
              <CustomDropdown v-model="selectedProduct" :items="productItems" placeholder="Séléctionner un produit" searchPlaceholder="Rechercher un produit" />
            </div>
  
            <div class="mb-4">
              <label for="quantity" class="block text-gray-700 text-sm font-bold mb-2">Quantité:</label>
              <input type="number" id="quantity" v-model="quantity" min="1" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
            </div>
            
            <div class="flex justify-center">
              <button type="submit" class="mx-auto block bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Ajouter le Produit
              </button>
              
              <button @click="showModal = true" class="mx-auto block bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Imprimer la Facture
              </button>

              
                <!-- Modal Backdrop -->
            <div v-if="showModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50">
              <!-- Modal Content -->
              <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
                <h2 class="text-xl font-semibold mb-4">Saisie la valeur de verssement</h2>
                <input type="text"/>
                <div class="flex justify-end space-x-2">
                  <ModalButton @click="showModal = false">Payé</ModalButton>
                  <DeleteButton  @click="generatePDF">Non Payé</DeleteButton>
                </div>
              </div>
            </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  
    <div class="table-section mt-10">
      <h2 class="text-xl font-bold mb-4">Produits Ajoutés</h2>
      <div class="inline-block min-w-full overflow-hidden rounded-lg shadow">
        <table class="w-full whitespace-no-wrap">
          <thead>
            <tr class="border-b bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
              <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">N°</th>
              <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Désignation</th>
              <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Quantité</th>
              <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Prix Unitaire</th>
              <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Montant</th>
              <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600"></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, index) in invoiceItems" :key="item.product.id" class="text-gray-700">
              <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                <p class="text-gray-900 whitespace-no-wrap">{{ index + 1 }}</p>
              </td>
              <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                <p class="text-gray-900 whitespace-no-wrap">{{ item.product.name }}</p>
              </td>
              <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                <p class="text-gray-900 whitespace-no-wrap">{{ item.quantity }}</p>
              </td>
              <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                <p class="text-gray-900 whitespace-no-wrap">{{ item.product.selling_price }}</p>
              </td>
              <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                <p class="text-gray-900 whitespace-no-wrap">{{ item.quantity * item.product.selling_price }}</p>
              </td>
              <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                <button @click="removeItem(index)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded focus:outline-none focus:shadow-outline">Retirer</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="mt-4 flex justify-end">
    <p class="text-gray-700 font-semibold">Montant Total: {{ calculateTotalAmount() }}</p>
  </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import jsPDF from 'jspdf';
import 'jspdf-autotable';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CustomDropdown from '@/Components/CustomDropdown.vue'; 
import ModalButton from '@/Components/ModalButton.vue';
import DeleteButton from '@/Components/DeleteButton.vue';

const props = defineProps({
  clients: Array,
  products: Array,
});
const showModal = ref(false);

const selectedClient = ref(null);
const selectedProduct = ref(null);
const quantity = ref(1);
const invoiceItems = ref([]);

// Convert clients and products to items format for dropdown
const clientItems = computed(() => {
  return props.clients.map(client => ({
    id: client.id,
    label: client.first_name,
    value: client.id
  }));
});

const productItems = computed(() => {
  return props.products.map(product => ({
    id: product.id,
    label: product.name,
    value: product.id
  }));
});

const addProduct = () => {
  const product = props.products.find(p => p.id === selectedProduct.value);
  if (product) {
    invoiceItems.value.push({
      product,
      quantity: quantity.value
    });
    selectedProduct.value = null;
    quantity.value = 1;
  }
};

const removeItem = (index) => {
  invoiceItems.value.splice(index, 1);
};

const calculateTotalAmount = () => {
  let total = 0;
  for (const item of invoiceItems.value) { // Access the value property of the ref object
    total += item.quantity * item.product.selling_price;
  }
  return total;
};


const generatePDF = ($pdf) => {
  const doc = new jsPDF();

  // Access the value property of the ref object to get the array
  const items = invoiceItems.value;

  // Calculate total amount
  const totalAmount = items.reduce((total, item) => {
    return total + item.quantity * item.product.selling_price;
  }, 0);

  // Add table for invoice items
  doc.autoTable({
    head: [['N°', 'Désignation', 'Quantité', 'Prix Unitaire', 'Montant']],
    body: items.map((item, index) => [
      index + 1,
      item.product.name,
      item.quantity,
      item.product.selling_price,
      item.quantity * item.product.selling_price,
    ]),
  });

  // Add a row for the total amount
  doc.autoTable({
    body: [['', '', '', 'Montant Total:', totalAmount]],
    startY: doc.autoTable.previous.finalY + 10, // Start the new table below the previous one
    theme: 'plain', // Use a plain theme to avoid border conflicts
    didDrawCell: (data) => {
      if (data.column.index === 3 && data.row.index === 0) {
        // Style the cell containing the total amount
        doc.setTextColor(255, 0, 0); // Red color for emphasis
        
      }
    },
  });
  
  $pdf = doc.save('facture.pdf');  
  
};





  



</script>

<style scoped>
/* Add any custom styles here */
</style>
