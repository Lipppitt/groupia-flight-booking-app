import {useUserStore} from "@/stores/userStore";

export const guest = (to, from, next) => {
    const userStore = useUserStore();
    if (!userStore.user) {
        next();
    } else {
        next({ name: 'home' });
    }
};

