<template>
    <div>
        <v-card max-width="600px" class="mx-auto">
            <pie-chart v-if="loaded" :chartdata="chartData.data" :options="chartOptions"></pie-chart>
            <v-btn text icon color="green" @click="reload">
                <v-icon>mdi-cached</v-icon>
            </v-btn>
            <v-list-item  v-for="purchase in purchases" v-bind:key="purchase.id" >
                <v-list-item-content>
                    {{ purchase.name }} : ¥{{ purchase.price }}
                </v-list-item-content>
                <v-list-item-content>
                    個数: {{ purchase.number }}
                </v-list-item-content>
                <v-list-item-content>
                    購入日: {{ purchase.purchased_at }}
                </v-list-item-content>
            </v-list-item>
        </v-card>
    </div>
</template>

<script>
import axios from 'axios';
import PieChart from './PieChart';

export default {
    name: 'PurchaseList',
    data: () => {
        return {
            purchases: {},
            loaded: false,
            chartData: [],
            chartOptions: {
                title: {
                    display: true,
                    text: 'グラフ'
                }
            }
        }
    },
    methods: {
        reload: function() {
            const _this = this;
            const householdId = this.$store.state.householdId;
            axios.get('/api/household/' + householdId + '/purchase')
                .then(res => {
                        _this.$set(_this.chartData , "data", _this.makeChartData(res.data));
                        _this.purchases = res.data;
                        _this.loaded = true;
                    })
                    .catch(err => {
                        console.log(err);
                        if (err.response.status === 401) {
                            _this.$router.push('/login');
                        }
                    })
        },
        makeChartData: function(purchases) {
            const labels = purchases.map(purchase => purchase.name);
            const colors = purchases.map((purchase) => "rgb(" + (~~(256 * Math.random())) + ", " + (~~(256 * Math.random())) + ", " + (~~(256 * Math.random())) + ")")
            const data = purchases.map(purchase => purchase.price);

            return {
                labels: labels,
                datasets: [{
                    backgroundColor: colors,
                    data: data,
                }]
            };
        }
    },
    created: function() {
        const _this = this
        const unwatch = this.$store.watch(
            state => state.householdId,
            householdId => {
                axios.get('/api/household/' + householdId + '/purchase')
                    .then(res => {
                        _this.$set(_this.chartData , "data", _this.makeChartData(res.data));
                        _this.purchases = res.data;
                        _this.loaded = true;
                    })
                    .catch(err => {
                        console.log(err);
                    })
            }
        )
        axios.get('/api/household/' + _this.$store.state.householdId + '/purchase')
                    .then(res => {
                        _this.$set(_this.chartData , "data", _this.makeChartData(res.data));
                        _this.purchases = res.data;
                        _this.loaded = true;
                    })
                    .catch(err => {
                        console.log(err);
                    })
    },
    components: {
        'pie-chart': PieChart
    }
}
</script>

<style scoped>

</style>