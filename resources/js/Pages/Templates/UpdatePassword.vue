<template>
    <form @submit.prevent="submit">
        <div class="row">
            <div class="col-lg-12 form-group">
                <h4>Update Password</h4>
            </div>
            <div class="col-lg-12 form-group">
                <span style="font-weight:bold">Old Password:</span>
                <input v-model="form.old_password" type="password" class = "login-input col-lg-12" aria-required="true" />
                <span class="buttom-border"></span>
                <span class = 'error-message' v-if="errorsData != null && errorsData.old_password != null && errorsData.old_password.length > 0">{{errorsData.old_password[0]}}</span>
            </div>
            <div class="col-lg-12 form-group">
                <span style="font-weight:bold">New Password:</span>
                <input v-model="form.password" type="password" class = "login-input col-lg-12" value="" name="password" aria-required="true" />
                <span class="buttom-border"></span>
                <span class = 'error-message' v-if="errorsData != null && errorsData.password != null && errorsData.password.length > 0">{{errorsData.password[0]}}</span>
            </div>

            <div class="col-lg-12 form-group">
                <span style="font-weight:bold">Confirm New Password:</span>
                <input v-model="form.password_confirmation" type="password" class = "login-input col-lg-12" value="" name="password_confirmation" aria-required="true" />
                <span class="buttom-border"></span>
                <span class = 'error-message' v-if="errorsData != null && errorsData.password_confirmation != null && errorsData.password_confirmation.length > 0">{{errorsData.password_confirmation[0]}}</span>
            </div>

            <div class="col-lg-12 form-group group-buttons">
                <!-- <button type="button" class="btn btn-success btn-block">Create Account</button> -->

                <VueLoadingButton
                    class="btn btn-success btn-block bootstrap-btn-fix"
                    @click.native="updatePassword"
                    :loading="sending"
                    :styled="styled"
                    >Update Password
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
                password: [],
                old_password: [],
                password_confirmation: [],
            }

        },
        user: Object
    },
    components: {
        VueLoadingButton,
    },
    methods: {
        validatePassword(){
            this.readyForSubmit = true;
            this.errorsData = {
                password: [],
                old_password: [],
                password_confirmation: []
            }

            if(this.form.password.length < 7){
                this.errorsData.password = ['Password is too short.'];
                this.readyForSubmit = false;
            }

            if(this.form.password != this.form.password_confirmation){
                this.errorsData.password = ['New password does not match password confirmation'];
                this.readyForSubmit = false;
            }

            console.log(this.errorsData.password);
        },

        updatePassword(){

            this.validatePassword()
            if(!this.readyForSubmit){
                return false;
            }
            this.sending = true
            this.$inertia.put(`/profiles/password`, {
                old_password: this.form.old_password,
                password: this.form.password,
                password_confirmation: this.form.password_confirmation,
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
                password: '',
                old_password: '',
                password_confirmation: ''
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


