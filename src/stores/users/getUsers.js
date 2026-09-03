import {defineStore} from "pinia";
import {reactive} from "vue";
import {client} from "@/plugins/axios.js";

export const useGetUsers = defineStore('getUsers', () => {
    const userState = reactive({
        users: [],
        count: 0,
    })

    function getUsers(url = '') {
        return new Promise((resolve, reject) => {
            client.get('users/getCollectionOfUsers' + url)
                .then((res) => {
                    console.log('Users are accessed')
                    userState.users = res.data.member;
                    userState.count = res.data.totalItems;
                    resolve();
                })
                .catch(() => {
                    console.log('ERROR, users are not accessed')
                    reject();
                })
        })
    }

    return {getUsers, userState}
})