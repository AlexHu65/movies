<template>
    <section class="w-100">
        <LoginForm v-if="!token && !loading"/>  
    </section>
</template>

<script>

import LoginForm from './login/LoginForm.vue';
import { getToken } from '../services/mainService';
import { validateSession } from '../helpers/validate';

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

        validateSession();

    }
}

</script>