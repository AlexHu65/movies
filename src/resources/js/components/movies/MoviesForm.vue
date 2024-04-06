<template>
    <div class="container">
        
        <div class="row d-flex justify-content-start align-items-center">
            <div class="col-sm-8">
                <div class="card p-3">
                    <form @submit.prevent="submit">
                        <div class="d-flex justify-content-end">
                            <a href="/dashboard/movies" type="button" class="btn btn-danger"> <i class="pi pi-times-circle"></i></a>
                        </div>
                        <h1 class="black">{{ id ? 'Editar' : 'Nueva' }} película</h1>
                        <div class="mb-3">
                            <div class="row p-2">
                                <label for="name" class="form-label black">Nombre</label>
                                <InputText v-model="movie.name" type="text" id="name"/>
                                <small class="text-danger" v-if="errors && errors['name']" id="name-help">* {{  displayError('name') }}.</small>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="row p-2">
                                <label for="premiere" class="form-label black">F. Publicación</label>
                                <Calendar class="m-0 p-0" id="premiere" v-model="movie.premiere" />
                                <small class="text-danger" v-if="errors && errors['premiere']" id="premiere-help">* {{  displayError('premiere') }}.</small>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row p-2">
                                <label for="poster" class="form-label black">Imagen</label>
                                <input @change="(e) => handleFileChange(e)" type="file" accept="image/*" id="poster">
                                <small class="text-danger" v-if="errors && errors['poster']" id="poster-help">* {{  displayError('poster') }}.</small>
                            </div>
                        </div>
                        <button v-if="!loading" type="submit" class="btn btn-primary">Guardar</button>
                        <i v-if="loading" class="pi pi-spin pi-spinner" style="color: green"></i>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import InputText from 'primevue/inputtext';
import Calendar from 'primevue/calendar';
import {initMovies} from '../../models/initials';
import { post, deleteData, get, putData } from '../../services/mainService';
import { config } from '../../config/main';

    export default {
        data() {
            return {
                movie: initMovies,
                errors: null,
                loading: false,
                attemp: false,
                action: action
            };
        },
        components: {
            Calendar,
            InputText
        },
        props:{
            id:null
        },
        mounted(){
            if(this.id){
                this.fetchMovie(this.id);
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
            fetchMovie(id){

                this.loading = true;
                
                get(`movies/${id}`).then((response) => {
                
                    if(response.data.status){

                        const { data } = response.data;

                        this.movie = data;

                        this.loading = false;
                    }

                }).catch(err => console.warn('err', err));

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
            submit(){

                const data = this.movie;

                this.loading = true;

                this.attemp = true;

                const uri = (this.id ? `movies/${this.id}` : 'movies');

                post(uri, data).then((response) => {

                    if(response.data.status){
                        this.showAlert('Guardado con éxito', 'Se ha guardado con exito.', 'success');
                        setTimeout(()=> {
                            window.location.href = `${config.baseURL}/dashboard/${section}`
                        }, 3000);
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

</script>