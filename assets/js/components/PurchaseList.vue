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
                <v-list-item-content>
                    <v-btn color="error" @click="deletePurchase(purchase)">削除</v-btn>
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
            //この辺は絶対リファクタリングしたい
            const labels = ['なし'];
            console.log(purchases);
            purchases.forEach(purchase => {
                if (!labels.includes(purchase.category) && purchase.category != null) {
                    labels.push(purchase.category);
                }
            });
            const colors = labels.map((label) => "rgb(" + (~~(256 * Math.random())) + ", " + (~~(256 * Math.random())) + ", " + (~~(256 * Math.random())) + ")")
            const data = labels.map(label => 0);
            console.log(labels);
            purchases.forEach(purchase => {
                if (labels.includes(purchase.category)) {
                    const index = labels.indexOf(purchase.category);
                    data[index] += purchase.price;
                }
                else {
                    data[0] += purchase.price;
                }
            })

            return {
                labels: labels,
                datasets: [{
                    backgroundColor: colors,
                    data: data,
                }]
            };
        },
        deletePurchase: function(purchase) {
            const _this = this;
            const householdId = this.$store.state.householdId;
            if (householdId === -1) {
                return;
            }
            axios.delete('/api/household/' + householdId + '/purchase/' + purchase.id)
                .then(res => {
                    //リロードし直すかどうか問題、とりあえず今は同じものをこちらで削除している
                    const index = _this.purchases.findIndex(p => p.id === purchase.id);
                    _this.purchases.splice(index, 1);
                    _this.$set(_this.chartData , "data", _this.makeChartData(_this.purchases));
                    console.log(res);
                })
                .catch(err => {
                    console.log(err);
                });
        }
    },
    created: function() {
        const _this = this;
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