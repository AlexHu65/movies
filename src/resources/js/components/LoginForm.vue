<template>
    <div class="row justify-content-center p-0 m-0">
        <div class="col-4 p-0 m-0">
            <div v-if="loading" class="d-flex flex-column align-items-center justify-content-center pt-4 pb-4">
                <i  class="pi pi-spin pi-spinner" style="font-size: 5rem; color: green"></i>
                <span class="s20 m-4 font-weight-bold">
                Cargando ...
                </span>
            </div>
            <Panel v-if="!loading">
                <template #header>
                    <div class="d-flex justify-content-center w-100">
                        <img src="https://placehold.co/100x100"/>
                    </div>
                </template>
                <div class="d-flex flex-column">
                    <h3>Iniciar sesión</h3>
                    <form class="m-3" @submit.prevent="submit">
                        <div class="row pt-2 pb-2">
                            <label class="p-0 m-0 text-muted" for="username">Email</label>
                            <InputText id="username" :invalid="!data.email" type="text" v-model="data.email"/>
                            <small class="text-danger" v-if="errors && errors['email']" id="username-help">* {{  displayError('email') }}.</small>
                        </div>
                        <div class="row pt-2 pb-2">
                            <label class="p-0 m-0 text-muted" for="pass">Password</label>
                            <InputText id="pass" :invalid="!data.password" type="password" v-model="data.password"/>
                            <small class="text-danger" v-if="errors && errors['password']" id="username-help">* {{  displayError('password') }}.</small>
                            <small class="text-danger" v-if="message" id="username-help">* {{ message }}</small>
                        </div>

                        <div class="row pt-2 pb-2">
                            <Button v-if="!loading" type="submit" label="Login" />
                        </div>
                    </form>
                </div>
            </Panel>
        </div>
    </div>
</template>

<script>

import Panel from 'primevue/panel';
import InputText from 'primevue/inputtext';
import Password from 'primevue/password';
import FloatLabel from 'primevue/floatlabel';
import Button from 'primevue/button';
import loginService from '../services/loginService';
import { setToken} from '../services/mainService'

export default {
    data() {
        return {
            data: {
                email:'',
                password:'',
            },
            errors: null,
            loading: false,
            success: false,
            message: null
        };
    },
    components:{
        Panel,
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

                this.message = 'Error al iniciar sesion, valida tus datos'
            });
        }
    }
}

</script>