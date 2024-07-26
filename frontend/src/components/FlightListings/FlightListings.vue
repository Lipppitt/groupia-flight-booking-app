<script setup lang="ts">
import {useFlights} from "@/composibles/useFlights";
import {onMounted} from "vue";
import FlightListing from "@/components/FlightListings/FlightListing.vue";

const {fetchFlights, flights, error, isLoading} = useFlights();

onMounted(async () => {
  await fetchFlights();
});
</script>

<template>
  <div v-if="isLoading">
      Loading...
  </div>
  <div v-else-if="flights.length > 0" class="flex flex-wrap">
    <div v-for="flight in flights" :key="flight.uuid" class="w-4/12">
      <div class="px-2 mb-4">
        <FlightListing
            :uuid="flight.uuid"
            :arrives="flight.arrives"
            :departs="flight.departs"
            :duration="flight.total_duration"
            :total-price="flight.total_price"
            :currency="flight.currency"
        />
      </div>
    </div>
  </div>
  <div v-else-if="error">
      {{error}}
  </div>
</template>

<style scoped>

</style>
