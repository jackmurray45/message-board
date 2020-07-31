<template>
    <div>
        <b-dropdown :text=$page.auth.user.name>
            <b-dropdown-item class = "user-card-item">
                <inertia-link href="/profiles/me">
                    My Profile
                </inertia-link>
            </b-dropdown-item>
            <b-dropdown-item class = "user-card-item">
                <a href="logout" @click="submitLogout">
                    Logout
                </a>
            </b-dropdown-item>
        </b-dropdown>
    </div>
</template>

<script>
import { BDropdown, BDropdownItem } from 'bootstrap-vue'


export default {
    props: [],
    components: {
        BDropdown,
        BDropdownItem,

    },

    methods: {
        submitLogout(e){
            e.preventDefault
            console.log(1)
            this.$inertia.post('/logout', {
            }).then(() => null) 
        }

    },


}

</script>

<style scoped>
div{
    padding:5px;
}
</style>

<style>
.dropdown-menu{
    left:-15px !important;
}

.dropdown-menu a{
    color:#212529;
}

.dropdown-menu:focus{
    outline-style: none;
}
</style>
