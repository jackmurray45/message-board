<template>
    <div>
       <!-- {{ postData.content }} -->
       <b-card>
            <inertia-link :href = "headerLink">
                
                <b-card-title style = 'width:auto'>
                    <img :src = "profilePhoto" class = "user-photo rounded-circle"> 
                    {{postData.user.name}}
                </b-card-title>
            </inertia-link>
            <b-card-text>
                {{postData.content}}
            </b-card-text>

            <inertia-link :href = "postLink" v-if="!onPost">
                View Post
            </inertia-link>
        </b-card>
    </div>
    
</template>

<script>
import { BCard, BCardText, BLink, BCardTitle } from 'bootstrap-vue'

export default {


    props: {
        postData: Object,
        onPost: {
            type: Boolean,
            default: false,
        }
    },
    components: {
        BCard,
        BCardText,
        BLink,
        BCardTitle,
    },
    data(){
        return{
            headerLink: `/profiles/${this.postData.user.id}`,
            postLink: `/posts/${this.postData.id}`,
            isProfilePage: this.profilePage,
            profilePhoto: this.postData.user.profile_pic ? this.postData.user.profile_pic : "/images/no-profile-pic.jpg",
        }
    },

}

</script>

<style scoped>
div{
    padding:20px;
}
button{
    position: absolute;
    right:0;
    top:0;
    margin: 25px;
}

.user-photo
{
    width:50px;
    height:50px;
    margin-right:10px;
}

.hide-view-post{
    display:none;
}
</style>
