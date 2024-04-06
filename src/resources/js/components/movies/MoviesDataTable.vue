<template>
    <div class="container">
        <div class="row">
            <div class="col">

                <div class="d-flex justify-content-between align-items-center">
                    <h1>Peliculas</h1>
                    <a href="/dashboard/movies/create" type="button" class="btn btn-success"> <i class="pi pi-plus-circle"> </i> Nueva pelicula</a>
                </div>
                <!-- Modal places -->
                <div v-if="selectPlaces">
                    <div class="container bg-light p-4">
                        <div class="row">
                            <div class="col text-dark">
                                <h2 class="text-dark">Asignar turnos a {{ selectedMovie.name }}</h2>
                                <MultiSelect v-model="selectedPlaces" :options="places" optionLabel="place" placeholder="Seleccionar turnos"
                                    :maxSelectedLabels="3" class="w-full md:w-20rem" />
                                <div class="d-flex justify-content-start">
                                    <button @click="assignPlaces()" class="btn btn-success m-1"><i class="pi pi-check"></i></button>
                                    <button @click="() => {selectPlaces = false; selectedMovie = null}" class="btn btn-danger m-1"><i class="pi pi-times-circle"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <table v-if="movies && !selectPlaces" class="table table-dark table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Poster</th>
                            <th scope="col">Id <a @click="sortData('id')"><i :class="`pi pi-sort-alpha-down clickable`"></i></a></th>
                            <th scope="col">Nombre <a @click="sortData('name')"><i :class="`pi pi-sort-alpha-down clickable`"></i></a></th>
                            <th scope="col">F. Publicación <a @click="sortData('premiere')"><i :class="`pi pi-sort-alpha-down clickable`"></i></a></th>
                            <th scope="col">Turnos </th>
                            <th scope="col">Estado <a @click="sortData('active')"><i :class="`pi pi-sort-alpha-${sort === 'asc' && column === 'id' ? 'down' : 'up'} clickable`"></i></a></th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    
                    <tbody v-if="!loading">
                        <tr v-for="(item, index) in movies">
                            <td><img data-bs-toggle="modal" :data-bs-target="`#thumbModal${item.id}`" class="img-thumbnail rounded float-start w-30 clickable" :src="`${config.baseURL}/storage/${item.poster}`"> </td>
                            <td>{{ item.id }}</td>
                            <td>{{ item.name }}</td>
                            <td>{{ item.premiere}}</td>
                            <td>{{ item.places.map(place => place.place)}}</td>
                            <td><span :class="`badge bg-${item.active ? 'success' : 'danger'}`">{{ item.active ? 'Activo' : 'Inactivo'}}</span></td>
                            <td>
                                <div class="d-flex justify-content-start">
                                    <button v-if="places && places.length > 0" @click="selectionPlace(item)" v-tooltip.top="'Asignar turno'" class="btn btn-light m-1"><i class="pi pi-tag"></i></button>
                                    <button @click="disable(item.id, index)" v-tooltip.top="'Desactivar'" class="btn btn-light m-1"><i class="pi pi-lock"></i></button>
                                    <button @click="$emit('editMovie', item.id)" v-tooltip.top="'Editar'" class="btn btn-light m-1"><i class="pi pi-pencil"></i></button>
                                    <button @click="destroy(item.id)"  v-tooltip.top="'Eliminar'" class="btn btn-light m-1"><i class="pi pi-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div v-for="(item, index) in movies" class="modal fade" :id="`thumbModal${item.id}`" tabindex="-1" aria-labelledby="thumbModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="posterModalLabel">{{ item.name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img class="w-100" :src="`${config.baseURL}/storage/${item.poster}`">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column align-items-center justify-content-center">
        <div v-if="loading" class="d-flex flex-column align-items-center justify-content-center pt-4 pb-4">
            <i class="pi pi-spin pi-spinner" style="font-size: 5rem; color: green"></i>
            <span class="s20 m-4 font-weight-bold">
            Cargando ...
            </span>
        </div>
    </div>
</template>

<script setup>
    defineEmits(['editMovie'])
</script>

<script>

import { getMe } from '../../helpers/validate';
import { config } from '../../config/main';
import { removeToken } from '../../services/mainService';
import { post, deleteData, get, putData } from '../../services/mainService';
import MultiSelect from 'primevue/multiselect';

export default {
    data() {
        return {
            user: null,
            movies:null,
            selectedMovie:null,
            pagination:null,
            sort:'asc',
            column: 'id',
            config: config,
            loading:false,
            page:1,
            places:null,
            selectedPlaces:[],
            selectPlaces:false,
        };
    },
    components: {
        MultiSelect
    },
    mounted(){
        this.fetchMovies();
        this.fetchPlaces();
    },
    methods:{
        sortData(column){

            this.column = column;

            this.sort = (this.sort === 'asc' ? 'desc' : 'asc');

            this.fetchMovies();

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
        selectionPlace(item){
            
            this.selectPlaces = true;

            this.selectedMovie = item;
            
            const newData = item.places.map(item => ({
                id: item.id,
                place: item.place
            }));

            this.selectedPlaces = newData;
        },
        disable(id, index){

            this.$swal.fire({
                title: "Cambiar estatus",
                text: "Se cambiara el status de la pelicula",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    get(`movies/disable/${id}`).then((response) => {
                        if(response.data.status){
                            const { data } = response.data;
                            this.movies[index].active = data.active;
                        }
                    }).catch(err => console.warn('err', err));
                }
            });
        },
        destroy(id){

            this.$swal.fire({
                title: "Eliminar",
                text: "Se eliminara la pelicula",
                icon: "error",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteData(`movies/${id}`).then((response) => {
                        if(response.data.status){
                            this.fetchMovies();
                        }
                    }).catch(err => console.warn('err', err));
                }
            });
        },
        assignPlaces(){

                this.loading = true;

                const data = {
                    'places' : this.selectedPlaces.map(place => place.id)
                };

                const id = this.selectedMovie.id;

                post(`movies/assign/${id}`, data).then((response) => {

                    if(response.data.status){

                        window.location.reload();
                    }
                })
        },
        fetchMovies(){

            this.loading = true;

            get(`movies?page=${this.page}&sort=${this.sort}&column=${this.column}`).then((response) => {
                
                if(response.data.status){

                    const { data } = response.data;
                
                    const { pagination } = response.data;

                    this.movies = data;

                    this.pagination = pagination;

                    this.loading = false;
                }

            }).catch(err => console.warn('err', err));

        },

        fetchPlaces(){

            get(`places/get/all`).then((response) => {
                
                if(response.data.status){

                    const { data } = response.data;
                
                    const { pagination } = response.data;

                    this.places = data;
                
                    this.pagination = pagination;

                    this.loading = false;
                }

            }).catch(err => console.warn('err', err));

            },
        getSession(){
            
            getMe().then((response) => {

                const { status, data } = response.data;
                
                if(status){

                    this.user = data.user;

                }else{
                    window.location.href = `${config.baseURL}`;
                }

            }).catch((err) =>  {
                removeToken();
                window.location.href = `${config.baseURL}`;
            });
        }
    }

}

</script>