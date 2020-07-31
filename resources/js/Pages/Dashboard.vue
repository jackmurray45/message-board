<template>
    <div>
       <Container>
            <write-post class = 'dashboard-write-post' />
       </Container>
    </div>
    
</template>

<script>
import Container from './Templates/Container'
import WritePost from './Templates/WritePost'


export default {
    props: [],
    components: {
        Container,
        WritePost,

    },

    methods: {

    },

}

</script>

<style>
.dashboard-write-post{
    padding-top:100px;
    padding-bottom:100px;
}




</style>
