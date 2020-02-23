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
                    <!-- <v-date-picker
                        locale="en-in"
                        v-model="purchaseDate"
                        no-title
                    ></v-date-picker> -->
                    <div class="display-1">合計: ¥{{ totalPrice }}</div>
                    <v-card-actions>
                        <v-btn @click="createPurchase">追加</v-btn>
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
    props: {
        date: String
    },
    data: () => {
        return {
            purchaseName: '',
            unitPrice: 0,
            purchaseNumber: 1,
            purchaseDate: ''
        }
    },
    computed: {
        totalPrice: function() {
            return this.unitPrice * this.purchaseNumber;
        },
        dateVal: function() {
            return this.purchaseDate;
        }
    },
    methods: {
        createPurchase: function() {
            const _this = this;

            const reqData = {
                name: this.purchaseName,
                price: this.unitPrice
            };

            

            axios.post('/api/household/' + _this.$store.state.householdId + '/purchase', reqData)
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