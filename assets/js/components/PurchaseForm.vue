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
import PurchaseFields from './PurchaseFields';

export default {
    name: 'PurchaseForm',
    props: {
        date: String,
        default: ''
    },
    data() {
        return {
            purchases: [],
            defaultDate: {
                type: String,
                default: ''
            }
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
                purchases: [
                    {
                        name: this.purchaseName,
                        price: this.unitPrice,
                        purchased_at: String(this.purchaseDate)
                    }
                ]
            };

      
            axios.post('/api/household/' + _this.$store.state.householdId + '/purchase', reqData)
                .then(res => {
                    console.log(res);
                })
                .catch(err => {
                    console.log(err);
                });
        },
        addField: function() {
            const uid = this.generateUID();
            this.purchases.push({
                id: uid,
                name: '',
                unitPrice: 0,
                number: 0,
                date: this.defaultDate
            });
        },
        removeField: function(id) {
            for (let i = 0; i < this.purchases.length; ++i) {
                if (this.purchases[i].id === id) {
                    this.purchases.splice(i, 1);
                }
            }
        },
        generateUID: function() {
            let range = 1000;
            return new Date().getTime().toString(16) + Math.floor(range * Math.random()).toString(16);
        },
        //参照関連の知識がないのでこうしてるだけでもし関数化して参照できてるなら同じような処理してる部分を関数化したい
        onNameChange: function(value, id) {
            for(let i = 0; i < this.purchases.length; ++i) {
                if (this.purchases[i].id === id) {
                    this.purchases[i].name = value;
                }
            }
        },
        onPriceChange: function(value, id) {
            for(let i = 0; i < this.purchases.length; ++i) {
                if (this.purchases[i].id === id) {
                    this.purchases[i].unitPrice = value;
                }
            }
        },
        onNumberChange: function(value, id) {
            for(let i = 0; i < this.purchases.length; ++i) {
                if (this.purchases[i].id === id) {
                    this.purchases[i].number = value;
                }
            }
        },
        onDateChange: function(value, id) {
            for(let i = 0; i < this.purchases.length; ++i) {
                if (this.purchases[i].id === id) {
                    this.purchases[i].date = value;
                }
            }
        }
    },
    watch: {
        date: function(newDate, oldDate) {
            this.defaultDate = newDate;
        },

    },
    components: {
        'purchase-fields': PurchaseFields
    },
    created() {
        this.addField();
    }
};
</script>

<style scoped>

</style>