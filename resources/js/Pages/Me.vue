<template>
    <div>
       <Container>
            <update-user :user = "user" :errors="errors"/>
            <update-password :user = "user" :errors="errors"/>
            
       </Container>
    </div>
    
</template>

<script>
import Container from './Templates/Container'
import UpdateUser from './Templates/UpdateUser'
import UpdatePassword from './Templates/UpdatePassword'


export default {
    props: {
        errors : {
            Type: Object,
            default: {
                email: [],
                password: [],
                name: [],
                password_confirmation: [],
            }

        },
        user: Object
    },
    components: {
        Container,
        UpdateUser,
        UpdatePassword,
    },

    methods: {

    },

}

</script>

<style>
.dashboard-write-post{
    padding-top:100px;
    padding-bottom:100px;
}




</style>
