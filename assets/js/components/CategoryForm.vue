<template>
    <div>
        <v-dialog v-model="categoryDialog">
            <template v-slot:activator="{ on }">
                <v-btn color="green lighten-1" dark v-on="on">
                    カテゴリの追加
                </v-btn>
            </template>
            <v-card>
                <v-card-title>
                    <h1 class="display-1">カテゴリの追加</h1>
                </v-card-title>
                <v-card-text>
                    <v-form>
                        <v-text-field label="カテゴリ名" v-model="categoryName"></v-text-field>
                        <v-card-actions>
                            <v-btn @click="createCategory">追加</v-btn>
                        </v-card-actions>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'CategoryForm',
    data: () => {
        return {
            categoryName: '',
            categoryDialog: false
        }
    },
    methods:{
        createCategory: function() {
            this.categoryDialog = false;
            if (this.categoryName === '') return;

            const _this = this;
            const householdId = this.$store.state.householdId;

            const reqData = {
                name: this.categoryName
            };

            axios.post('/api/household/' + householdId + '/category', reqData)
                .then(res => {
                    console.log(res);
                })
                .catch(err => {
                    console.log(err);
                });
            }
    }
}
</script>

<style scoped>

</style>