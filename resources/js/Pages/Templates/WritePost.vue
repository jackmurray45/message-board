<template>
    <div style = 'text-align:center'>
       <b-form-textarea
            id="textarea-no-resize"
            placeholder="write your post..."
            rows="3"
            no-resize
            style = "width:80%;margin:0 auto !important;margin-bottom:20px;"
            v-model="form.content"
        ></b-form-textarea>
        <button  type="button" class="btn btn-primary btn" style="margin-bottom:20px;"  @click="submitPost" :disabled="form.content.length ==0"  >Write Post</button>
    </div>
    
</template>

<script>
import { BFormTextarea } from 'bootstrap-vue'

export default {
    components: {
        BFormTextarea
    },
    methods:{
        submitPost(){
            this.$inertia.post('/posts', {
                content: this.form.content,
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
