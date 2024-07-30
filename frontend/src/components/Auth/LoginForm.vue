<script setup lang="ts">
import { ref } from "vue";
import { useUserStore } from "@/stores/userStore";
import type { AxiosError } from "axios";
import { useRoute } from "vue-router";

type LoginFormErrors = {
  email?: string[];
  password?: string[];
};

const userStore = useUserStore();
const route = useRoute();

const form = ref({
  email: '',
  password: '',
});

const isLoading = ref(false);
const errorMessage = ref<string | null>(null);
const errors = ref<LoginFormErrors>({});

const handleSubmit = async () => {
  isLoading.value = true;
  errorMessage.value = null;
  errors.value = {};

  try {
    await userStore.login(form.value);
  } catch (err) {
    const axiosError = err as AxiosError;
    if (axiosError.response?.data?.message) {
      errorMessage.value = axiosError.response.data.message;
    } else {
      errorMessage.value = "An error occurred. Please try again.";
    }
    if (axiosError.response?.data?.errors) {
      errors.value = axiosError.response.data.errors;
    }
  } finally {
    isLoading.value = false;
  }
};

const handleChange = (event: Event) => {
  const target = event.target as HTMLInputElement;
  if (target.id) {
    const key = target.id as keyof LoginFormErrors;
    if (errors.value[key]) {
      delete errors.value[key];
    }
  }
};
</script>

<template>
  <p v-if="errorMessage">{{ errorMessage }}</p>

  <form @submit.prevent="handleSubmit" @change="handleChange">
    <h2>Login</h2>

    <div class="mb-2">
      <label class="block" for="email">Email Address</label>
      <input type="text" id="email" v-model="form.email" placeholder="Enter your email "/>
      <span v-if="errors.email" class="block text-red-500 text-sm">
        <span v-for="error in errors.email" :key="error">{{ error }}</span>
      </span>
    </div>

    <div class="mb-2">
      <label class="block" for="password">Password</label>
      <input type="password" id="password" v-model="form.password"/>
      <span v-if="errors.password" class="block text-red-500 text-sm">
        <span v-for="error in errors.password" :key="error">{{ error }}</span>
      </span>
    </div>

    <button type="submit" class="btn">Login</button>

    <p>Don't have an account? <router-link :to="{ name: 'register', query: route.query }">Sign Up</router-link></p>
  </form>
</template>

<style scoped>
/* Your styles here */
</style>
