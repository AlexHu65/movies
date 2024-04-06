import { config } from '../config/main';
import loginService from '../services/loginService';

export const getMe = () => {
    return new Promise((resolve, reject) => {
        loginService.get('login/me').then(response => {
            resolve(response);
        })
        .catch(err => reject(`No se pudo consultar el servicio ${err}`))
    });
}

export const validateSession = () => {

    getMe().then(response => {

        const {data, status} = response.data;

        if(status && data.user){

            window.location.href = `${config.baseURL}/dashboard`;

        }
    });
}

