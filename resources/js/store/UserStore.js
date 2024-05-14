// src/store/UserStore.js
import { defineStore } from "pinia";

export const useUserStore = defineStore({
    id: "user",
    state: () => ({
        userId: null,
    }),
    actions: {
        setUserId(id) {
            this.userId = id;
        },
    },
});
