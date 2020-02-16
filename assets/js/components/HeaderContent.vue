<template>
    <div>
        <v-app-bar
            dark
            shrink-on-scroll
            prominent
        >
            <v-app-bar-nav-icon></v-app-bar-nav-icon>

            <v-toolbar-title><router-link to="/">ナビゲーションバー</router-link></v-toolbar-title>

            <v-spacer></v-spacer>

            <div v-if="isLoggedIn">
                <router-link class="mx-2" to="/household">マイページ</router-link>
                <a class="mx-2" href="/logout">ログアウト</a>
            </div>
            <div v-else>
                <router-link class="mx-2" to="/register">新規登録</router-link>
                <router-link class="mx-2" to="/login">ログイン</router-link>
            </div>
        </v-app-bar> 
    </div>
</template>

<script>
export default {
    name: "HeaderContent",
    computed: {
        isLoggedIn: function() {
            return this.$store.state.username !== '';
        }
    }
}
</script>

<style scoped>

</style>