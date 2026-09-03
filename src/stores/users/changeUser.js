import {defineStore} from "pinia";
import {client} from '@/plugins/axios.js';

const host = import.meta.env.VITE_API_DOMEN

export const useChangeUser = defineStore('changeUser', () => {
    function changeUser(id, data) {
        return new Promise((resolve, reject) => {
            client.patch('users/' + id, data)
                .then((res) => {
                    console.log('User\'s information is changed successfully')
                    resolve(res);
                })
                .catch(() => {
                    console.log('ERROR, user\'s information is not changed')
                    reject();
                })
        })
    }
    return {changeUser}
})