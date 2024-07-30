<script setup lang="ts">
  import {useHelpers} from "@/composibles/useHelpers";

  const props = defineProps({
      arrives: {
          type: Object,
          required: true
      },
      departs: {
          type: Object,
          required: true
      },
      totalPrice: {
          type: Number,
          default: null,
      },
      currency: {
        type: String,
        default: ''
      },
      duration: {
        type: String,
        required: true
      }
  });

  const {getCurrencySymbolFromString, getFormattedDate} = useHelpers();
</script>

<template>
  <div class="bg-white h-full px-6 rounded-lg pt-3 pb-4 flex flex-col space-y-2 ">
    <h2 class="text-2xl">{{departs.city_code}} - {{arrives.city_code}}</h2>
    <p>
      <strong>Departs:</strong> {{getFormattedDate(departs.time)}}<br>
      <strong>Arrives:</strong> {{getFormattedDate(arrives.time)}}
    </p>
    <p class="text-lg font-semibold text-orange">{{getCurrencySymbolFromString(props.currency)}}{{props.totalPrice}}</p>
    <slot></slot>
  </div>
</template>

<style scoped>

</style>
