<template>
    <div>
        <v-card>
            <v-card-title>
                <h1 class="display-1">カテゴリの追加</h1>
            </v-card-title>
            <v-card-text>
                <v-form>
                    
                    <v-card-actions>
                        <v-btn @click="createPurchase">追加</v-btn>
                    </v-card-actions>
                </v-form>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
export default {
    name: 'CategoryForm',
    data: () => {
        return {

        }
    }
}
</script>

<style scoped>

</style>