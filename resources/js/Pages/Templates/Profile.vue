<template>
    <div :class = "profileClass">
        <b-card
            img-src="https://picsum.photos/600/300/?image=25"
            img-alt="Image"
            img-width="100%"
            img-height="200px"
            img-top
            tag="article"
            class="mb-2 text-center profile-card"
        >
            <b-card-img src="https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/0cc25e2e-d94d-42eb-a44c-a0dbb83598ae/d1x0kxu-81c4653a-fd15-441a-955f-0c9a36f3deea.png?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7InBhdGgiOiJcL2ZcLzBjYzI1ZTJlLWQ5NGQtNDJlYi1hNDRjLWEwZGJiODM1OThhZVwvZDF4MGt4dS04MWM0NjUzYS1mZDE1LTQ0MWEtOTU1Zi0wYzlhMzZmM2RlZWEucG5nIn1dXSwiYXVkIjpbInVybjpzZXJ2aWNlOmZpbGUuZG93bmxvYWQiXX0.VK8ToE-ytyT-5ZUqgX96j_iiUOt6cIFoTvQ_Xo7bJDg" alt="Image" bottom class ="user-photo rounded-circle"></b-card-img>
            <b-card-title :title="profileData.name"/>
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
