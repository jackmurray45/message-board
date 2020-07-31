<template>
    <div>
       <Container>
           <profile-list :profiles = "profiles.data" />
           <pagination :metaData="metaData" :pagesDisplayed="pagesDisplayed"/>
       </Container>
    </div>
    
</template>

<script>
import Container from './Templates/Container'
import ProfileList from './Templates/ProfileList'
import Pagination from './Templates/Pagination'


export default {
    props: {
        profiles: Object,
    },
    components: {
        Container,
        ProfileList,
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

<style>
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
