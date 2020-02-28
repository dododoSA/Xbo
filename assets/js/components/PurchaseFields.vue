<template>
    <div>
        <v-container>
            <v-row>
                <v-col>
                    <v-text-field label="項目名" :value="purchase.name" @change="value => onNameChange(value)" />
                </v-col>
                <v-col>
                    <v-text-field type="number" label="値段" :value="purchase.price" @change="value => onPriceChange(value)" />
                </v-col>
                <v-col>
                    <v-text-field type="number" label="個数" :value="purchase.number" @change="value => onNumberChange(value)" />
                </v-col>
                <v-col>
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
                                :value="dateValue"
                                v-on="on"
                                @change="value = onDateChange(value)"
                            ></v-text-field>
                        </template>
                        <v-date-picker
                            v-model="dateValue"
                            no-title
                            @input="showPicker = false"
                        ></v-date-picker>
                    </v-menu>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>

<script>
export default {
    name: 'PurchaseFields',
    props: {
        date: {
            type: String,
            default: ''
        },
        purchase: {
            type: Object,
            default: () => ({
                name: '',
                price: 0,
                number: 1,
                date: ''
            })
        }
    },
    data() {
        return {
            showPicker: false,
            dateValue: this.date
        }
    },
    methods: {
        onNameChange: function(value) {
            this.$emit('name-change', value);
        },
        onPriceChange: function(value) {
            this.$emit('price-hange', value);
        },
        onNumberChange: function(value) {
            this.$emit('number-hange', value);
        },
        onDateChange: function(value) {
            this.$emit('date-hange', value);
        }
    },
    watch: {
        date: function(newDate, oldDate) {
//            this.dateValue = newDate;
        }
    },
}
</script>

<style scoped>

</style>