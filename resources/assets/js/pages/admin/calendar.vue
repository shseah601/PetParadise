
<template>
  <v-card>
    <v-card-title class="grey lighten-4">
      <v-flex xs9>
        <h3 class="headline mb-0">{{ $t('calendar') }}</h3>
      </v-flex>
      <v-flex xs3>
        <v-select v-model="type" :items="typeOptions" label="Type"></v-select>
      </v-flex>
    </v-card-title>
    <v-divider></v-divider>
    <v-card-text>
      <v-layout row wrap>
        <v-flex xs12>
          <div class="headline text-xs-center mb-2">{{ getMonthAndYear(selectedDate) }}</div>
        </v-flex>
        <v-flex xs12>
          <v-sheet :height="type == 'month' ? '500' : '600' ">
            <v-calendar
              v-model="selectedDate"
              :now="today"
              :start="today"
              :type="type"
              ref="calendar"
              color="primary"
            >
              <template v-if="type == 'month'" v-slot:day="{ date }">
                <template v-for="event in eventsMap[date]">
                  <v-menu :key="event.service.name" v-model="event.open" full-width offset-x>
                    <template v-slot:activator="{ on }">
                      <div
                        v-ripple
                        class="my-event"
                        v-on="on"
                        v-html="event.service.name"
                        :style="checkIfSmallerThanNow(event.end_time) ? 'background-color: #07ab4e;' : ''"
                      ></div>
                    </template>
                    <v-card color="grey lighten-4" max-width="350px" flat>
                      <v-toolbar
                        class="white--text"
                        :color="checkIfSmallerThanNow(event.end_time) ? '#07ab4e' : ''"
                      >
                        <v-toolbar-title v-html="event.service.name"></v-toolbar-title>
                      </v-toolbar>
                      <v-card-title primary-title>
                        <v-layout row wrap>
                          <v-flex xs6>
                            <div class="font-weight-bold">Client Name:</div>
                          </v-flex>
                          <v-flex xs6>
                            <div>{{event.client.name}}</div>
                          </v-flex>
                          <v-flex xs6>
                            <div class="font-weight-bold">Pet Name:</div>
                          </v-flex>
                          <v-flex xs6>
                            <div>{{event.pet.name}}</div>
                          </v-flex>
                          <v-flex xs6>
                            <div class="font-weight-bold">Employee Name:</div>
                          </v-flex>
                          <v-flex xs6>
                            <div>{{event.employee.name}}</div>
                          </v-flex>
                          <template v-if="event.service.id == 1">
                            <v-flex xs6>
                              <div class="font-weight-bold">Service Time:</div>
                            </v-flex>
                            <v-flex xs6>
                              <div>{{getTime(event.start_time)}}</div>
                            </v-flex>
                          </template>
                          <template v-if="event.service.id == 2">
                            <v-flex xs6>
                              <div class="font-weight-bold">Service Start Date:</div>
                            </v-flex>
                            <v-flex xs6>
                              <div>{{getDate(event.start_time)}}</div>
                            </v-flex>
                            <v-flex xs6>
                              <div class="font-weight-bold">Service End Date:</div>
                            </v-flex>
                            <v-flex xs6>
                              <div>{{getDate(event.end_time)}}</div>
                            </v-flex>
                          </template>
                        </v-layout>
                      </v-card-title>
                    </v-card>
                  </v-menu>
                </template>
              </template>
              <!-- the events at the top (all-day) -->
              <template v-if="type == 'week'" v-slot:dayHeader="{ date }">
                <template v-for="event in eventsMap[date]">
                  <!-- all day events don't have time -->
                  <v-menu :key="event.service.name" v-model="event.open" full-width offset-x>
                    <template v-slot:activator="{ on }">
                      <div
                        v-if="event.service.id == 2"
                        :key="event.service.name"
                        class="my-event"
                        v-on="on"
                        v-html="event.service.name"
                        :style="checkIfSmallerThanNow(event.end_time) ? 'background-color: #07ab4e;' : 'background-color: #07ab4e'"
                      ></div>
                    </template>
                    <v-card color="grey lighten-4" max-width="350px" flat>
                      <v-toolbar
                        class="white--text"
                        :color="checkIfSmallerThanNow(event.end_time) ? '#07ab4e' : ''"
                      >
                        <v-toolbar-title v-html="event.service.name"></v-toolbar-title>
                      </v-toolbar>
                      <v-card-title primary-title>
                        <v-layout row wrap>
                          <v-flex xs6>
                            <div class="font-weight-bold">Client Name:</div>
                          </v-flex>
                          <v-flex xs6>
                            <div>{{event.client.name}}</div>
                          </v-flex>
                          <v-flex xs6>
                            <div class="font-weight-bold">Pet Name:</div>
                          </v-flex>
                          <v-flex xs6>
                            <div>{{event.pet.name}}</div>
                          </v-flex>
                          <v-flex xs6>
                            <div class="font-weight-bold">Employee Name:</div>
                          </v-flex>
                          <v-flex xs6>
                            <div>{{event.employee.name}}</div>
                          </v-flex>
                          <template v-if="event.service.id == 1">
                            <v-flex xs6>
                              <div class="font-weight-bold">Service Time:</div>
                            </v-flex>
                            <v-flex xs6>
                              <div>{{getTime(event.start_time)}}</div>
                            </v-flex>
                          </template>
                          <template v-if="event.service.id == 2">
                            <v-flex xs6>
                              <div class="font-weight-bold">Service Start Date:</div>
                            </v-flex>
                            <v-flex xs6>
                              <div>{{getDate(event.start_time)}}</div>
                            </v-flex>
                            <v-flex xs6>
                              <div class="font-weight-bold">Service End Date:</div>
                            </v-flex>
                            <v-flex xs6>
                              <div>{{getDate(event.end_time)}}</div>
                            </v-flex>
                          </template>
                        </v-layout>
                      </v-card-title>
                    </v-card>
                  </v-menu>
                </template>
              </template>
              <!-- the events at the bottom (timed) -->
              <template v-if="type == 'week'" v-slot:dayBody="{ date, timeToY, minutesToPixels }">
                <template v-for="event in eventsMap[date]">
                  <v-menu :key="event.service.name" v-model="event.open" full-width offset-x>
                    <template v-slot:activator="{ on }">
                      <!-- timed events -->
                      <div
                        v-if="event.time"
                        :key="event.title"
                        :style=" checkIfSmallerThanNow(event.end_time) ? `top: ${timeToY(getTime(event.start_time))}px; height: ${minutesToPixels(getMinutesBetweenDates(event.start_time, event.end_time))}px; background-color: #07ab4e;` : { top: timeToY(getTime(event.time)) + 'px', height: minutesToPixels(getMinutesBetweenDates(event.start_time, event.end_time)) + 'px'}"
                        class="my-event with-time"
                        v-on="on"
                        v-html="event.title"
                      ></div>
                    </template>
                    <v-card color="grey lighten-4" max-width="350px" flat>
                      <v-toolbar
                        class="white--text"
                        :color="checkIfSmallerThanNow(event.end_time) ? '#07ab4e' : ''"
                      >
                        <v-toolbar-title v-html="event.service.name"></v-toolbar-title>
                      </v-toolbar>
                      <v-card-title primary-title>
                        <v-layout row wrap>
                          <v-flex xs6>
                            <div class="font-weight-bold">Client Name:</div>
                          </v-flex>
                          <v-flex xs6>
                            <div>{{event.client.name}}</div>
                          </v-flex>
                          <v-flex xs6>
                            <div class="font-weight-bold">Pet Name:</div>
                          </v-flex>
                          <v-flex xs6>
                            <div>{{event.pet.name}}</div>
                          </v-flex>
                          <v-flex xs6>
                            <div class="font-weight-bold">Employee Name:</div>
                          </v-flex>
                          <v-flex xs6>
                            <div>{{event.employee.name}}</div>
                          </v-flex>
                          <template v-if="event.service.id == 1">
                            <v-flex xs6>
                              <div class="font-weight-bold">Service Time:</div>
                            </v-flex>
                            <v-flex xs6>
                              <div>{{getTime(event.start_time)}}</div>
                            </v-flex>
                          </template>
                          <template v-if="event.service.id == 2">
                            <v-flex xs6>
                              <div class="font-weight-bold">Service Start Date:</div>
                            </v-flex>
                            <v-flex xs6>
                              <div>{{getDate(event.start_time)}}</div>
                            </v-flex>
                            <v-flex xs6>
                              <div class="font-weight-bold">Service End Date:</div>
                            </v-flex>
                            <v-flex xs6>
                              <div>{{getDate(event.end_time)}}</div>
                            </v-flex>
                          </template>
                        </v-layout>
                      </v-card-title>
                    </v-card>
                  </v-menu>
                </template>
              </template>
            </v-calendar>
          </v-sheet>
        </v-flex>
      </v-layout>
    </v-card-text>
    <v-card-actions>
      <v-btn color="primary" @click="$refs.calendar.prev()">
        <v-icon dark left>keyboard_arrow_left</v-icon>Prev
      </v-btn>
      <v-spacer></v-spacer>
      <v-btn class="white--text" color="teal" @click="selectedDate = today">Today</v-btn>
      <v-spacer></v-spacer>
      <v-btn color="primary" @click="$refs.calendar.next()">
        Next
        <v-icon right dark>keyboard_arrow_right</v-icon>
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'admin-calendar-view',
  data: () => ({
    type: 'month',
    today: new Date().toISOString().substr(0, 10),
    selectedDate: new Date().toISOString().substr(0, 10),
    typeOptions: [
      { text: 'Week', value: 'week' },
      { text: 'Month', value: 'month' }
    ],
    events: [
      {
        title: 'Weekly Meeting',
        date: '2019-08-07',
        time: '09:00',
        duration: 45
      },
      {
        title: 'Thomas\' Birthday',
        date: '2019-08-10'
      },
      {
        title: 'Mash Potatoes',
        date: '2019-08-09',
        time: '12:30',
        duration: 180
      }
    ],
    monthName: [
      'January',
      'February',
      'March',
      'April',
      'May',
      'June',
      'July',
      'August',
      'September',
      'October',
      'November',
      'December'
    ]
  }),
  computed: {
    ...mapGetters([
      'bookings'
    ]),
    // convert the list of events into a map of lists keyed by date
    eventsMap () {
      const map = {}
      this.bookings.forEach(e => (map[this.getDate(e.start_time)] = map[this.getDate(e.start_time)] || []).push(e))
      return map
    }
  },
  methods: {
    open (event) {
      alert(event.title)
    },
    getMonthAndYear (date) {
      const d = new Date(date)
      const year = d.getFullYear()
      const month = this.monthName[d.getMonth()]

      return `${month} ${year}`
    },
    getDate (date) {
      date = new Date(date)
      date = date.toISOString().substr(0, 10)
      return date
    },
    getTime (date) {
      const d = new Date(date).toTimeString()
      const [hour, min, sec] = d.split(':')
      sec
      return `${hour}:${min}:00`
    },
    checkIfSmallerThanNow (date) {
      const now = new Date()
      const diff = now - new Date(date)

      if (Math.sign(diff) === -1) {
        return false
      } else {
        return true
      }
    },
    getMinutesBetweenDates (startDate, endDate) {
      const diff = Math.abs(new Date(endDate) - new Date(startDate))
      const minutes = Math.floor((diff / 1000) / 60)
      return minutes
    }
  },
  metaInfo () {
    return { title: this.$t('calendar') }
  }
}
</script>

<style lang="stylus" scoped>
.my-event {
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  border-radius: 2px;
  background-color: #1867c0;
  color: #ffffff;
  border: 1px solid #1867c0;
  width: 100%;
  font-size: 12px;
  padding: 3px;
  cursor: pointer;
  margin-bottom: 1px;

  &.with-time {
    position: absolute;
    margin-right: 0px;
  }
}
</style>