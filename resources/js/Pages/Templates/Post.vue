<template>
    <div>
       <!-- {{ postData.content }} -->
       <b-card>
            <inertia-link :href = "headerLink">
                <b-card-title :title="postData.name"/>
            </inertia-link>
            <button type="button" class="btn btn-outline-primary btn-sm"><i class="fa fa-user"></i> Follow</button>
            <!-- <button type="button" class="btn btn-primary btn-sm"><i class="fa fa-user"></i> Following</button> -->
            <b-card-text>
                {{postData.content}}
            </b-card-text>

            
            <b-link href="#" class="card-link">Another link</b-link>
        </b-card>
    </div>
    
</template>

<script>
import { BCard, BCardText, BLink, BCardTitle } from 'bootstrap-vue'


export default {


    props: {
        postData: Object
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
            headerLink: "profiles/"+this.postData.user_id,
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
