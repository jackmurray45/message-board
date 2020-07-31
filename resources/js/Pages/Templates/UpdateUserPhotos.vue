<template>

    <div class="row">
        <div class="col-lg-12 form-group">
            <h4>Update Photos</h4>
        </div>
        <div class="col-lg-12 text-center" style = "margin-bottom:25px;">
            <div style="font-weight:bold">Profile Photo:</div>
            <div>
                <img :src = "profilePhoto" class = "user-photo rounded-circle">
            </div>
            <input type="file" @change="changeProfilePhoto" class="btn btn-outline-success" ref = 'profilePhoto' style="margin-top:10px;" name = 'profilePhoto' value = 'Change Photo'>
            <div class = 'error-message' v-if="errorsData != null && errorsData.profile_photo != null && errorsData.profile_photo.length > 0">{{errorsData.profile_photo[0]}}</div>
        </div>
        <div class="col-lg-12 text-center banner-photo-group">
            <div style="font-weight:bold">Banner Photo:</div>
            <div>
                <img :src = "backgroundPhoto" class = "banner-photo">
            </div>
            <input type="file" class="btn btn-outline-success" @change="changeBannerPhoto" style="margin-top:10px;" name = 'bannerPhoto' value = 'Change Photo'>
            <div class = 'error-message' v-if="errorsData != null && errorsData.banner_photo != null && errorsData.banner_photo.length > 0">{{errorsData.banner_photo[0]}}</div>
        </div>
    </div>
</template>

<script>
import VueLoadingButton from 'vue-loading-button';
import { BFormTextarea, BRow, BCol} from 'bootstrap-vue';

export default {
    props: {
        errors : {
            Type: Object,
            default: {
                profile_photo: [],
                banner_photo: [],
            }

        },
        user: Object
    },
    components: {
        VueLoadingButton,
    },
    methods: {
        validatePhoto(photo, pic){
            this.readyForSubmit = true;
            // this.errorsData = {
            //     profile_photo: [],
            //     banner_photo: [],
            // }
            if (!photo.match(/.(jpg|jpeg|png)$/i)){
                if(pic === "profile_photo"){
                    this.errorsData = {
                        profile_photo: ['File is not an image'],
                        banner_photo: this.errorsData.banner_photo
                    };
                }
                else if(pic === "banner_photo"){
                    this.errorsData = {
                        banner_photo: ['File is not an image'],
                        profile_photo: this.errorsData.profile_photo
                    };
                } 

            }

        },

        changeProfilePhoto(event){
            this.validatePhoto(event.target.files[0].type, 'profile_photo')
            if(!this.readyForSubmit){
                return false;
            }
            
            let fileUpload = new FormData();
            fileUpload.append('photo', event.target.files[0]);
            fileUpload.append('pic_option', 'profile_pic');

            this.sending = true
            this.$inertia.post(`/profiles/${this.user.id}/update_photo`, fileUpload).then(() => {
                this.sending = false;
                this.errorsData = this.errors;
            }) 
        },

        changeBannerPhoto(event){
            this.validatePhoto(event.target.files[0].type, 'banner_pic')
            if(!this.readyForSubmit){
                return false;
            }
            
            let fileUpload = new FormData();
            fileUpload.append('photo', event.target.files[0]);
            fileUpload.append('pic_option', 'banner_pic');

            this.sending = true
            this.$inertia.post(`/profiles/${this.user.id}/update_photo`, fileUpload).then(() => {
                this.sending = false;
                this.errorsData = this.errors;
            }) 
        },
        
    },
    data() {
        return {
            errorsData: this.errors,
            profilePhoto: this.$props.user.profile_pic ? this.$props.user.profile_pic : "/images/no-profile-pic.jpg",
            backgroundPhoto: this.$props.user.banner_pic ? this.$props.user.banner_pic : "/images/gray-background.jpg",

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
        margin-bottom:10px;
    }

    .group-buttons{
        margin-top:15px;
    }
    .error-message{
        color:red;
    }

    .user-photo{
        width:100px;
        height:100px;
    }
    .banner-photo{
        height:200px;
    }

    .banner-photo-group{
        margin-bottom:25px;
    }
    
</style>


