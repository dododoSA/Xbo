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

            <router-link class="mx-2" to="/signup">新規登録</router-link>
            <router-link to="/login">ログイン</router-link>
        </v-app-bar> 
    </div>
</template>

<script>
export default {
    name: "HeaderContent",
}
</script>

<style scoped>

</style>