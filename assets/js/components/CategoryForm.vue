<template>
    <div>
        <v-card>
            <v-card-title>
                <h1 class="display-1">項目の追加</h1>
            </v-card-title>
            <v-card-text>
                <v-form>
                    <div v-for="purchase in purchases" :key="purchase.id">
                        <purchase-fields 
                            :date="date" 
                            :purchase="purchase" 
                            @name-change="value => onNameChange(value, purchase.id)" 
                            @price-change="value => onPriceChange(value, purchase.id)"
                            @number-change="value => onNumberChange(value, purchase.id)"
                            @date-change="value => onDateChange(value, purchase.id)"
                        ></purchase-fields>
                        <v-btn text icon @click="removeField(purchase.id, $event)">
                            <v-icon>mdi-minus-circle-outline</v-icon>
                        </v-btn>
                    </div>
                    <v-btn text icon @click="addField">
                        <v-icon>mdi-plus-circle-outline</v-icon>
                    </v-btn>
                    <div class="display-1">合計: {{ totalPrice }}¥</div>
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