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
                    <v-menu
                        ref="showPicker"
                        :close-on-content-click="false"
                        v-model="showPicker"
                        transition="scale-transition"
                        offset-y
                        full-width
                        max-width="290px"
                        min-width="290px"
                    >
                        <template v-slot:activator="{ on }">
                            <v-text-field
                                label="購入日"
                                prepend-icon="mdi-calendar-month"
                                v-model="purchaseDate"
                                v-on="on"
                            ></v-text-field>
                        </template>
                        <v-date-picker
                            v-model="purchaseDate"
                            no-title
                            @input="showPicker = false"
                        ></v-date-picker>
                    </v-menu>
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
    data() {
        return {
            purchaseName: '',
            unitPrice: 0,
            purchaseNumber: 1,
            purchaseDate: this.date,
            showPicker: false
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
    },
    watch: {
        date: function(newDate, oldDate) {
            this.purchaseDate = newDate;
        }
    }
};
</script>

<style scoped>

</style>