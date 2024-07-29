<script setup lang="ts">
import {useBookings} from "@/composibles/useBookings";
import {onMounted} from "vue";

const {fetchUsersBooking, usersBookings, isLoading} = useBookings();

onMounted(async() => {
  await fetchUsersBooking();
});

</script>

<template>
  <main>
    <div class="container">
      <h1 class="text-xl font-bold">My Bookings</h1>
      <div v-if="isLoading">
        Loading...
      </div>
      <div v-else-if="usersBookings">
          <router-link :to="{name: 'booking-order', params: {id: userBooking.uuid}}" v-for="userBooking in usersBookings" :key="userBooking.uuid">
            <h2 class="text-lg">{{userBooking.departs.city_code}} - {{userBooking.arrives.city_code}}</h2>
            <p>{{userBooking.status}}</p>
          </router-link>
      </div>
    </div>
  </main>
</template>
