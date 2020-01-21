<template>
    <div>
        <b-dropdown :text=$page.auth.user.name>
            <b-dropdown-item class = "user-card-item">
                <inertia-link href="profile/me">
                    My Profile
                </inertia-link>
            </b-dropdown-item>
            <b-dropdown-item class = "user-card-item">
                <inertia-link href="logout">
                    Logout
                </inertia-link>
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
