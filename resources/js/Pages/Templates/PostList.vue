<template>
    <div>
        <div v-for="post in posts" :key="post.id"> 
            <post :postData="post" />
        </div>
        
    </div>
</template>

<script>
import Post from './Post'


export default {
    props: {
        posts: Array,
    },
    components: {
        Post,
    },

    created(){
        
    }

}

</script>