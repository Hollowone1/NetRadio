import { defineStore } from 'pinia';

export const useUserStore = defineStore('userStore', {
    state() {
        return {
            loggedIn: false,
            //user : []
            user: {
                mail: "presentateur9@example.com",
                prenom : "Non",
                nom : "AhGars",
                role: 2
            },
        }
    },
    actions: {
        loginUser() {
            this.user.loggedIn = true;
            //this.user = user;
        },
        logoutUser() {
            this.user.loggedIn = false;
            this.user = [];
        },
    },
    persist: {
        enabled: true,
        strategies: [
            {
                storage: localStorage,
                paths: ['user']
            },
        ],
    }
});
