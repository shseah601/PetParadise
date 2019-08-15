<template>
  <v-container grid-list-md text-center>
    <v-layout wrap>
      <v-flex xs12>
        <v-card>
          <progress-bar :show="busy"></progress-bar>
          <v-card-title primary-title>
            <div class="display-3">{{ $t('app_name') }}</div>
          </v-card-title>
          <v-card-text>
            <v-stepper v-model="step">
              <v-stepper-header>
                <v-stepper-step :complete="step > 1" step="1">
                  <v-btn :disabled="busy" @click="step = 1" flat>Choose a service</v-btn>
                </v-stepper-step>

                <v-divider></v-divider>

                <v-stepper-step :complete="step > 2" step="2">
                  <v-btn :disabled="step < 2 || busy" @click="step = 2" flat>Choose a time</v-btn>
                </v-stepper-step>

                <v-divider></v-divider>

                <v-stepper-step :complete="step > 3" step="3">
                  <v-btn :disabled="step < 3 || busy" @click="step = 3" flat>Select your pet</v-btn>
                </v-stepper-step>
                <v-divider></v-divider>

                <v-stepper-step step="4">
                  <v-btn :disabled="step < 4 || busy" @click="step = 4" flat>Booking Confirmation</v-btn>
                </v-stepper-step>
              </v-stepper-header>
              <v-stepper-items>
                <v-stepper-content step="1">
                  <v-card flat>
                    <v-layout wrap>
                      <v-flex d-flex xs12 sm6 md4 v-for="(item, i) in services" :key="i">
                        <v-card>
                          <v-card-title class="headline" v-text="item.name"></v-card-title>
                          <v-card-text>
                            <v-layout row wrap>
                              <v-flex xs12>
                                <v-img
                                  :src="item.image"
                                  aspect-ratio="1"
                                  max-width="500"
                                  max-height="200"
                                  contain
                                ></v-img>
                              </v-flex>
                              <v-flex xs12>
                                <v-divider></v-divider>
                                <div class="mt-3">Price: RM {{item.price_min}} - {{item.price_max}}</div>
                              </v-flex>
                              <v-flex xs12>
                                <div>Description:</div>
                              </v-flex>
                              <v-flex xs12>
                                <div>{{truncate(item.description)}}</div>
                              </v-flex>
                            </v-layout>
                          </v-card-text>
                          <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="primary" @click="selectService(item)">Book</v-btn>
                          </v-card-actions>
                        </v-card>
                      </v-flex>
                    </v-layout>
                  </v-card>
                </v-stepper-content>

                <v-stepper-content step="2">
                  <v-card flat>
                    <v-container grid-list-md text-center>
                      <v-layout wrap>
                        <v-flex xs12 sm12 md3>
                          <v-flex>
                            <v-card v-if="selectedService" class>
                              <v-card-title class="headline" v-text="selectedService.name"></v-card-title>
                              <v-card-text>
                                <v-layout row wrap>
                                  <v-flex xs12>
                                    <v-img
                                      :src="selectedService.image"
                                      aspect-ratio="1"
                                      max-width="500"
                                      max-height="200"
                                      contain
                                    ></v-img>
                                  </v-flex>
                                  <v-flex xs12>
                                    <v-divider></v-divider>
                                    <div
                                      class="mt-3"
                                    >Price: RM {{selectedService.price_min}} - {{selectedService.price_max}}</div>
                                  </v-flex>
                                </v-layout>
                              </v-card-text>
                            </v-card>
                          </v-flex>
                        </v-flex>
                        <v-flex d-flex xs12 sm12 md9>
                          <v-card>
                            <v-card-title>
                              <v-layout row>
                                <v-calendar
                                  v-model="selectedDate"
                                  :now="today"
                                  :start="today"
                                  type="week"
                                  ref="calendar"
                                  v-show="false"
                                ></v-calendar>
                                <v-flex xs3>
                                  <v-layout align-center justify-start row fill-height>
                                    <v-btn @click="calendarPrev">
                                      <v-icon>navigate_before</v-icon>Prev Week
                                    </v-btn>
                                  </v-layout>
                                </v-flex>
                                <v-flex>
                                  <v-layout row wrap>
                                    <v-flex xs12>
                                      <div
                                        class="headline text-xs-center"
                                      >{{ currentViewWeekString }}</div>
                                    </v-flex>
                                    <v-flex xs12 class="text-xs-center">
                                      <v-btn color="primary" small @click="calendarToday">Today</v-btn>
                                    </v-flex>
                                  </v-layout>
                                </v-flex>
                                <v-flex xs3>
                                  <v-layout align-center justify-end row fill-height>
                                    <v-btn @click="calendarNext">
                                      Next Week
                                      <v-icon>navigate_next</v-icon>
                                    </v-btn>
                                  </v-layout>
                                </v-flex>
                              </v-layout>
                            </v-card-title>
                            <v-divider></v-divider>
                            <v-card-text>
                              <div class="font-weight-bold mb-3">Select a time below</div>
                              <template v-for="day in currentViewWeek">
                                <v-card :key="day.name" flat>
                                  <v-card-title>{{day.date + ' - ' + day.name}}</v-card-title>
                                  <v-card-text>
                                    <template
                                      v-if="day.status == 1 && (day.availableTime.length !== 0)"
                                    >
                                      <template v-for="session in day.availableTime">
                                        <v-btn
                                          v-if="session.available"
                                          :key="session.time"
                                          @click="selectTime(session.time)"
                                        >{{ getTimeWithoutSeconds(session.time) }}</v-btn>
                                      </template>
                                    </template>
                                    <template v-else>
                                      <div>N/A</div>
                                    </template>
                                  </v-card-text>
                                </v-card>
                              </template>
                            </v-card-text>
                            <v-card-actions>
                              <v-layout row>
                                <v-flex xs3>
                                  <v-layout align-center justify-start row fill-height>
                                    <v-btn @click="calendarPrev">
                                      <v-icon>navigate_before</v-icon>Prev Week
                                    </v-btn>
                                  </v-layout>
                                </v-flex>
                                <v-flex>
                                  <v-layout row wrap>
                                    <v-flex xs12>
                                      <div
                                        class="headline text-xs-center"
                                      >{{ currentViewWeekString }}</div>
                                    </v-flex>
                                    <v-flex xs12 class="text-xs-center">
                                      <v-btn color="primary" small @click="calendarToday">Today</v-btn>
                                    </v-flex>
                                  </v-layout>
                                </v-flex>
                                <v-flex xs3>
                                  <v-layout align-center justify-end row fill-height>
                                    <v-btn @click="calendarNext">
                                      Next Week
                                      <v-icon>navigate_next</v-icon>
                                    </v-btn>
                                  </v-layout>
                                </v-flex>
                              </v-layout>
                            </v-card-actions>
                          </v-card>
                        </v-flex>
                      </v-layout>
                    </v-container>
                  </v-card>
                  <v-spacer></v-spacer>
                  <v-layout row wrap>
                    <v-spacer></v-spacer>
                    <v-btn @click="prevStep" flat>Back</v-btn>
                    <v-btn
                      class="white--text"
                      color="red darken-3"
                      :to="{ name: 'client.home' }"
                    >Cancel</v-btn>
                  </v-layout>
                </v-stepper-content>

                <v-stepper-content step="3">
                  <v-card flat>
                    <v-layout wrap>
                      <v-flex d-flex xs12 sm6 md4 v-for="(item, i) in client.pets" :key="i">
                        <v-card>
                          <v-card-title
                            class="headline white--text light-blue darken-4"
                            v-text="item.name"
                          ></v-card-title>
                          <v-card-text>
                            <v-layout row wrap>
                              <v-flex xs6>
                                <div>Type:</div>
                              </v-flex>
                              <v-flex xs6>
                                <div>{{ item.type }}</div>
                              </v-flex>
                              <v-flex xs6>
                                <div>Gender:</div>
                              </v-flex>
                              <v-flex xs6>
                                <div>{{ item.gender }}</div>
                              </v-flex>
                              <v-flex xs6>
                                <div>Age:</div>
                              </v-flex>
                              <v-flex xs6>
                                <div>{{ item.age }}</div>
                              </v-flex>
                            </v-layout>
                          </v-card-text>
                          <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="primary" @click="selectPet(item)">Select</v-btn>
                          </v-card-actions>
                        </v-card>
                      </v-flex>
                    </v-layout>
                  </v-card>
                  <v-layout row wrap>
                    <v-spacer></v-spacer>
                    <v-btn @click="prevStep" flat>Back</v-btn>
                    <v-btn
                      class="white--text"
                      color="red darken-3"
                      :to="{ name: 'client.home' }"
                    >Cancel</v-btn>
                  </v-layout>
                </v-stepper-content>

                <v-stepper-content step="4">
                  <v-card flat>
                    <v-layout align-center justify-center fill-height>
                      <v-card max-width="350">
                        <v-card-title class="headline">Booking Confirmation</v-card-title>
                        <v-card-text>
                          <v-layout row wrap>
                            <v-flex xs6>
                              <div class="font-weight-bold">Selected Service:</div>
                            </v-flex>
                            <v-flex xs6>
                              <div>{{selectedService.name}}</div>
                            </v-flex>
                            <v-flex xs6>
                              <div class="font-weight-bold">Selected Service Price Range:</div>
                            </v-flex>
                            <v-flex xs6>
                              <div>RM {{selectedService.price_min}} - {{selectedService.price_max}}</div>
                            </v-flex>
                            <v-flex xs6>
                              <div class="font-weight-bold">Selected Time:</div>
                            </v-flex>
                            <v-flex xs6>
                              <div>{{selectedTime}}</div>
                            </v-flex>
                            <v-flex xs6>
                              <div class="font-weight-bold">Selected Pet:</div>
                            </v-flex>
                            <v-flex xs6>
                              <div>{{selectedPet.name}}</div>
                            </v-flex>
                          </v-layout>
                        </v-card-text>
                      </v-card>
                    </v-layout>
                  </v-card>
                  <v-layout row wrap>
                    <v-spacer></v-spacer>
                    <v-btn
                      class="white--text"
                      color="red darken-3"
                      :disabled="busy"
                      :to="{ name: 'client.home' }"
                    >Cancel</v-btn>
                    <v-btn color="primary" :disabled="busy" :loading="busy" @click="confirm">Confirm</v-btn>
                  </v-layout>
                </v-stepper-content>
              </v-stepper-items>
            </v-stepper>
          </v-card-text>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'services-view',
  metaInfo () {
    return { title: this.$t('services') }
  },
  data: () => ({
    step: 0,
    selectedService: {
      id: 0,
      name: ''
    },
    selectedTime: null,
    today: new Date().toISOString().substr(0, 10),
    selectedDate: null,
    currentViewWeek: [],
    currentViewWeekString: '',
    selectedPet: {
      name: ''
    },
    startWeek: null,
    endWeek: null,
    map: new Map(),
    busy: false,
    weekDay: [
      'Sunday',
      'Monday',
      'Tuesday',
      'Wednesday',
      'Thursday',
      'Friday',
      'Saturday'
    ]
  }),
  computed: {
    ...mapGetters([
      'services',
      'bookings',
      'workinghours',
      'client'
    ])
  },
  watch: {
    selectedDate () {
      // find the selected week
      this.currentViewWeek = []
      const date = new Date(this.selectedDate)
      const diff = date.getDate() - date.getDay() + (date.getDay() === 0 ? -6 : 0)
      const lastday = date.getDate() - (date.getDay() - 1) + 6
      let startDate = new Date(date.setDate(diff))
      let endDate = new Date(date.setDate(lastday))
      startDate = startDate.toISOString().substr(0, 10)
      const start = {
        name: this.weekDay[0],
        date: startDate,
        availableTime: [],
        status: this.workinghours[0].status

      }
      this.currentViewWeek.push(start)
      var counter
      for (counter = 1; counter < 6; counter++) {
        var nextDate = new Date(date.setDate(diff))
        nextDate = new Date(date.setDate(date.getDate() + counter))
        nextDate = nextDate.toISOString().substr(0, 10)
        const next = {
          name: this.weekDay[counter],
          date: nextDate,
          availableTime: [],
          status: this.workinghours[counter].status
        }
        this.currentViewWeek.push(next)
      }
      this.startWeek
      endDate = endDate.toISOString().substr(0, 10)
      const end = {
        name: this.weekDay[6],
        date: endDate,
        availableTime: [],
        status: this.workinghours[6].status

      }
      this.currentViewWeek.push(end)
      this.currentViewWeekString = `${startDate} - ${endDate}`

      // find the available time
      if (this.selectedService.id === 1) {
        // can be optimized to map the current view week's booked date
        var j
        for (j = 0; j < this.selectedService.bookings.length; j++) {
          const time = this.selectedService.bookings[j].start_time
          this.map.set(time, time)
        }
        var k
        for (k = 0; k < this.selectedService.pendingBookings.length; k++) {
          const time = this.selectedService.pendingBookings[k].start_time
          this.map.set(time, time)
        }

        var index = 0
        this.workinghours.forEach(day => {
          var theDay = this.currentViewWeek[index]
          if (day.status === 1) {
            var sessions = parseInt(this.getSessionsBetweenDates(day.start_time, day.end_time))
            var i
            for (i = 0; i < sessions; i++) {
              var d = new Date(theDay.date + ' ' + day.start_time)
              var time = new Date(d.setHours(d.getHours() + i * this.selectedService.duration))
              time = this.getISOString(time)
              var theSession = {
                time: time,
                available: true
              }
              if (this.map.has(theSession.time) || this.checkIfSmallerThanNow(theSession.time)) {

              } else {
                this.currentViewWeek[index].availableTime.push(theSession)
              }
            }
          }
          index += 1
        })
      } else if (this.selectedService.id === 2) {

      }
    }
  },
  methods: {
    truncate (text) {
      text = text.substr(0, 80)
      return text + '...'
    },
    nextStep () {
      this.step++
    },
    prevStep () {
      this.step--
    },
    selectService (service) {
      this.selectedService = service
      if (this.selectedDate == null) {
        this.selectedDate = new Date().toISOString().substr(0, 10)
      }
      this.nextStep()
    },
    calendarPrev () {
      this.$refs.calendar.prev()
    },
    calendarNext () {
      this.$refs.calendar.next()
    },
    calendarToday () {
      this.selectedDate = this.today
    },
    getSessionsBetweenDates (startTime, endTime) {
      const startDate = new Date('2019 ' + startTime)
      const endDate = new Date('2019 ' + endTime)
      const diff = Math.abs(new Date(endDate) - new Date(startDate))
      const hours = Math.floor((diff / 1000) / 60 / 60)
      const sessions = hours / this.selectedService.duration
      return sessions
    },
    getTime (date) {
      const d = new Date(date).toTimeString()
      const [hour, min, sec] = d.split(':')
      sec
      return `${hour}:${min}:00`
    },
    getTimeWithoutSeconds (date) {
      const d = new Date(date).toTimeString()
      const [hour, min, sec] = d.split(':')
      sec
      return `${hour}:${min}`
    },
    getISOString (date) {
      const d = new Date(date).toISOString().substr(0, 10)
      const t = new Date(date).toTimeString().substr(0, 8)

      return `${d} ${t}`
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
    selectTime (time) {
      this.selectedTime = time
      this.nextStep()
    },
    selectPet (pet) {
      this.selectedPet = pet
      this.nextStep()
    },
    checkSelectedItems () {
      return !!this.selectedService && !!this.selectedTime && !!this.selectedPet
    },
    async confirm () {
      if (!this.checkSelectedItems()) return
      console.log('started')
      this.busy = true

      var startTime = new Date(this.selectedTime)
      var endTime = new Date(startTime.setHours(startTime.getHours() + this.selectedService.duration))
      endTime = this.getISOString(endTime)

      var pendingBooking = {
        client_id: this.client.id,
        pet_id: this.selectedPet.id,
        service_id: this.selectedService.id,
        start_time: this.selectedTime,
        end_time: endTime,
        status: 'pending'
      }

      await this.$store.dispatch('createPendingBooking', pendingBooking)
      this.$store.dispatch('fetchServices')
      this.busy = false

      this.$router.push({ name: 'client.home' })
      this.$store.dispatch('responseMessage', {
        type: 'success',
        text: 'Successfully Requested for Booking'
      })
    }
  }
}
</script>
