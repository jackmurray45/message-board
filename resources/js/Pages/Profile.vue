<template>
    <div>
       <Container>
           <profile :profileData="profile" :isFollowing="following" profileClass="profile-page"/>
       </Container>
    </div>
    
</template>

<script>
import Container from './Templates/Container'
import Profile from './Templates/Profile'


export default {
    props: {
        profile: Object,
        posts: Object,
        following: Boolean,
    },
    components: {
        Container,
        Profile

    },

    methods: {

    },

}

</script>

<style>
.profile-page{
    width:75% !important;
    margin: 0 auto !important;
}


</style>
