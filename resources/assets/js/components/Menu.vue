<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <router-link :to="{name: 'home'}" class="navbar-brand">Address Finder</router-link>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="navbar-nav ml-auto">
                    <router-link :to="{name: 'home'}"class="nav-link">Home</router-link>
                </li>
                <li class="navbar-nav ml-auto">
                    <router-link :to="{name: 'upload'}"class="nav-link">Upload</router-link>
                </li>
            </ul>
        </div>
    </nav>
</template>
<script>
    export default {
        data() {
            return {

            }
        },
        methods: {


        },
        mounted() {

        }
    }
</script>
<style>
    .navbar {
        margin-bottom: 30px;
    }
</style>