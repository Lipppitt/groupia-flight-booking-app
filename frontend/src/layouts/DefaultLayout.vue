<script setup lang="ts">

import Header from "@/layouts/Header.vue";
import Footer from "@/layouts/Footer.vue";
</script>

<template>
  <div class="flex flex-col h-screen">
    <Header/>
    <main class="pt-[60px] flex-grow">
      <div class="py-4">
        <div class="container">
          <slot></slot>
        </div>
      </div>
    </main>
    <Footer/>
  </div>
</template>

<style scoped>

</style>
