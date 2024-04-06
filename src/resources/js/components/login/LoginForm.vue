<template>
    <div class="d-flex justify-content-center align-items-center">
        <div class="w-800 h-800 row pt-5 m-0">
            <div class="d-flex justify-content-center align-items-center">
                <div v-if="loading" class="d-flex flex-column align-items-center justify-content-center pt-4 pb-4">
                    <i  class="pi pi-spin pi-spinner" style="font-size: 5rem; color: green"></i>
                    <span class="s20 m-4 font-weight-bold">
                    Cargando ...
                    </span>
                </div>
                <Card class="w-300 rouned" v-if="!loading">
                    <template #content>
                        <div class="d-flex flex-column">
                            <div class="logo-login d-flex justify-content-center w-100">
                                <img src="https://www.svgrepo.com/show/485038/movie-film.svg"/>
                            </div>
                            <form class="m-3" @submit.prevent="submit">
                                <div class="row pt-2 pb-2">
                                    <InputText placeholder="Email" class="rounded-pill" id="username" :invalid="!data.email && attemp" type="text" v-model="data.email"/>
                                    <small class="text-danger" v-if="errors && errors['email']" id="username-help">* {{  displayError('email') }}.</small>
                                </div>
                                <div class="row pt-2 pb-2">
                                    <InputText placeholder="Contraseña" class="rounded-pill" id="pass" :invalid="!data.password && attemp" type="password" v-model="data.password"/>
                                    <small class="text-danger" v-if="errors && errors['password']" id="username-help">* {{  displayError('password') }}.</small>
                                    <small class="text-danger" v-if="message" id="username-help">* {{ message }}</small>
                                </div>
                                <div class="row pt-2 pb-2">
                                    <Button v-if="!loading" type="submit" label="Login" />
                                </div>
                            </form>
                        </div>
                    </template>
                </Card>
            </div>
        </div>
    </div>
</template>
<script>

import Card from 'primevue/card';
import InputText from 'primevue/inputtext';
import Password from 'primevue/password';
import FloatLabel from 'primevue/floatlabel';
import Button from 'primevue/button';
import loginService from '../../services/loginService';
import { setToken} from '../../services/mainService'

export default {
    data() {
        return {
            data: {
                email:'',
                password:'',
            },
            errors: null,
            loading: false,
            attemp: false,
            message: null
        };
    },
    components:{
        Card,
        InputText,
        Password,
        FloatLabel,
        Button
    },
    mounted(){

    },
    methods: {

        displayError(key){
            const [error] = this.errors[key];
            return error;
        },
        submit(){

            this.loading = true;

            this.attemp = true;
            
            loginService.post('login', this.data).then((response) => {

                this.loading = false;

                const { data } = response;

                if(data.status){

                    const { token } = data.authorization;

                    if(token){

                        setToken(token);

                        this.loading = true;

                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    }

                }else{
                    
                    const { error } = response.data.data;
                    
                    this.errors = error;
                }
            })
            .catch((error) => {

                this.loading = false;

                console.warn("Error al iniciar sesión: " + error.message);
                        
                const { data } = error.response.data;

                this.errors = data;

                this.message = 'Error al iniciar sesión, valida tus datos'
            });
        }
    }
}

</script>