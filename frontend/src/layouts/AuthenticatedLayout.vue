<template>
  <div class="min-h-screen flex flex-col">
    <header class="bg-blue-800 text-white p-4">
      <nav class="container mx-auto flex justify-between">
        <div class="flex space-x-4">
          <router-link to="/" class="text-white">Home</router-link>
          <router-link to="/categories" class="text-white">Categorias</router-link>
          <router-link to="/products" class="text-white">Produtos</router-link>
        </div>
        <button @click="logout" class="text-white">Logout</button>
      </nav>
    </header>
    <main class="flex-grow container mx-auto p-4">
      <router-view />
    </main>
    <!--<footer class="bg-blue-800 text-white p-4 text-center">
      &copy; 2024 Produtos
    </footer>-->
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { useAuthStore } from '../stores/auth';

export default defineComponent({
  name: 'AuthenticatedLayout',
  setup() {
    const authStore = useAuthStore();

    const logout = () => {
      authStore.logout();
    };

    return {
      logout,
    };
  },
});
</script>
