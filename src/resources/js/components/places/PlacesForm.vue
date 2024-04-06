<template>
    <div class="container">
        
        <div class="row d-flex justify-content-start align-items-center">
            <div class="col-sm-8">
                <div class="card p-3">
                    <form @submit.prevent="submit">
                        <div class="d-flex justify-content-end">
                            <a href="/dashboard/movies" type="button" class="btn btn-danger"> <i class="pi pi-times-circle"></i></a>
                        </div>
                        <h1 class="black">Nuevo turno</h1>
                        <div class="mb-3">
                            <div class="row p-2">
                                <label for="place" class="form-label black">Turno</label>
                                <Calendar showTime hourFormat="12" class="m-0 p-0" id="place" v-model="place.place" />
                                <small class="text-danger" v-if="errors && errors['place']" id="place-help">* {{  displayError('place') }}.</small>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row p-2">
                                <label for="active" class="ml-2 text-dark">Activo</label>
                                <Checkbox v-model="place.active" invalid binary />
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary"><i v-if="loading" class="pi pi-spin pi-spinner" style="color: white"></i> <span v-if="!loading">Guardar</span></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import InputText from 'primevue/inputtext';
import Calendar from 'primevue/calendar';
import {initPlaces} from '../../models/initials';
import { post, deleteData, get, putData } from '../../services/mainService';
import { config } from '../../config/main';
import Checkbox from 'primevue/checkbox';

    export default {
        data() {
            return {
                place: initPlaces,
                errors: null,
                loading: false,
                attemp: false,
            };
        },
        props:{
            id:null
        },
        components: {
            Calendar,
            InputText,
            Checkbox
        },
        mounted(){
            if(this.id){
                this.fetchPlace(this.id);
            }
        },
        methods:{
            displayError(key){
                const [error] = this.errors[key];
                return error;
            },
            handleFileChange(event){
                const [file] = event.target.files;
                this.movie.poster = file;
            },
            showAlert(title, text, icon){
               return this.$swal.fire({
                    title: `${title}`,
                    text: `${text}`,
                    icon: `${icon}`,
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'De acuerdo'
                });
            },
            fetchPlace(id){

                this.loading = true;

                get(`places/${id}`).then((response) => {

                    if(response.data.status){

                        const { data } = response.data;

                        this.place = data;

                        this.loading = false;
                    }

                }).catch(err => console.warn('err', err));

            },
            submit(){

                const data = this.place;
                
                this.loading = true;

                this.attemp = true;

                if(this.id){

                    putData(`places/${this.id}`,data).then((response) => {
    
                        if(response.data.status){
                            this.showAlert('Guardado con éxito', 'Se ha guardado con exito.', 'success');
                            setTimeout(()=> {
                                window.location.href = `${config.baseURL}/dashboard/${section}`
                            }, 2000);
                        }else{
                            this.loading = false;
                        }
                    }).catch((error) => {
                        
                        this.loading = false;

                        console.warn(error);

                        const { data } = error.response.data;

                        this.errors = data;

                    })

                    
                }else{
                    post('places',data).then((response) => {
    
                        if(response.data.status){
                            this.showAlert('Guardado con éxito', 'Se ha guardado con exito.', 'success');
                            setTimeout(()=> {
                                window.location.href = `${config.baseURL}/dashboard/${section}`
                            }, 2000);
                        }else{
                            this.loading = false;
                        }
                    }).catch((error) => {
                        
                        this.loading = false;
    
                        console.warn(error);
    
                        const { data } = error.response.data;
    
                        this.errors = data;
    
                    })

                }
            }
        }
}

</script>