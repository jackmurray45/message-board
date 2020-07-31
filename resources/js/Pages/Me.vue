<template>
    <div>
       <Container>
            <update-user :user = "user" :errors="errors"/>
            <update-password :user = "user" :errors="errors"/>
            <update-user-photos :user = "user" :errors="errors"/>
            
       </Container>
    </div>
    
</template>

<script>
import Container from './Templates/Container'
import UpdateUser from './Templates/UpdateUser'
import UpdatePassword from './Templates/UpdatePassword'
import UpdateUserPhotos from './Templates/UpdateUserPhotos'


export default {
    props: {
        errors : {
            Type: Object,
            default: {}

        },
        user: Object
    },
    components: {
        Container,
        UpdateUser,
        UpdatePassword,
        UpdateUserPhotos
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
