import {defineStore} from "pinia";
import axios from "axios";
export const useAuthorization = defineStore( 'authorization', () => {
    function userAuth(data) {
        return new Promise((resolve, reject) => {
            axios.post('http://localhost:8505/api/users/auth', data)
                .then((res) => {
                    console.log('Token Accessed')
                    localStorage.setItem('Token', res.data.token)
                    resolve();
                })
                .catch(() => {
                    console.log('Token not Accessed')
                    reject();
                })
        })
    }

    return {userAuth}
})