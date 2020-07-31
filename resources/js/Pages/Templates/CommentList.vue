<template>
    <div>
        <div v-for="comment in comments" :key="comment.id"> 
            <comment :commentData="comment" />
        </div>
        
    </div>
</template>

<script>
import Comment from './Comment'


export default {
    props: {
        comments: Array,
    },
    components: {
        Comment,
    },
}

</script>