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
            //this.user = user;
            //this.$api.get()
        },
        logoutUser() {
            this.loggedIn = false;
            this.user = [];
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
