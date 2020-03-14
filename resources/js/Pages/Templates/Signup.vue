<template>
    <form @submit.prevent="submit">
        <div class="row">
            <div class="col-lg-12 form-group">
                <h2>Sign Up</h2>
            </div>
            <div class="col-lg-12 form-group">
                <i class="fa fa-user icon-left"></i>
                <input v-model="form.name" type="text" class = "login-input col-lg-12" value="" name="name" placeholder="Name" aria-required="true" />
                <span class="buttom-border"></span>
                <span class = 'error-message' v-if="errorsData != null && errorsData.name != null && errorsData.name.length > 0">{{errorsData.name[0]}}</span>
            </div>
            <div class="col-lg-12 form-group">
                <i class="fa fa-user icon-left"></i>
                <input v-model="form.email" type="email" class = "login-input col-lg-12" value="" name="email" placeholder="Email" aria-required="true" />
                <span class="buttom-border"></span>
                <span class = 'error-message' v-if="errorsData != null && errorsData.email != null && errorsData.email.length > 0">{{errorsData.email[0]}}</span>
            </div>
            <div class="col-lg-12 form-group">
                <i class="fa fa-lock icon-left"></i>
                <input v-model="form.password" type="password" class = "login-input col-lg-12" value="" name="password" placeholder="Password" aria-required="true" />
                <span class="buttom-border"></span>
                <span class = 'error-message' v-if="errorsData != null && errorsData.password != null &&  errorsData.password.length > 0">{{errorsData.password[0]}}</span>
            </div>
            <div class="col-lg-12 form-group">
                <i class="fa fa-lock icon-left"></i>
                <input v-model="form.password_confirmation" type="password" class = "login-input col-lg-12" value="" name="password-confirm" placeholder="Confirm Password" aria-required="true" />
                <span class="buttom-border"></span>
                <span class = 'error-message' v-if="errorsData != null && errorsData.password_confirmation != null && errorsData.password_confirmation.length > 0">{{errorsData.password_confirmation[0]}}</span>
            </div>
            <div class="col-lg-12 form-group group-buttons">
                <!-- <button type="button" class="btn btn-success btn-block">Create Account</button> -->

                <VueLoadingButton
                    class="btn btn-success btn-block bootstrap-btn-fix"
                    @click.native="signUpAttempt"
                    :loading="sending"
                    :styled="styled"
                    >Create Account
                </VueLoadingButton>
                
                <inertia-link href="/login" >
                    <button type="button" class="btn btn-primary btn-block" style="margin-top:8px;">Already a user? Login</button>
                </inertia-link>
            </div>
        </div>
    </form>
</template>

<script>
import VueLoadingButton from 'vue-loading-button';

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

        }
    },
    components: {
        VueLoadingButton,
    },
    methods: {
        validateSignIn(){
            this.readyForSubmit = false;
            this.errorsData = {
                email: [],
                password: [],
                name: [],
                password_confirmation: []
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

            if(this.form.password != this.form.password_confirmation){
                this.errorsData.password = ['The password field does not match the confirm password field.']
            }

            if(this.form.password.length < 8){
                this.errorsData.password = ['The password field is too short']
            }

            if(this.form.password_confirmation.length < 8 && this.errorsData.password.length == 0){
                this.errorsData.password_confirmation = ['The confirm password field is too short']
            }

            


            if(this.errorsData.name.length > 0 || 
            this.errorsData.email.length > 0 || 
            this.errorsData.password.length > 0 || 
            this.errorsData.password_confirmation.length > 0){
                this.readyForSubmit = false;
            }
            else{
                this.readyForSubmit = true;
            }
        },

        signUpAttempt(){

            this.validateSignIn()
            if(!this.readyForSubmit){
                return false;
            }

            this.sending = true
            this.$inertia.post('/register', {
                email: this.form.email,
                name: this.form.name,
                password: this.form.password,
                password_confirmation: this.form.password_confirmation,
                remember: this.form.remember,
            }).then(() => this.sending = false) 
        }
        
    },
    data() {
        return {
            readyForSubmit: false,
            sending: false,
            styled: false,
            form: {
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                remember: null,
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


