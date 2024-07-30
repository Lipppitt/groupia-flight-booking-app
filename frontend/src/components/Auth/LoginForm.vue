<script setup lang="ts">
import { ref } from "vue";
import { useUserStore } from "@/stores/userStore";
import type { AxiosError } from "axios";
import { useRoute } from "vue-router";
import CustomInput from "@/components/Form/CustomInput.vue";
import CustomLabel from "@/components/Form/CustomLabel.vue";
import FormTitle from "@/components/Form/FormTitle.vue";

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
  <form @submit.prevent="handleSubmit" @change="handleChange">
    <FormTitle>Login</FormTitle>

    <ErrorMessage :message="errorMessage"/>

    <div class="mb-2">
      <CustomLabel name="email">Email Address</CustomLabel>
      <CustomInput
          id="email"
          name="email"
          v-model="form.email"
          placeholder="Enter your email"
          :errors="errors"
      />
    </div>

    <div class="mb-2">
      <CustomLabel name="email">Password</CustomLabel>
      <CustomInput
          id="password"
          name="password"
          type="password"
          v-model="form.password"
          placeholder="Enter your password"
          :errors="errors"
      />
    </div>

    <button type="submit" class="btn">Login</button>

    <p>Don't have an account? <router-link :to="{ name: 'register', query: route.query }">Sign Up</router-link></p>
  </form>
</template>

<style scoped>
/* Your styles here */
</style>
