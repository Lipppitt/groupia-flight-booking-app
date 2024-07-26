import {ref} from "vue";
import axios from "axios";

export function useFlights() {
    const isLoading = ref(false);
    const error = ref(null);
    const flights = ref([]);

    async function fetchFlights() {
        try {
            isLoading.value = true;

            const response = await axios.get('/flights');

            if (response.data?.flights) {
                flights.value = response.data.flights;
            }
        } catch (err) {
            if (err.message) {
                error.value = err.message;
            }
        } finally {
            isLoading.value = false;
        }
    }

    return { fetchFlights, flights, isLoading, error }
}
