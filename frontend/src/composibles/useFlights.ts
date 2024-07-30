import {ref} from "vue";
import axios, {type AxiosError} from "axios";
import type {FlightType} from "@/types/flightType";

export function useFlights() {
    const isLoading = ref(false);
    const error = ref<string | null>(null);
    const flights = ref<FlightType[]>([]);

    async function fetchFlights() {
        try {
            isLoading.value = true;

            const response = await axios.get('/flights');

            if (response.data?.flights) {
                flights.value = response.data.flights;
            }
        } catch (err) {
            const axiosError = err as AxiosError;
            if (axiosError.message) {
                error.value = axiosError.message;
            }
        } finally {
            isLoading.value = false;
        }
    }

    return { fetchFlights, flights, isLoading, error }
}
