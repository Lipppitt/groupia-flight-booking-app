import { createRouter, createWebHistory } from 'vue-router'
import {useUserStore} from "@/stores/userStore";
import routes from "@/router/routes";

const router = createRouter({
  history: createWebHistory(),
  routes,
})

router.beforeEach(async (to, from, next) => {
  const userStore = useUserStore();
  if (!userStore.user) {
    try {
      await userStore.getUser();
    } catch (err) {}
  }
  next();
});

export default router
