<template>
    <section>
        <div v-if="user" class="container-fluid">
            <Content :user="user"/>
        </div>
    </section>
</template>

<script>

import { getMe } from '../helpers/validate';
import { config } from '../config/main';
import { removeToken } from '../services/mainService';
import Content from './dashboard/Content.vue';

export default {
    data() {
        return {
            user: null
        };
    },
    components: {
        Content
    },
    mounted(){
        this.getSession();
    },
    methods:{
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