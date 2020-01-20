<template>
    <div class="row">
        <div class="col-lg-12 form-group">
            <h2>Sign Up</h2>
        </div>
        <div class="col-lg-12 form-group">
            <i class="fa fa-user icon-left"></i>
            <input type="text" class = "login-input col-lg-12" value="" name="user" placeholder="Username" aria-required="true" />
            <span class="buttom-border"></span>
        </div>
        <div class="col-lg-12 form-group">
            <i class="fa fa-lock icon-left"></i>
            <input type="password" class = "login-input col-lg-12" value="" name="password" placeholder="Password" aria-required="true" />
            <span class="buttom-border"></span>
        </div>
        <div class="col-lg-12 form-group">
            <i class="fa fa-lock icon-left"></i>
            <input type="password" class = "login-input col-lg-12" value="" name="confirm_password" placeholder="Confirm Password" aria-required="true" />
            <span class="buttom-border"></span>
        </div>
        <div class="col-lg-12 form-group group-buttons">
            <button type="button" class="btn btn-success btn-block">Create Account</button>
            
            <inertia-link href="/login" >
                <button type="button" class="btn btn-primary btn-block" style="margin-top:8px;">Already a user? Login</button>
            </inertia-link>
        </div>
    </div>
</template>

<script>


export default {
    components: {
        
    },
    methods: {
        


    },
    data() {
        return {

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
 
    input[type=text], input[type=password]{
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


