<template>
    <div>
        <v-card>
            <v-card-title>
                <h1 class="display-1">項目の追加</h1>
            </v-card-title>
            <v-card-text>
                <v-form>
                    <v-text-field label="項目名" v-model="purchaseName" />
                    <v-text-field type="number" label="値段" v-model="unitPrice" />
                    <v-text-field type="number" label="個数" v-model="purchaseNumber" />
                    <div class="display-1">合計: ¥{{ totalPrice }}</div>
                    <v-card-actions>
                        <v-btn>追加</v-btn>
                    </v-card-actions>
                </v-form>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'PurchaseForm',
    data: () => {
        return {
            purchaseName: '',
            unitPrice: 0,
            purchaseNumber: 1

        }
    },
    computed: {
        totalPrice: function() {
            return this.unitPrice * this.purchaseNumber;
        }
    },
    methods: {
        createPurchase: function() {
            const _this = this;

            const reqData = {
                name: purchaseName,
                price: unitPrice
            };

            

            axios.post('/household/1/purchase', reqData)
                .then(res => {
                    console.log(res);
                })
                .catch(err => {
                    console.log(err);
                });
        }
    }
};
</script>

<style scoped>

</style>