<template>
    <div>
       <Container>
           
           <div v-for="profile in profiles.data" > 
               <Profile class = "profiles" :profileData="profile" :key="profiles.data.id" />
           </div>

           <pagination :metaData="metaData" :pagesDisplayed="pagesDisplayed"/>

        
       </Container>
    </div>
    
</template>

<script>
import Container from './Templates/Container'
import Profile from './Templates/Profile'
import Pagination from './Templates/Pagination'


export default {
    props: {
        profiles: Object,
    },
    components: {
        Container,
        Profile,
        Pagination,

    },

    methods: {

    },
    data() {
        return {
            metaData: null,
            pagesDisplayed:5

        }
            
    },

    //Pass meta data w/o profiles to the pagination component
    created(){
        this.metaData = JSON.parse(JSON.stringify(this.$props.profiles))
        delete this.metaData['data']
    }

    

}

</script>

<style scoped>
.profiles{
    width:75% !important;
    margin: 0 auto !important;
    margin-bottom: 50px !important;
}



</style>

<style>
.card-img-top{
    max-height: 150px !important;
}


</style>
