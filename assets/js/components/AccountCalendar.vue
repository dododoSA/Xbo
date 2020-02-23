<template>
    <v-card>
      <v-sheet height="64">
        <v-toolbar flat color="white">
          <v-btn outlined class="mr-4" color="grey darken-2" @click="setToday">
            Today
          </v-btn>
          <v-btn fab text small color="grey daken-2" @click="prev">
              <v-icon small>mdi-chevron-left</v-icon>
          </v-btn>
          <v-btn fab text small color="grey darken-2" @click="next">
            <v-icon small>mdi-chevron-right</v-icon>
          </v-btn>
          <v-toolbar-title>{{ title }}</v-toolbar-title>
          <v-spacer></v-spacer>
          
        </v-toolbar>
      </v-sheet>
      <v-sheet height="600">
        <v-calendar
          ref="calendar"
          v-model="focus"
          color="primary"
          :events="events"
          :event-color="getEventColor"
          :now="today"
          :type="type"
          @click:date="showPurchaseForm"
          @change="updateRange"
        ></v-calendar>
        <v-dialog v-model="showDialog">
          <purchase-form 
            :date="selectedDate"
          ></purchase-form>
        </v-dialog>
      </v-sheet>
    </v-card>
</template>

<script>
import PurchaseForm from './PurchaseForm'

export default {
    name: 'AccountCalendar',
    props: {
      purchases: Array
    },
    data() {
        return {
            focus: '',//今日
            type: 'month',//カレンダーの種類
            showDialog: false,
            start: null,
            end: null,
            selectedEvent: {},
            selectedElement: null,
            selectedDate: null,
            selectedOpen: false,
            events: [],
            colors: ['blue', 'indigo', 'deep-purple', 'cyan', 'green', 'orange', 'grey darken-1'],
            names: ['Meeting', 'Holiday', 'PTO', 'Travel', 'Event', 'Birthday', 'Conference', 'Party'],
        }
    },
    computed: {
      title () {
        const { start, end } = this
        if (!start || !end) {
          return ''
        }

        const startMonth = this.monthFormatter(start)
        const endMonth = this.monthFormatter(end)
        const suffixMonth = startMonth === endMonth ? '' : endMonth

        const startYear = start.year
        const endYear = end.year
        const suffixYear = startYear === endYear ? '' : endYear

        const startDay = start.day + this.nth(start.day)
        const endDay = end.day + this.nth(end.day)

        if (this.type === 'month') {
            return `${startMonth} ${startYear}`
        }
        return ''
      },
      monthFormatter () {
        return this.$refs.calendar.getFormatter({
          timeZone: 'UTC', month: 'long',
        })
      },
    },
    mounted () {
      this.$refs.calendar.checkChange()
    },
    methods: {
      getEventColor (event) {
        return event.color
      },
      setToday () {
        this.focus = this.today
      },
      prev () {
        this.$refs.calendar.prev()
      },
      next () {
        this.$refs.calendar.next()
      },
      // showEvent ({ nativeEvent, event }) {
      //   const open = () => {
      //     this.selectedEvent = event
      //     this.selectedElement = nativeEvent.target
      //     setTimeout(() => this.selectedOpen = true, 10)
      //   }

      //   if (this.selectedOpen) {
      //     this.selectedOpen = false
      //     setTimeout(open, 10)
      //   } else {
      //     open()
      //   }

      //   nativeEvent.stopPropagation()
      // },
      showPurchaseForm(date) {
          this.selectedDate = date.date;
          this.showDialog = true;
      },
      updateRange ({ start, end }) {
        this.start = start
        this.end = end
      },
      nth (d) {
        return d > 3 && d < 21
          ? 'th'
          : ['th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'][d % 10]
      },
      formatDate (a, withTime) {
        return withTime
          ? `${a.getFullYear()}-${a.getMonth() + 1}-${a.getDate()} ${a.getHours()}:${a.getMinutes()}`
          : `${a.getFullYear()}-${a.getMonth() + 1}-${a.getDate()}`
      },
    },
    components: {
      'purchase-form': PurchaseForm
    }
}
</script>

<style scoped>

</style>