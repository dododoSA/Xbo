<template>
    <div>
        <v-card width='400px' class="mx-auto mt-5">
            <v-card-title>
                <h1 class="display-1">ログイン</h1>
            </v-card-title>
            <v-card-text>
                <v-form>
                    <v-text-field prepend-icon="mdi-account-circle" label="ユーザ名" v-model="username" />
                    <v-text-field v-bind:type="fieldType" prepend-icon="mdi-lock" v-bind:append-icon="eyeIconName" label="パスワード" v-model="plainPassword" @click:append="switchShowPass" />
                    <v-card-actions>
                        <v-btn @click="login">ログイン</v-btn>
                    </v-card-actions>
                </v-form>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: 'LoginPage',
    data: () => {
        return {
            showPassword: false,
            fieldType: 'password',
            eyeIconName: 'mdi-eye-off',
            username: '',
            plainPassword: ''
        }
    },
    methods: {
        login: function() {
            const postData = {
                username: this.username,
                password: this.plainPassword,
            }
            const _this = this;

            axios.post('/api/login', postData)
                .then(res => {
                    _this.$store.state.username = res.data;
                    _this.$router.push('/household');
                    console.log(res);
                })
                .catch(err => {
                    console.log(err);
                });

        },

        switchShowPass: function() {
            this.showPassword = !this.showPassword;
            if (this.showPassword) {
                this.fieldType = 'text';
                this.eyeIconName = 'mdi-eye';
            }
            else {
                this.fieldType = 'password';
                this.eyeIconName = 'mdi-eye-off';
            }
        }
    },
};
</script>

<style scoped>

</style>