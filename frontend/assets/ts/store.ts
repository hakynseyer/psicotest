import { defineStore } from 'pinia';

export const useStore = defineStore('main', {
  state: () => ({
    creador: 'Joaquin Reyes Sánchez',
    creadorEmail: 'hakynseyer@gmail.com',
    token: null,
  }),
  persist: {
    enabled: true,
    strategies: [
      {
        storage: sessionStorage,
        paths: ['creador', 'creadorEmail'],
      },
      { storage: localStorage, paths: ["token"] },
    ],
  },
});
