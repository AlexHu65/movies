<template>
    
    <div v-if="user" class="row flex-nowrap">
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
            <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                <a href="/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                    <span class="fs-5 d-none d-sm-inline">Centro de control</span>
                </a>
                <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                    <li class="nav-item">
                        <a href="/" class="nav-link align-middle px-0">
                            <i class="pi pi-home"></i> <span class="ms-1 d-none d-sm-inline">Home</span>
                        </a>
                    </li>
                    <li>
                        <a href="#submenu1" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                            <i class="pi pi-sliders-v"></i> <span class="ms-1 d-none d-sm-inline">Dashboard</span> 
                        </a>
                        <ul class="collapse show nav flex-column ms-1" id="submenu1" data-bs-parent="#menu">
                            <li class="w-100">
                                <a href="/dashboard/movies" class="nav-link px-0"> <i class="pi pi-video"></i> <span class="d-none d-sm-inline">Peliculas</span>  </a>
                            </li>
                            <li>
                                <a href="/dashboard/places" class="nav-link px-0"> <i class="pi pi-tag"></i> <span class="d-none d-sm-inline">Turnos</span> </a>
                            </li>
                            
                        </ul>
                    </li>
                    
                </ul>
                <hr>
                <div class="dropdown pb-4">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://www.svgrepo.com/show/466845/user-circle.svg" alt="hugenerd" width="30" height="30" class="rounded-circle">
                        <span class="d-none d-sm-inline mx-1">{{ user.name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                        <li><a class="dropdown-item" href="#">Cerrar sesión</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col py-3">

            <MoviesForm :id="id" v-if="(action === 'create' || action === 'edit') && section === 'movies'"/>

            <PlacesForm v-if="(action === 'create' || action === 'edit') && section === 'places'"/>

            <MoviesDataTable @edit-movie="(e) => handleEventMovie(e)" v-if="action === 'index' && section === 'movies'"/>
            
            <PlacesDataTable v-if="action === 'index' && section === 'places'"/>
        
        </div>
    </div>
</template>

<script>

import MoviesForm from '../movies/MoviesForm.vue';
import MoviesDataTable from '../movies/MoviesDataTable.vue';

import PlacesForm from '../places/PlacesForm.vue';
import PlacesDataTable from '../places/PlacesDataTable.vue';

export default {
    data() {
        return {
            action: null,
            section:null,
            id:null
        };
    },
    props:{
        user: null
    },
    components: {
        MoviesForm,
        MoviesDataTable,
        PlacesForm,
        PlacesDataTable
    },
    mounted(){
        this.action = action;
        this.section = section;
    },
    methods:{
        handleEventMovie(e){
            if(e){
                this.id = e;
                this.section = 'movies';
                this.action = 'edit';
            }
        },
        handleEventPlace(e){
            if(e){
                this.id = e;
                this.section = 'places';
                this.action = 'edit';
            }
        }
    }

}

</script>