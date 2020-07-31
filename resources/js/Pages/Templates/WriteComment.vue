<template>
    <div style = 'text-align:center'>
       <b-form-textarea
            id="textarea-no-resize"
            placeholder="write your comment..."
            rows="3"
            no-resize
            style = "width:80%;margin:0 auto !important;margin-bottom:20px;"
            v-model="form.content"
        ></b-form-textarea>
        <button  type="button" class="btn btn-primary btn" style="margin-bottom:20px;"  @click="submitComment" :disabled="form.content.length ==0"  >Post Comment</button>
    </div>
    
</template>

<script>
import { BFormTextarea } from 'bootstrap-vue'

export default {
    props: {
        postId: Number,
    },
    components: {
        BFormTextarea
    },
    methods:{
        submitComment(){
            this.$inertia.post('/comments', {
                content: this.form.content,
                post: this.post_id,
            }).then(() => this.form.content = '') 
            
        }
    },

    data() {
        return {
            form: {
                content: ''
            }
        }    
    },

}

</script>
