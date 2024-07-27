import {defineStore} from "pinia";
import {computed, ref} from "vue";
import axios from "axios";
import {useRoute, useRouter} from "vue-router";

const BASE_URL = import.meta.env.VITE_BASE_URL;

export const useUserStore = defineStore('user', () => {
    const router = useRouter();
    const route = useRoute();
    const user = ref(null);

    const isAuthenticated = computed(() => {
        return user.value?.id ?? false;
    });

    async function getUser() {
        try {
            const response = await axios.get('/user', {
                withCredentials: true,
                withXSRFToken: true,
            });

            if (response.data) {
                user.value = response.data;
            }
        } catch (err) {
            throw err;
        }
    }

    async function register(data) {
        try {
            await setCSFRToken();

            const response = await axios.post('/register', data, {
                baseURL: BASE_URL,
            });

            if (response.status === 204) {
                await router.push(route.query?.redirect || 'account')
            }
        } catch (err) {
           throw err;
        }
    }

    async function login(data) {
        try {
            await setCSFRToken();

            const response = await axios.post('/login', data, {
                baseURL: BASE_URL,
            });

            if (response.status === 204) {
                await router.push(route.query?.redirect || 'account')
            }
        } catch (err) {
            throw err;
        }
    }

    async function setCSFRToken() {
        await axios.get('/sanctum/csrf-cookie', {
            baseURL: BASE_URL,
        });
    }

    return { register, login, user, isAuthenticated, getUser }
})
