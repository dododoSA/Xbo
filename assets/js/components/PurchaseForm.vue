<template>
    <div>
        <v-card>
            <v-card-title>
                <h1 class="display-1">項目の追加</h1>
            </v-card-title>
            <v-card-text>
                <v-form>
                    <div v-for="purchase in purchases" :key="purchase.id">
                        <purchase-fields :date="date" :purchase="purchase" @name-change="value => onNameChange(value, purchaseWithUID.key)" ></purchase-fields>
                    </div>
                    <v-btn text icon @click="addField">
                        <v-icon>mdi-plus-box-outline</v-icon>
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
        generateUID: function() {
            let range = 1000;
            return new Date().getTime().toString(16) + Math.floor(range * Math.random()).toString(16);
        },
        onNameChange: function(value, index) {
            console.log(value);
            console.log(index);
            //this.purchases[index].name = value;
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