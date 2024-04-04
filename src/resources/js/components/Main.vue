<template>
    <section class="w-100">
        <LoginForm v-if="!token && !loading"/>    
    </section>
</template>

<script>

import LoginForm from './LoginForm.vue';
import { getToken } from '../services/mainService';

export default {
    data() {
        return {
            token: null,
            loading: false
        };
    },
    components: {
        LoginForm,
    },
    mounted(){
        this.token = getToken();
    },
    methods:{
        setLoad(e){
            this.loading = e;
            setTimeout(() => {
                window.location.reload();
            }, 1200);
        },
    }
}

</script>