<template>
    <div>
       <Container>
            <post :postData="post" :onPost = "true"/>
            <hr style = "width:75%">
            <h3 style = "margin: 0 auto;text-align:center">Comments</h3>
            <comment-list :comments = "comments.data" />
            <write-comment :postId = "post.id"/>
            <pagination :metaData="metaData" :pagesDisplayed="pagesDisplayed" :preserveScroll="true"/>
       </Container>
    </div>
    
</template>

<script>
import Container from './Templates/Container'
import Post from'./Templates/Post'
import Pagination from './Templates/Pagination'
import CommentList from './Templates/CommentList'
import WriteComment from './Templates/WriteComment'
import { BFormTextarea } from 'bootstrap-vue'

export default {
    props: {
        post: Object,
        comments: Object,
    },
    components: {
        Container,
        Post,
        Pagination,
        CommentList,
        BFormTextarea,
        WriteComment,
    },
    methods:{
        submitComment(){
            this.$inertia.post('/comments', {
                content: this.form.content,
                post: this.post.id,
            }).then(() => this.form.content = '') 
            
        }
    },

    data() {
        return {
            metaData: null,
            pagesDisplayed: 3,
            form: {
                content: ''
            }

        }
            
    },

    //Pass meta data w/o profiles to the pagination component
    created(){
        this.metaData = JSON.parse(JSON.stringify(this.$props.comments))
        delete this.metaData['data']
    }

}

</script>
