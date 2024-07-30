<script setup lang="ts">

import {useBookings} from "@/composibles/useBookings";
import {onMounted} from "vue";
import {useRoute} from "vue-router";
import DefaultLayout from "@/layouts/DefaultLayout.vue";

const route = useRoute();

const {fetchBooking, cancelBooking, booking, isLoading} = useBookings();

const handleCancelBooking = async () => {
  if (booking.value?.uuid) {
    await cancelBooking(booking.value.uuid);
  }
}

onMounted(async () => {
  if (route.params.id) {
    const id = route.params?.id?.toString();
    if (id) {
      await fetchBooking(id);
    }
  }
});
</script>

<template>
  <DefaultLayout>
      <div v-if="isLoading">
          Loading...
      </div>
      <div v-else-if="booking?.uuid">
        <p v-if="booking?.status" class="font-bold">Booking {{booking.status}}.</p>
        <h1 v-if="booking.status === 'completed'">Thank you for booking.</h1>
        <p>Your booking ID is: {{route.params.id}}</p>
        <button v-if="booking.status === 'completed'"
                class="btn" @click="handleCancelBooking">
          Cancel Booking
        </button>
      </div>
  </DefaultLayout>
</template>
