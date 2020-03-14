<template>
    <div>
       <container>
            <post-list :posts = "posts.data" />
            <pagination :metaData="metaData" :pagesDisplayed="pagesDisplayed"/>
       </container>
    </div>
    
</template>

<script>
import Container from './Templates/Container'
import PostList from './Templates/PostList'
import Pagination from './Templates/Pagination'


export default {
    props: {
        posts: Object,
    },
    components: {
        Container,
        PostList,
        Pagination,

    },
    
    data() {
        return {
            metaData: null,
            pagesDisplayed: 5,

        }
            
    },

    //Pass meta data w/o profiles to the pagination component
    created(){
        this.metaData = JSON.parse(JSON.stringify(this.$props.posts))
        delete this.metaData['data']
    }


    

}

</script>

<style>




</style>
