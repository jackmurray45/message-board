<template>
    <div :class = "profileClass">
        <b-card
            :img-src="backgroundPhoto"
            img-alt="Image"
            img-width="100%"
            img-height="200px"
            img-top
            tag="article"
            class="mb-2 text-center profile-card"
        >
            <b-card-img :src="profilePhoto" alt="Image" bottom class ="user-photo rounded-circle"></b-card-img>
            <b-card-title :title="profileData.name" style = "margin-top:10px;"/>
            <!-- <button type="button" class="btn btn-primary btn-sm"><i class="fa fa-user"></i> Following</button> -->
            <b-card-text class = "text-center">
                {{profileData.bio}}
            </b-card-text>
        </b-card>
    </div>
    
</template>

<script>
import { BCard, BCardText, BLink, BCardTitle, BCardImg } from 'bootstrap-vue'


export default {
    props: {
        profileData: Object,
        isFollowing: Boolean,
        profileClass: String,
    },
    components: {
        BCard,
        BCardText,
        BLink,
        BCardTitle,
        BCardImg,
    
    },

    methods: {

    },
    data() {
        return {
            profilePhoto: this.$page.auth.user.profile_pic ? this.$page.auth.user.profile_pic : "/images/no-profile-pic.jpg",
            backgroundPhoto: this.$page.auth.user.background_pic ? this.$page.auth.user.background_pic : "/images/gray-background.jpg",

        }
            
    },

}

</script>

<style scoped>
</style>

<style>

.user-photo{
    width:100px;
    height: 100px;
}






</style>
