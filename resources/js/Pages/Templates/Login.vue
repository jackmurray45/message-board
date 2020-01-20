<template>
    <form @submit.prevent="submit">
        <div class="row">
            
                <div class="col-lg-12 form-group">
                    <h2>Login</h2>
                </div>
                <div class="col-lg-12 form-group">
                    <i class="fa fa-user icon-left"></i>
                    <input v-model="form.email" class = "login-input col-lg-12"  placeholder="Email" type="email" autocapitalize="off" />
                    <span class="buttom-border"></span>
                </div>
                <div class="col-lg-12 form-group">
                    <i class="fa fa-lock icon-left"></i>
                    <input v-model="form.password" type="password" class = "login-input col-lg-12" name="password" placeholder="Password" aria-required="true" />
                    <span class="buttom-border"></span>
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
import Axios from 'axios'


export default {
    components: {
        VueLoadingButton,
        Axios,
    },
    methods: {
        loginAttempt(){
            this.sending = true
            // Axios.post('/login',{
            //     email: this.form.email,
            //     password: this.form.password,
            // })
            // .then(response => {console.log(response)})
            // .catch(e => {
            //     this.errors.push(e)
            // })

            this.$inertia.post('/login', {
                email: this.form.email,
                password: this.form.password,
                remember: this.form.remember,
            }).then(() => this.sending = false)
            

            
            
            
        }
    
    },
    data() {
        return {
            sending: false,
            styled: false,
            form: {
                email: '',
                password: '',
                remember: null
            }

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
    }

    .group-buttons{
        margin-top:15px;
    }
</style>


