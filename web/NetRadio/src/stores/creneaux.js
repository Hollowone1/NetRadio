import { defineStore } from 'pinia';

export const useCreneauxStore = defineStore('creneaux', {
  state() {
    return {
      creneaux: [],
    }
  },
  actions: {
    async fetchCreneaux() {
      const response = await this.$api.get('/creneaux'); 
      this.creneaux = response.data.creneaux;
    },
  },
  persist: {
    enabled: true,
    strategies: [
      {
        storage: localStorage,
        paths: ['creneaux'],
      },
    ],
  },
});