<script setup lang="ts">
import {useFlights} from "@/composibles/useFlights";
import {onMounted} from "vue";
import FlightListing from "@/components/FlightListings/FlightListing.vue";
import {useUserStore} from "@/stores/userStore";

const userStore = useUserStore();

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
    <div v-for="flight in flights" :key="flight.uuid" class="w-4/12 mb-4">
      <div class="px-2 h-full">
        <FlightListing
            :arrives="flight.arrives"
            :departs="flight.departs"
            :duration="flight.total_duration"
            :total-price="flight.total_price"
            :currency="flight.currency"
        >
          <router-link v-if="!userStore.getUser?.booking_flight_ids.includes(flight.uuid)" :to="{name: 'book-flight', query: {id: flight.uuid}}" class="btn">
            Book Now
          </router-link>
          <span v-else class="bg-gray-200 border border-gray-200 rounded px-4 py-2 text-center ">
            Booked
          </span>
        </FlightListing>
      </div>
    </div>
  </div>
  <div v-else-if="error">
      {{error}}
  </div>
</template>

<style scoped>

</style>
