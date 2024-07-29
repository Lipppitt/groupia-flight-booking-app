import {defineStore} from "pinia";
import {computed, ref} from "vue";
import axios from "axios";
import {useRoute, useRouter} from "vue-router";
import type {UserType} from "@/types/userType";

const BASE_URL = import.meta.env.VITE_BASE_URL;

export const useUserStore = defineStore('user', () => {
    const router = useRouter();
    const route = useRoute();
    const user = ref<UserType | null>(null);

    const isAuthenticated = computed(() => {
        return user.value?.id ?? false;
    });

    const getUser = computed(() => {
        return user.value;
    })

    async function fetchUser() {
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

    async function register(data: {name: string; email: string, password: string; password_confirmation: string}) {
        try {
            await setCSFRToken();

            const response = await axios.post('/register', data, {
                baseURL: BASE_URL,
            });

            if (response.status === 204) {
                const redirectPath = typeof route.query?.redirect === 'string' ? route.query.redirect : 'account';
                await router.push(redirectPath);
            }
        } catch (err) {
           throw err;
        }
    }

    async function login(data: {email: string, password: string}) {
        try {
            await setCSFRToken();

            const response = await axios.post('/login', data, {
                baseURL: BASE_URL,
            });

            if (response.status === 204) {
                const redirectPath = typeof route.query?.redirect === 'string' ? route.query.redirect : 'account';
                await router.push(redirectPath);
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

    return { register, login, fetchUser, user, isAuthenticated, getUser }
})
