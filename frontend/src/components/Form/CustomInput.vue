<script setup lang="ts">
import {ref, watch} from "vue";

const emit = defineEmits(['update:modelValue']);

const props = defineProps({
    id: {
        type: String,
        default: ''
    },
    type: {
        type: String,
        default: 'text'
    },
    name: {
        type: String,
        default: '',
    },
    placeholder: {
        type: String,
        default: '',
    },
    errors: {
      type: Object,
      default: () => {}
    },
    modelValue: {
      type: String,
      default: '',
    }
});

const inputValue = ref(props.modelValue);

watch(inputValue, (newValue) => {
  emit('update:modelValue', newValue);
});
</script>

<template>
  <div>
    <input :type="type" :id="id" :name="name" v-model="inputValue" :placeholder="placeholder"/>
    <span v-if="errors[id]" class="block text-red-500 text-sm">
        <span v-for="error in errors[id]" :key="error">{{ error }}</span>
      </span>
  </div>
</template>

<style scoped>

</style>
