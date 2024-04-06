<template>
    <div class="container">
        <div class="ro">
            <div class="col">
                datatable
            </div>
        </div>
    </div>
</template>

<script>

import { getMe } from '../../helpers/validate';
import { config } from '../../config/main';
import { removeToken } from '../../services/mainService';
import { post, deleteData, get, putData } from '../../services/mainService';

export default {
    data() {
        return {
            user: null,
            data:null,
            pagination:null,
            page:1
        };
    },
    components: {
    },
    mounted(){
        this.getData();
    },
    methods:{
        getData(){

            get(`movies?page=${this.page}`).then((response) => {
                
                if(response.data.status){

                    const { data } = response.data;
                
                    const { pagination } = response.data;

                    this.data = data;
                
                    this.pagination = pagination;
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