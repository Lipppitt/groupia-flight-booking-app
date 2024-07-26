import {defineStore} from "pinia";
import {computed, ref} from "vue";
import axios from "axios";

const BASE_URL = import.meta.env.VITE_BASE_URL;

export const useUserStore = defineStore('user', () => {
    const user = ref(null);

    const isAuthenticated = computed(() => {
       return user.value?.id;
    });

    async function getUser() {
        try {
            const response = await axios.get('/user', {
                withCredentials: true,
                withXSRFToken: true,
            });
            console.log(response);
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
