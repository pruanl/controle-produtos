<template>
  <div>
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-2xl font-bold">Categorias</h1>
      <button class="px-4 py-2 bg-blue-600 text-white rounded" @click="openModal">Adicionar Categoria</button>
    </div>
    <ul>
      <li v-for="category in categories" :key="category.id" class="mb-2 p-4 bg-gray-100 rounded shadow">
        <h2 class="text-xl font-bold text-gray-700">{{ category.name }}</h2>
        <p class="text-gray-500">Situação: {{ category.status === 'active' ? 'Ativo' : 'Inativo' }}</p>
      </li>
    </ul>

    <div v-if="isModalOpen" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
      <div class="bg-white p-8 rounded shadow max-w-md w-full">
        <h2 class="text-xl font-bold mb-4  text-gray-700">Criar Categoria</h2>
        <form @submit.prevent="handleSubmit">
          <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
            <input type="text" id="name" v-model="name" class=" text-gray-700 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
          </div>
          <div class="mb-4">
            <div class="flex items-center">
              <input type="checkbox" id="status" v-model="isActive" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" />
              <label for="status" class="ml-2 block text-sm text-gray-900">Ativo</label>
            </div>
          </div>
          <div class="flex justify-end">
            <button type="button" class="px-4 py-2 bg-gray-300 text-black rounded mr-2" @click="closeModal">Cancelar</button>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Criar</button>
          </div>
        </form>
      </div>
    </div>

  </div>
</template>

<script lang="ts">
import { defineComponent, ref, onMounted } from 'vue';
import axios from 'axios';

export default defineComponent({
  name: 'CategoriesView',
  setup() {
    const isModalOpen = ref(false);
    const name = ref('');
    const isActive = ref(false);
    const categories = ref([]);

    const fetchCategories = async () => {
      try {
        const response = await axios.get('/api/category');
        categories.value = response.data;
      } catch (error) {
        console.error('Error fetching categories', error);
      }
    };

    const openModal = () => {
      isModalOpen.value = true;
    };

    const closeModal = () => {
      isModalOpen.value = false;
      name.value = '';
      isActive.value = false;
    };

    const handleSubmit = async () => {
      try {
        await axios.post('/api/category', {
          name: name.value,
          situation: isActive.value ? true : false
        });
        closeModal();
        fetchCategories();
      } catch (error) {
        console.error('Error creating category', error);
      }
    };

    onMounted(() => {
      fetchCategories();
    });

    return {
      isModalOpen,
      name,
      isActive,
      categories,
      openModal,
      closeModal,
      handleSubmit,
    };
  },
});
</script>