import {useUserStore} from "@/stores/userStore";

export const auth = (to, from, next) => {
    const userStore = useUserStore();

    console.log(userStore.isAuthenticated);

    if (userStore.isAuthenticated) {
        next();
    } else {
        next({ name: 'login' });
    }
};


