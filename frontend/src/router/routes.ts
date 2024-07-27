import HomeView from "@/views/HomeView.vue";
import BookFlightView from "@/views/Booking/BookFlightView.vue";
import RegisterView from "@/views/Auth/RegisterView.vue";
import LoginView from "@/views/Auth/LoginView.vue";
import AccountView from "@/views/Auth/AccountView.vue";
import AccountBookingsView from "@/views/Auth/AccountBookingsView.vue";
import type {RouteRecordRaw} from "vue-router";
const routes: Array<RouteRecordRaw> = [
    {
        path: '/',
        name: 'home',
        component: HomeView
    },
    {
        path: '/book-flight',
        name: 'book-flight',
        component: BookFlightView,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/register',
        name: 'register',
        component: RegisterView,
        meta: {
            requiresGuest: true
        }
    },
    {
        path: '/login',
        name: 'login',
        component: LoginView,
        meta: {
            requiresGuest: true
        }
    },
    {
        path: '/account',
        name: 'account',
        component: AccountView,
        meta: {
            requiresAuth: true
        },
        routes: [
            {
                path: '/bookings',
                name: 'account-bookings',
                component: AccountBookingsView
            },
        ]
    },
]

export default routes;
