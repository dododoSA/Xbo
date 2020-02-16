<template>
    <div>
        <v-card>
            <v-list-item  v-for="purchase in purchases" v-bind:key="purchase.id" >
                <v-list-item-content>
                    {{ purchase.name }} : ¥{{ purchase.price }}
                </v-list-item-content>
            </v-list-item>
        </v-card>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'PurchaseList',
    data: () => {
        return {
            purchases: {}
        }
    },
    methods: {

    },
    created: function() {
        const _this = this
        const unwatch = this.$store.watch(
            state => state.householdId,
            householdId => {
                axios.get('/api/household/' + householdId + '/purchase')
                    .then(res => {
                        _this.purchases = res.data;
                    })
                    .catch(err => {
                        console.log(err);
                    })
            }
        )
    }
}
</script>

<style scoped>

</style>