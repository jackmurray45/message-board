<template>
    <div>
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
            <inertia-link :href="headerLink" >
                <b-card-title :title="profileData.name" style = "margin-top:10px;"/>
            </inertia-link>

            <div v-if="!isSelf">
                <button  type="button" v-if = "!isFollowing" class="btn btn-outline-primary btn-sm follow-btn"  @click="followerUser"  ><i class="fa fa-user"></i> Follow</button>
                <button  type="button" v-else class="btn btn-primary btn-sm follow-btn" @click="unFollowerUser" ><i class="fa fa-user"></i> Unfollow</button>
            </div>
            
            <!-- <button type="button" class="btn btn-primary btn-sm"><i class="fa fa-user"></i> Following</button> -->
            <b-card-text class = "text-center">
                {{profileData.bio}}
            </b-card-text>
        </b-card>
    </div>
    
</template>

<script>
import { BCard, BCardText, BLink, BCardTitle, BCardImg } from 'bootstrap-vue'
import axios from 'axios'


export default {
    props: {
        profileData: Object,
    },
    components: {
        BCard,
        BCardText,
        BLink,
        BCardTitle,
        BCardImg,
    },

    methods: {
        followerUser(){
            if(this.profileData.is_following == -1){
                window.location.href = 'login'
                return false
            }
            this.isFollowing = true; 
            axios.post(`/profiles?user=${this.profileData.id}`, {}).then(() => null)
        },
        unFollowerUser(){
            if(this.profileData.is_following == -1){
                window.location.href = 'login'
                return false
            }
            this.isFollowing = false; 
            axios.delete(`/profiles/${this.profileData.id}`, {}).then((response) => null)
        }
    },
    data() {
        return {
            profilePhoto: this.$props.profileData.profile_pic ? this.$props.profileData.profile_pic : "/images/no-profile-pic.jpg",
            backgroundPhoto: this.$props.profileData.background_pic ? this.$props.profileData.background_pic : "/images/gray-background.jpg",
            headerLink: `/profiles/${this.$props.profileData.id}`,
            isFollowing: this.profileData.is_following != -1 && this.profileData.is_following,
            isSelf: this.profileData.is_self

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

.follow-btn{
    margin-top:10px;
    margin-bottom:15px;
}

</style>
