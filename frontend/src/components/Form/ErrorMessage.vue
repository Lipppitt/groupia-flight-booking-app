<script setup lang="ts">
 defineProps({
    message: {
      type: String,
      default: ''
    }
  })
</script>

<template>
  <p v-if="message.length > 0" class="text-red-500">
      {{message}}
  </p>
</template>

<style scoped>

</style>
