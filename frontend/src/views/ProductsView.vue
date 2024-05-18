<template>
  <div>
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-2xl font-bold">Produtos</h1>
      <button class="px-4 py-2 bg-blue-600 text-white rounded" @click="openModal">Adicionar Produto</button>
    </div>

    <div class="mb-4">
      <form @submit.prevent="applyFilters" class="flex flex-wrap gap-4">
        <div>
          <label for="filterName" class="block text-sm font-medium">Nome</label>
          <input type="text" id="filterName" v-model="filters.name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-700" />
        </div>
        <div>
          <label for="filterCategory" class="block text-sm font-medium">Categoria</label>
          <select id="filterCategory" v-model="filters.category_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-700">
            <option value="">Todas</option>
            <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
          </select>
        </div>
        <div>
          <label for="filterPriceMin" class="block text-sm font-medium">Preço Mínimo</label>
          <input type="number" id="filterPriceMin" v-model="filters.price_min" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-700" />
        </div>
        <div>
          <label for="filterPriceMax" class="block text-sm font-medium">Preço Máximo</label>
          <input type="number" id="filterPriceMax" v-model="filters.price_max" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-700" />
        </div>
        <div>
          <label for="filterSituation" class="block text-sm font-medium">Situação</label>
          <select id="filterSituation" v-model="filters.situation" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-700">
            <option value="">Todas</option>
            <option value="1">Ativo</option>
            <option value="0">Inativo</option>
          </select>
        </div>
        <div class="flex items-end">
          <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Aplicar Filtros</button>
        </div>
      </form>
    </div>

    <ul>
      <li v-for="product in products.data" :key="product.id" class="mb-2 p-4 bg-gray-100 rounded shadow flex justify-between items-center">
        <div>
          <h2 class="text-xl font-bold text-gray-700">{{ product.name }}</h2>
          <p class="text-gray-500">Preço: R$ {{ product.price }}</p>
          <p class="text-gray-500">Categoria: {{ product.category.name }}</p>
          <p class="text-gray-500">Situação: {{ product.situation ? 'Ativo' : 'Inativo' }}</p>
        </div>
        <img :src="product.imageUrl" alt="Imagem do produto" class="w-16 h-16 object-cover rounded cursor-pointer" @click="showImage(product.imageUrl)">
      </li>
    </ul>

    <div class="flex justify-between items-center mt-4">
      <button class="px-4 py-2 bg-gray-300 text-black rounded" :disabled="!products.prev_page_url" @click="fetchProducts(products.prev_page_url)">Anterior</button>
      <span>Página {{ products.current_page }} de {{ products.last_page }}</span>
      <button class="px-4 py-2 bg-gray-300 text-black rounded" :disabled="!products.next_page_url" @click="fetchProducts(products.next_page_url)">Próxima</button>
    </div>

    <div v-if="isModalOpen" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
      <div class="bg-white p-8 rounded shadow max-w-md w-full">
        <h2 class="text-xl font-bold mb-4 text-gray-700">Adicionar Produto</h2>
        <form @submit.prevent="handleSubmit">
          <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
            <input type="text" id="name" v-model="name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-700" />
          </div>
          <div class="mb-4">
            <label for="price" class="block text-sm font-medium text-gray-700">Preço</label>
            <input type="number" id="price" v-model="price" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-700" />
          </div>
          <div class="mb-4">
            <label for="category" class="block text-sm font-medium text-gray-700">Categoria</label>
            <select id="category" v-model="selectedCategory" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-700">
              <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
            </select>
          </div>
          <div class="mb-4">
            <label for="image" class="block text-sm font-medium text-gray-700">Imagem</label>
            <input type="file" id="image" @change="handleImageUpload" class="mt-1 block w-full text-gray-700 sm:text-sm" />
          </div>
          <div class="mb-4">
            <div class="flex items-center">
              <input type="checkbox" id="situation" v-model="isActive" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" />
              <label for="situation" class="ml-2 block text-sm text-gray-900">Ativo</label>
            </div>
          </div>
          <div class="flex justify-end">
            <button type="button" class="px-4 py-2 bg-gray-300 text-black rounded mr-2" @click="closeModal">Cancelar</button>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Adicionar</button>
          </div>
        </form>
      </div>
    </div>

    <div v-if="isImageModalOpen" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-75" @click.self="closeImageModal">
      <div class="relative">
        <img :src="currentImageUrl" alt="Imagem ampliada" class="max-w-full max-h-full rounded">
        <button class="absolute top-2 right-2 px-4 py-2 bg-gray-300 text-black rounded" @click="closeImageModal">Fechar</button>
      </div>
    </div>

  </div>
</template>

<script lang="ts">
import { defineComponent, ref, onMounted } from 'vue';
import axios from 'axios';

export default defineComponent({
  name: 'ProductsView',
  setup() {
    const isModalOpen = ref(false);
    const isImageModalOpen = ref(false);
    const name = ref('');
    const price = ref(0);
    const selectedCategory = ref('');
    const imageFile = ref<File | null>(null);
    const imageUuid = ref('');
    const isActive = ref(false);
    const products = ref({
      data: [],
      current_page: 1,
      last_page: 1,
      next_page_url: null,
      prev_page_url: null,
    });
    const categories = ref([]);
    const filters = ref({
      name: '',
      category_id: '',
      price_min: '',
      price_max: '',
      situation: ''
    });
    const currentImageUrl = ref('');

    const fetchProducts = async (url = '/api/product', filters = {}) => {
      try {
        const response = await axios.get(url, { params: filters });
        products.value = response.data;
      } catch (error) {
        console.error('Error fetching products', error);
      }
    };

    const fetchCategories = async () => {
      try {
        const response = await axios.get('/api/category?status=active');
        categories.value = response.data;
      } catch (error) {
        console.error('Error fetching categories', error);
      }
    };

    const applyFilters = () => {
      fetchProducts('/api/product', filters.value);
    };

    const openModal = () => {
      isModalOpen.value = true;
    };

    const closeModal = () => {
      isModalOpen.value = false;
      name.value = '';
      price.value = 0;
      selectedCategory.value = '';
      imageFile.value = null;
      imageUuid.value = '';
      isActive.value = false;
    };

    const handleImageUpload = async (event: Event) => {
      const target = event.target as HTMLInputElement;
      if (target.files && target.files[0]) {
        const file = target.files[0];
        const formData = new FormData();
        formData.append('image', file);

        try {
          const response = await axios.post('/api/upload/image', formData, {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          });
          imageUuid.value = response.data.id;
        } catch (error) {
          console.error('Error uploading image', error);
        }
      }
    };

    const handleSubmit = async () => {
      try {
        await axios.post('/api/product', {
          name: name.value,
          price: price.value,
          category_id: selectedCategory.value,
          imagem_uuid: imageUuid.value,
          situation: isActive.value ? true : false
        });
        closeModal();
        fetchProducts('/api/product');
      } catch (error) {
        console.error('Error adding product', error);
      }
    };

    const showImage = (url: string) => {
      currentImageUrl.value = url;
      isImageModalOpen.value = true;
    };

    const closeImageModal = () => {
      isImageModalOpen.value = false;
      currentImageUrl.value = '';
    };

    onMounted(() => {
      fetchProducts('/api/product');
      fetchCategories();
    });

    return {
      isModalOpen,
      isImageModalOpen,
      name,
      price,
      selectedCategory,
      imageFile,
      imageUuid,
      isActive,
      products,
      categories,
      filters,
      currentImageUrl,
      openModal,
      closeModal,
      handleImageUpload,
      handleSubmit,
      applyFilters,
      showImage,
      closeImageModal,
      fetchProducts,
    };
  },
});
</script>