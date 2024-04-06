<template>
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="d-flex justify-content-between align-items-center">
                    <h1>Turnos</h1>
                    <a href="/dashboard/places/create" type="button" class="btn btn-success"> <i class="pi pi-plus-circle"> </i> Nuevo turno</a>
                </div>
                <table v-if="places"class="table table-dark table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Id <a @click="sortData('id')"><i :class="`pi pi-sort-alpha-down clickable`"></i></a></th>
                            <th scope="col">Turno <a @click="sortData('place')"><i :class="`pi pi-sort-alpha-down clickable`"></i></a></th>
                            <th scope="col">Estado <a @click="sortData('active')"><i :class="`pi pi-sort-alpha-${sort === 'asc' && column === 'id' ? 'down' : 'up'} clickable`"></i></a></th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    
                    <tbody v-if="!loading">
                        <tr v-for="(item, index) in places">
                            <td>{{ item.id }}</td>
                            <td>{{ item.place }}</td>
                            <td><span :class="`badge bg-${item.active ? 'success' : 'danger'}`">{{ item.active ? 'Activo' : 'Inactivo'}}</span></td>
                            <td>
                                <div class="d-flex justify-content-start">
                                    <button @click="$emit('editPlace', item.id)" v-tooltip.top="'Editar'" class="btn btn-light m-1"><i class="pi pi-pencil"></i></button>
                                    <button @click="disable(item.id, index)" v-tooltip.top="'Desactivar'" class="btn btn-light m-1"><i class="pi pi-lock"></i></button>
                                    <button @click="destroy(item.id)" v-tooltip.top="'Eliminar'" class="btn btn-light m-1"><i class="pi pi-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
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
    defineEmits(['editPlace'])
</script>

<script>

import { getMe } from '../../helpers/validate';
import { config } from '../../config/main';
import { removeToken } from '../../services/mainService';
import { post, deleteData, get, putData } from '../../services/mainService';

export default {
    data() {
        return {
            user: null,
            places:null,
            pagination:null,
            sort:'asc',
            column: 'id',
            config: config,
            id:null,
            loading:false,
            page:1
        };
    },
    components: {
    },
    mounted(){
        this.fetchPlaces();
    },
    methods:{
        sortData(column){

            this.column = column;

            this.sort = (this.sort === 'asc' ? 'desc' : 'asc');

            this.fetchPlaces();

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
        disable(id, index){

            this.$swal.fire({
                title: "Cambiar estatus",
                text: "Se cambiara el status del turno",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    get(`places/disable/${id}`).then((response) => {
                        if(response.data.status){
                            const { data } = response.data;
                            this.places[index].active = data.active;
                        }
                    }).catch(err => console.warn('err', err));
                }
            });
        },
        destroy(id){

            this.$swal.fire({
                title: "Eliminar",
                text: "Se eliminara el turno",
                icon: "error",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteData(`places/${id}`).then((response) => {
                        if(response.data.status){
                            this.fetchPlaces();
                        }
                    }).catch(err => console.warn('err', err));
                }
            });
        },
        fetchPlaces(){

            this.loading = true;

            get(`places?page=${this.page}&sort=${this.sort}&column=${this.column}`).then((response) => {
                
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