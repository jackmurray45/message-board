<template>
    <div>
       <Container>
           <Login/>
       </Container>
    </div>
    
</template>

<script>
import Container from './Templates/Container'
import Login from './Templates/Login'


export default {
    props: ['posts', 'users'],
    components: {
        Container,
        Login,
    }
}
</script>

<style>




</style>
