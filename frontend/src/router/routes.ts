import HomeView from "@/views/HomeView.vue";
import BookFlightView from "@/views/Booking/BookFlightView.vue";
import {auth} from "@/middleware/auth";
import RegisterView from "@/views/Auth/RegisterView.vue";
import {guest} from "@/middleware/guest";
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
        beforeEnter: [auth],
    },
    {
        path: '/register',
        name: 'register',
        component: RegisterView,
        beforeEnter: [guest],
    },
    {
        path: '/login',
        name: 'login',
        component: LoginView,
        beforeEnter: [guest],
    },
    {
        path: '/account',
        name: 'account',
        component: AccountView,
        beforeEnter: [auth],
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
