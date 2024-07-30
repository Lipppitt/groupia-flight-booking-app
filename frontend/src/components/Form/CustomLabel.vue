<script setup lang="ts">
  defineProps({
    name: {
      type: String,
      default: ''
    }
  });
</script>

<template>
  <label class="block" :for="name">
    <slot></slot>
  </label>
</template>

<style scoped>

</style>
