import {ref} from "vue";
import axios from "axios";
import {useUserStore} from "@/stores/userStore";
import type {FlightBookingType} from "@/types/flightBookingType";

export function useBookings() {
    const userStore = useUserStore();
    const isLoading = ref(false);
    const status = ref('pending');
    const booking= ref<FlightBookingType | null>(null);
    const usersBookings = ref<[FlightBookingType] | []>([]);

    async function bookFlight(flightId: string) {
        try {
            isLoading.value = true;

            const response = await axios.post('/flight-bookings', {
                flight_id: flightId
            });

            if (response.data && response.data.flight_id) {
                booking.value = response.data;

                if (userStore.user) {
                    userStore.user.booking_flight_ids.push(response.data.flight_id);
                }
            }
        } catch (err) {

        } finally {
            isLoading.value = false;
        }
    }

    async function fetchBooking(flightId: string)
    {
        try {
            isLoading.value = true;

            const response = await axios.get(`/flight-bookings/${flightId}`);

            if (response.data) {
                booking.value = response.data;
            }
        } catch (err) {

        } finally {
            isLoading.value = false;
        }
    }

    async function fetchUsersBooking()
    {
        try {
            isLoading.value = true;

            const response = await axios.get(`/users-flight-bookings`);

            if (response.data) {
                usersBookings.value = response.data;
            }
        } catch (err) {

        } finally {
            isLoading.value = false;
        }
    }

    async function cancelBooking(bookingId: string)
    {
        try {
            isLoading.value = true;

            const response = await axios.patch(`/flight-bookings/${bookingId}/cancel`);

            if (response.data) {
                booking.value = response.data;
            }
        } catch (err) {

        } finally {
            isLoading.value = false;
        }
    }

    return { bookFlight, fetchUsersBooking, fetchBooking, cancelBooking, usersBookings, isLoading, status, booking}
}
