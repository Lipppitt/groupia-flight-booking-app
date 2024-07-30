<script setup lang="ts">
import {ref} from "vue";
import {useUserStore} from "@/stores/userStore";
import {useRoute} from "vue-router";
import {type AxiosError} from "axios";
import FormTitle from "@/components/Form/FormTitle.vue";
import CustomLabel from "@/components/Form/CustomLabel.vue";
import CustomInput from "@/components/Form/CustomInput.vue";

type RegisterFormErrors = {
  name?:string[];
  email?: string[];
  password?: string[];
  password_confirmation?: string[];
};

const userStore = useUserStore();
const route = useRoute();

const form = ref({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
});

const isLoading = ref(false);
const errorMessage = ref<string | null>(null);
const errors = ref<RegisterFormErrors>({});

const handleSubmit = async () => {
  isLoading.value = true;
  errorMessage.value = null;
  errors.value = {};

  try {
    await userStore.register(form.value);
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
    const key = target.id as keyof RegisterFormErrors;
    if (errors.value[key]) {
      delete errors.value[key];
    }
  }
};
</script>

<template>
  <form @submit.prevent="handleSubmit" @change="handleChange">
    <FormTitle>Register</FormTitle>

    <ErrorMessage :message="errorMessage"/>

    <div class="mb-2">
      <CustomLabel name="email">Name</CustomLabel>
      <CustomInput
          id="name"
          name="name"
          v-model="form.name"
          placeholder="Enter your name"
          :errors="errors"
      />
    </div>

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

    <div class="mb-2">
      <CustomLabel name="email">Password</CustomLabel>
      <CustomInput
          id="password_confirmation"
          name="password_confirmation"
          type="password"
          v-model="form.password_confirmation"
          placeholder="Confirm your password"
          :errors="errors"
      />
    </div>

    <button type="submit" class="btn">Register</button>

    <p class="text-center text-sm">Already have an account? <router-link class="underline" :to="{name: 'login', query: route.query}">Login</router-link></p>
  </form>
</template>

<style scoped>

</style>
