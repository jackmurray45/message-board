<template>
    <div>
       <Container>
           <Signup :errors="errors"/>
       </Container>
    </div>
    
</template>

<script>
import Container from './Templates/Container'
import Signup from './Templates/Signup'


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
        Signup,
    },
}
</script>

<style>




</style>
