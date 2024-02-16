import { defineStore } from 'pinia';

export const useUserStore = defineStore('user', {
    state() {
        return {
            loggedIn: false,
            user : [],
            tokens : []
        }
    },
    actions: {
        loginUser(tokens) {
            this.loggedIn = true;
            this.tokens = tokens;
        },
        setUser(user) {
            this.user = user;
        },
        logoutUser() {
            this.loggedIn = false;
            this.user = [];
            this.tokens = [];
        },
    },
    persist: {
        enabled: true,
        strategies: [
            {
                storage: localStorage,
                //paths: ['user']
            },
        ],
    }
});
