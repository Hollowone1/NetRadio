import { defineStore } from 'pinia';

export const useUserStore = defineStore('user', {
    state() {
        return {
            loggedIn: false,
            user : [],
            tokens : {
                access_token: '',
                refresh_token: ''
            }
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
            this.tokens = {
                access_token: '',
                refresh_token: ''
            };
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
