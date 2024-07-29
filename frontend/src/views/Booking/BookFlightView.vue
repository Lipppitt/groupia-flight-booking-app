<script setup lang="ts">

import {useBookings} from "@/composibles/useBookings";
import {onMounted} from "vue";
import {useRoute, useRouter} from "vue-router";
import DefaultLayout from "@/layouts/DefaultLayout.vue";

const router = useRouter();
const route = useRoute();

const {bookFlight, booking, status} = useBookings();

onMounted(async () => {
  if (route.query?.id) {
    await bookFlight(route.query.id);

    if (booking.value) {
        await router.push({name: 'booking-order', params: {id: booking.value.uuid}})
    }
  }
});

</script>

<template>
  <DefaultLayout>
      {{status}}
  </DefaultLayout>>
</template>
