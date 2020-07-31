<template>
    <form @submit.prevent="submit">
        <div class="row">

                
                <div class="col-lg-12 form-group">
                    <h2>Login</h2>
                </div>
                <div  v-if="errors.length > 0" class = 'error-message'>
                    {{errors[0]}}
                </div>
                <div class="col-lg-12 form-group">
                    <i class="fa fa-user icon-left"></i>
                    <input v-model="form.email" class = "login-input col-lg-12"  placeholder="Email" type="email" autocapitalize="off" />
                    <span class="buttom-border"></span>
                    <span class = 'error-message' v-if="errorsData != null && errorsData.email != null && errorsData.email.length > 0">{{errorsData.email[0]}}</span>
                </div>
                <div class="col-lg-12 form-group">
                    <i class="fa fa-lock icon-left"></i>
                    <input v-model="form.password" type="password" class = "login-input col-lg-12" name="password" placeholder="Password" aria-required="true" />
                    <span class="buttom-border"></span>
                    <span class = 'error-message' v-if="errorsData != null && errorsData.password != null &&  errorsData.password.length > 0">{{errorsData.password[0]}}</span>
                </div>
                <div class="col-lg-12 form-group group-buttons">
                    <VueLoadingButton
                        class="btn btn-success bootstrap-btn-fix"
                        @click.native="loginAttempt"
                        :loading="sending"
                        :styled="styled"
                        >Login
                    </VueLoadingButton>
                    <inertia-link href="/register" >
                        <button type="button" class="btn btn-primary">Sign Up</button>
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
        validateLogIn(){
            this.readyForSubmit = false;
            this.errorsData = {
                email: [],
                password: [],
            }

            if(  !(/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.form.email))  ){
                this.errorsData.email = ['Invalid email.']
            }

            if(this.form.email.length == 0){
                this.errorsData.email = ['The email field is required.']
            }

            if(this.form.password.length < 8){
                this.errorsData.password = ['The password field is too short']
            }

            if( 
            this.errorsData.email.length > 0 || 
            this.errorsData.password.length > 0){
                this.readyForSubmit = false;
            }
            else{
                this.readyForSubmit = true;
            }
        },
        loginAttempt(){
            this.validateLogIn()
            if(!this.readyForSubmit){
                return false;
            }            
            this.sending = true
            this.$inertia.post('/login', {
                email: this.form.email,
                password: this.form.password,
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
                email: '',
                password: '',
                remember: null
            },
            errorsData: this.errors,

        }
            
    },

    

}
</script>

<style scoped>
    .row{
        margin: 0 auto;
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
        height:65px;
    }

    .group-buttons{
        margin-top:15px;
    }

    .error-message{
        color:red;
    }
    
</style>


