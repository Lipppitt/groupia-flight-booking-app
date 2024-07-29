<script setup lang="ts">
import {useUserStore} from "@/stores/userStore";

const userStore = useUserStore();
</script>

<template>
  <header class="bg-white px-12 py-4 fixed w-full top-0 z-99">
    <div class="container">
      <div class="flex justify-between">

        <router-link :to="{name: 'home'}">
          <h1 class="text-lg font-bold">FlightBookings</h1>
        </router-link>

        <div v-if="userStore.user">
          <router-link :to="{name: 'account'}">
            My Account
          </router-link>
        </div>
        <div v-else>
          <router-link :to="{name: 'login'}">
            Login/Register
          </router-link>
        </div>
      </div>
    </div>
  </header>
</template>

<style scoped>

</style>
