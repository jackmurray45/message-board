<template>
    <div>
       <Container>
           <profile :profileData="profile" :isFollowing="following" class="profile-page"/>

            <post-list :posts = "posts.data" />
            <pagination :metaData="metaData" :pagesDisplayed="pagesDisplayed" :preserveScroll="true"/>
       </Container>
    </div>
    
</template>

<script>
import Container from './Templates/Container'
import PostList from './Templates/PostList'
import Pagination from './Templates/Pagination'
import Profile from './Templates/Profile'


export default {
    props: {
        profile: Object,
        posts: Object,
        following: Boolean,
    },
    components: {
        Container,
        Profile,
        PostList,
        Pagination,
    },

    data() {
        return {
            metaData: null,
            pagesDisplayed: 3,

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
.profile-page{
    width:75% !important;
    margin: 0 auto !important;
}


</style>
