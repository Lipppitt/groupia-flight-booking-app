import { createRouter, createWebHistory } from 'vue-router'
import {useUserStore} from "@/stores/userStore";
import routes from "@/router/routes";

const router = createRouter({
  history: createWebHistory(),
  routes,
});
router.beforeEach(async (to, from, next) => {
  const userStore= useUserStore();
  if (!userStore.getUser) {
    try {
      await userStore.fetchUser();
    } catch (err) {}
  }

  const requiresAuth = to.meta.requiresAuth ?? false;
  const requiresGuest = to.meta.requiresGuest ?? false;

  if (requiresAuth) {
    if (!userStore.isAuthenticated) {
      return next({ name: 'login', query: {redirect: to.fullPath}});
    }
  }

  if (requiresGuest) {
    if (userStore.isAuthenticated) {
      return next({ name: 'account' });
    }
  }

  next();
});

export default router
