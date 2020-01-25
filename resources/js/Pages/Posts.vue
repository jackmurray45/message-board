<template>
    <div>
       <Container>
           
           <div v-for="post in posts.data"> 
               <post :postData="post"/>
           </div>

           <pagination/>

        
       </Container>
    </div>
    
</template>

<script>
import Container from './Templates/Container'
import Post from './Templates/Post'
import Pagination from './Templates/Pagination'


export default {
    props: {
        posts: Object,
    },
    components: {
        Container,
        Post,
        Pagination,

    },

    methods: {

    },

    

}

</script>

<style>




</style>
