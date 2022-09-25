import { createRouter, createWebHashHistory } from "vue-router";
import { useStore } from "@Assets/ts/store";

import Ranks from "@Views/ranks/ranks.vue";
import Users from "@Views/users/users.vue";
import Extras from "@Views/extras/extras.vue"

declare var THE_SERVER: any;

const routes = [
  { path: "/", name: "ranks", component: Ranks },
  { path: "/usuarios", name: "users", component: Users },
  { path: "/usuarios/extras", name: "extras", component: Extras },
];

export const router = createRouter({
  history: createWebHashHistory(),
  routes,
});
