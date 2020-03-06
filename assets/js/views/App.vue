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
    data: () => {
        return {
            commonLoad: false
        }
    },
    components: {
        'header-content': HeaderContent
    },
    created: async function() {
        await this.$store.dispatch('getMe');
    }
}
</script>

<style scoped>

</style>