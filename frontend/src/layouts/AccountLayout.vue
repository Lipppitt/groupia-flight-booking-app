<script setup lang="ts">
import Header from "@/layouts/Header.vue";
</script>

<template>
  <div class="flex flex-col h-screen">
    <Header/>
    <main class="pt-[60px] flex flex-grow">
      <div class="w-3/12 bg-white h-full p-8">
        <router-link :to="{name: 'account-bookings'}">View Bookings</router-link>
      </div>
      <div class="flex-grow p-8">
        <slot></slot>
      </div>
    </main>
  </div>
</template>

<style scoped>

</style>
