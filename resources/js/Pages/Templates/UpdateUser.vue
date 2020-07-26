<template>
    <form @submit.prevent="submit">
        <div class="row">
            <div class="col-lg-12 form-group">
                <h2>Update Profile</h2>
            </div>
            <div class="col-lg-12 form-group">
                <span style="font-weight:bold">Name:</span>
                <input v-model="form.name" type="text" class = "login-input col-lg-12" value="" name="name" placeholder="Name" aria-required="true" />
                <span class="buttom-border"></span>
                <span class = 'error-message' v-if="errorsData != null && errorsData.name != null && errorsData.name.length > 0">{{errorsData.name[0]}}</span>
            </div>
            <div class="col-lg-12 form-group">
                <span style="font-weight:bold">Email:</span>
                <input v-model="form.email" type="email" class = "login-input col-lg-12" value="" name="email" placeholder="Email" aria-required="true" />
                <span class="buttom-border"></span>
                <span class = 'error-message' v-if="errorsData != null && errorsData.email != null && errorsData.email.length > 0">{{errorsData.email[0]}}</span>
            </div>

            <div class="col-lg-12 form-group">
                <span style="font-weight:bold">Bio:</span>
                <textarea v-model="form.bio" class = "col-lg-12" value="" name="bio" aria-required="true">
                </textarea>
                <span class="buttom-border"></span>
            </div>

            <div class="col-lg-12 form-group group-buttons">
                <!-- <button type="button" class="btn btn-success btn-block">Create Account</button> -->

                <VueLoadingButton
                    class="btn btn-success btn-block bootstrap-btn-fix"
                    @click.native="updateUser"
                    :loading="sending"
                    :styled="styled"
                    >Update Info
                </VueLoadingButton>
            </div>
        </div>
    </form>
</template>

<script>
import VueLoadingButton from 'vue-loading-button';
import { BFormTextarea, BRow, BCol} from 'bootstrap-vue';

export default {
    props: {
        errors : {
            Type: Object,
            default: {
                email: [],
                password: [],
                name: [],
                password_confirmation: [],
            }

        },
        user: Object
    },
    components: {
        VueLoadingButton,
    },
    methods: {
        validateUser(){
            this.readyForSubmit = false;
            this.errorsData = {
                email: [],
                name: [],
                bio: []
            }

            if(  !(/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.form.email))  ){
                this.errorsData.email = ['Invalid email.']
            }

            if(this.form.email.length == 0){
                this.errorsData.email = ['The email field is required.']
            }

            if(this.form.name.length == 0){
                this.errorsData.name = ['The name field is required.']
            }

            if(this.errorsData.name.length > 0 || 
            this.errorsData.email.length > 0){
                this.readyForSubmit = false;
            }
            else{
                this.readyForSubmit = true;
            }
        },

        updateUser(){

            this.validateUser()
            if(!this.readyForSubmit){
                return false;
            }

            this.sending = true
            this.$inertia.put(`/profiles/${this.user.id}`, {
                email: this.form.email,
                name: this.form.name,
                bio: this.form.bio,
            }).then(() => {
                this.sending = false;
                this.errorsData = this.errors;
            }) 
        }
        
    },
    data() {
        return {
            readyForSubmit: false,
            sending: false,
            styled: false,
            form: {
                name: this.user.name,
                email: this.user.email,
                bio: this.user.bio
            },
            errorsData: this.errors

        }
            
    },

    

}
</script>

<style scoped>
    .row{
        margin: 0 auto;
    }

    .form-group{
        height:65px;
    }

    .icon-left{
        position: relative;
        z-index: 1;
        left: 0px;
        top: 23px;
        color: black;
        cursor: pointer;
        width: 0;
    }
 
    input[type=text], input[type=password], input[type=email]{
        outline: 0;
        border-width: 0 0 2px;
        border-color: black !important;
        padding-left:22.5px;
    }

    .login-input + .buttom-border {
        display:block;
        border-top: solid 2px #019fb6;
        width: 0%;
        -webkit-transition: width 250ms ease-in-out;
        transition: width 250ms ease-in-out;
    }

    .login-input:focus + .buttom-border {
        width: 100%;          /*  used calc first, but won't work on Edge  */
        -webkit-transition: width 250ms ease-in-out;
        transition: width 250ms ease-in-out;
    }

    .buttom-border{
        position: absolute !important;
        top:48px;
        
    }

    .form-group{
        padding-left:0px !important;
        padding-right:0px !important;
    }

    .row{
        padding: 15px;
    }

    .form-group{
        margin-bottom:0px;
    }

    .group-buttons{
        margin-top:15px;
    }
    .error-message{
        color:red;
    }
    
</style>


