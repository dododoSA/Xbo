<template>
    <v-app>
        <header-content></header-content>
        <v-content>
            <v-container fluid>
                <router-view></router-view>
            </v-container>
        </v-content>
    </v-app>
</template>

<script>
import HeaderContent from '../components/HeaderContent'

export default {
    name: "App",
    components: {
        'header-content': HeaderContent
    },
    created: function() {
        this.$store.dispatch('getMe');
    }
}
</script>

<style scoped>

</style>