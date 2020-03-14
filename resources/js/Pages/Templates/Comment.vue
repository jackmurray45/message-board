<template>
    <div>
       <!-- {{ postData.content }} -->
       <b-card>
            <inertia-link :href = "headerLink">
                <b-card-title :title="commentData.user.name"/>
            </inertia-link>
            <!-- <button type="button" class="btn btn-primary btn-sm"><i class="fa fa-user"></i> Following</button> -->
            <b-card-text>
                {{commentData.content}}
            </b-card-text>
        </b-card>
    </div>
    
</template>

<script>
import { BCard, BCardText, BLink, BCardTitle } from 'bootstrap-vue'


export default {


    props: {
        commentData: Object
    },
    components: {
        BCard,
        BCardText,
        BLink,
        BCardTitle,
    },

    methods: {

    },

    data(){
        return{
            headerLink: `/profiles/${this.commentData.user.id}`,
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
</style>
