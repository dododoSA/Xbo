<script>
import { Pie, mixins } from 'vue-chartjs';

export default {
    extends: Pie,
    mixins: [mixins.reactiveProp],
    props: {
        chartdata: {
            type: Object,
            default: {}
        },
        options: {
            type: Object,
            default: {}
        }
    },
    mounted() {
        this.renderChart(this.chartdata, this.options);
    },
    watch: {
        chartdata: function(newValue, oldValue) {
            this._data._chart.destroy();//なぜかリアクティブにならないので強硬手段
            this.renderChart(newValue, this.options)
        }
    },
}
</script>

<style scoped>

</style>