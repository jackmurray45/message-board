<template>
    <div>
       <Container>
            <Login :errors = "errors"/>
       </Container>
    </div>
    
</template>

<script>
import Container from './Templates/Container'
import Login from './Templates/Login'


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

        }
    },
    components: {
        Container,
        Login,
    }
}
</script>

<style>




</style>
