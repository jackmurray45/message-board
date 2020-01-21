<template>
    <div>
       <Container>
           
           <div v-for="post in posts.data"> 
               <post :postData="post"/>

           </div>
       </Container>
    </div>
    
</template>

<script>
import Container from './Templates/Container'
import Post from './Templates/Post'


export default {
    props: {
        posts: Object,
    },
    components: {
        Container,
        Post,

    },

    methods: {
        

    },

    

}

</script>

<style>




</style>
