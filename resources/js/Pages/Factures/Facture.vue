<template>
  <AuthenticatedLayout>
    <template #header>
      Créer une Nouvelle Facture
    </template>
  
    <div class="flex justify-center">
      <div class="container">
        <div class="form-section pr-4">
          
          <form @submit.prevent="submit" class="w-full">
            <div class="mb-4">
              <label  for="client" class="block text-gray-700 text-sm font-bold mb-2">Client(Facultatif):</label>
              <CustomDropdown  v-model="selectedClient" :items="clientItems" placeholder="Séléctionner un client" searchPlaceholder="Rechercher un client" />
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
              <PaidButton  @click="addProduct" class="mx-auto block">
                Ajouter le Produit
              </PaidButton>
              
              <PrintButton @click="showModal = true" class="mx-auto block py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Imprimer la Facture
              </PrintButton>

              
                <!-- Modal Backdrop -->
            <div v-if="showModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50">
              <!-- Modal Content -->
              <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
                <hTwoTitle title ="Choisissez une option" class="text-center"/>
                <div>
                <InputLabel for="verssment" value="Verrssement"/>
                <TextInput id="verssment" type="number" class="block w-full " placeholder="Versssement" />
                
                </div>
                <div class="flex justify-end space-x-2">
                  <PaidButton @click="generatePDF(true)" class="mt-5 block w-1/2" >Payé</PaidButton>
                  <UnPaidButton @click="generatePDF(false)" class="mt-5 block w-1/2" >Non Payé</UnPaidButton>
                  <DeleteButton  @click="showModal = false" >Annuler</DeleteButton>
                  
                  
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
              <td class="border-b border-gray-200 bg-white px-2 py-2 text-sm">
                <RetireButton @click="removeItem(index)" >Retirer</RetireButton>
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
import { Head, useForm } from "@inertiajs/vue3";
import jsPDF from 'jspdf';
import 'jspdf-autotable';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CustomDropdown from '@/Components/CustomDropdown.vue'; 
import DeleteButton from '@/Components/DeleteButton.vue';
import TextInput from '@/Components/TextInput.vue';
import hTwoTitle from '@/Components/hTwoTitle.vue'
import PaidButton from '@/Components/PaidButton.vue'
import UnPaidButton from '@/Components/UnPaidButton.vue'
import PrintButton from '@/Components/PrintButton.vue'
import RetireButton from '@/Components/RetireButton.vue'
import InputLabel from '@/Components/InputLabel.vue';
const props = defineProps({
  clients: Array,
  products: Array,
  invoice:Object,
});
const showModal = ref(false);

const selectedClient = ref(null);
const selectedProduct = ref(null);
const quantity = ref(1);
const invoiceItems = ref([]);
let paidAmount;
let reste = 0;


const clientItems = computed(() => {
  return props.clients.map(client => ({
    id: client.id,
    label: client.first_name+' '+client.last_name,
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
  for (const item of invoiceItems.value) { 
    total += item.quantity * item.product.selling_price;
  }
  return total;
};

const loadImage = (src) => {
  return new Promise((resolve, reject) => {
    const img = new Image();
    img.onload = () => resolve(img);
    img.onerror = (error) => reject(error);
    img.src = src;
  });
};

const form = useForm({
  client_id:'',
  name:'',
  pdf_data:'',
  credit:'',
})
const savePDF = async ($paid) => {

const [logo] = await Promise.all([
  loadImage('/img/logoBillal.jpg')
]);

const doc = new jsPDF();

const logoWidth = 40;
const logoHeight = (logoWidth * logo.height) / logo.width;
doc.addImage(logo, 'JPEG', 170, 0, logoWidth, logoHeight);
doc.text('Elec Billal',178,35);

doc.setFont('times', 'normal');
doc.setFontSize(16);

const items = invoiceItems.value;
const selectedClientObject = clientItems.value.find(client => client.id === selectedClient.value);
const selectedClientName = selectedClientObject ? selectedClientObject.label : '';


const totalAmount = items.reduce((total, item) => {
  return total + item.quantity * item.product.selling_price;
}, 0);


let verssment = document.getElementById('verssment').value;

if($paid){
  if (!verssment) {
    paidAmount = totalAmount;
  }else{
    paidAmount = verssment;
  }
  
}else {
  paidAmount = 0;
}

doc.text("Tél 0 44 93 35 99", 90, 10);
doc.setFontSize(10);
doc.text("Fourniture: électrique", 10, 15);
doc.setFontSize(15);
doc.text(`BON N° :`, 10, 22);
if(selectedClientName){
  doc.text(`POUR :${selectedClientName}`, 10, 29);
}else{
  doc.text(`POUR :Passager`, 10, 27);
}


await doc.autoTable({
  head: [['N°', 'Désignation', 'Quantité', 'Prix Unitaire', 'Montant']],
  body: items.map((item, index) => [
    index + 1,
    item.product.name,
    item.quantity,
    item.product.selling_price,
    item.quantity * item.product.selling_price,
  ]),
  startY:50
});

doc.setFontSize(14);
doc.text(`Montant total : ${totalAmount}`, 150, doc.autoTable.previous.finalY + 10);
doc.text(`Montant payer : ${paidAmount}`, 150, doc.autoTable.previous.finalY + 15);
doc.text(`Montant restant : ${totalAmount - paidAmount}`, 150, doc.autoTable.previous.finalY + 20);
doc.setFontSize(12);
doc.text('Merci pour votre visite', 90, doc.autoTable.previous.finalY + 35);


return doc.output('blob');  

};

const generatePDF = async ($paid) => {

  const [logo] = await Promise.all([
    loadImage('/img/logoBillal.jpg')
  ]);

  const doc = new jsPDF();

  const logoWidth = 40;
  const logoHeight = (logoWidth * logo.height) / logo.width;
  doc.addImage(logo, 'JPEG', 170, 0, logoWidth, logoHeight);
  doc.text('Elec Billal',178,35);

  doc.setFont('times', 'normal');
  doc.setFontSize(16);

  const items = invoiceItems.value;
  const selectedClientObject = clientItems.value.find(client => client.id === selectedClient.value);
  const selectedClientName = selectedClientObject ? selectedClientObject.label : '';


  const totalAmount = items.reduce((total, item) => {
    return total + item.quantity * item.product.selling_price;
  }, 0);


  let verssment = document.getElementById('verssment').value;

  if($paid){
    if (!verssment) {
      paidAmount = totalAmount;
    }else{
      paidAmount = verssment;
    }
    
  }else {
    paidAmount = 0;
  }

  doc.text("Tél 0 44 93 35 99", 90, 10);
  doc.setFontSize(10);
  doc.text("Fourniture: électrique", 10, 15);
  doc.setFontSize(15);
  doc.text(`BON N° :`, 10, 22);
  if(selectedClientName){
    doc.text(`POUR :${selectedClientName}`, 10, 29);
  }else{
    doc.text(`POUR :Passager`, 10, 27);
  }
  
 
  await doc.autoTable({
    head: [['N°', 'Désignation', 'Quantité', 'Prix Unitaire', 'Montant']],
    body: items.map((item, index) => [
      index + 1,
      item.product.name,
      item.quantity,
      item.product.selling_price,
      item.quantity * item.product.selling_price,
    ]),
    startY:50
  });

  doc.setFontSize(14);
  doc.text(`Montant total : ${totalAmount}`, 150, doc.autoTable.previous.finalY + 10);
  doc.text(`Montant payer : ${paidAmount}`, 150, doc.autoTable.previous.finalY + 15);
  doc.text(`Montant restant : ${totalAmount - paidAmount}`, 150, doc.autoTable.previous.finalY + 20);
  doc.setFontSize(12);
  doc.text('Merci pour votre visite', 90, doc.autoTable.previous.finalY + 35);
  
  reste = totalAmount - paidAmount;
  const pdfData = await savePDF();
  form.pdf_data = pdfData;
  form.client_id = selectedClient.value || null;
  form.credit = reste;
  form.post(route('factures.store'));
  return doc.save(`facture.pdf`);  
  
};


</script>

