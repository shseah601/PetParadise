<template>
  <v-card>
    <v-card-title class="grey lighten-4">
      <h3 class="headline mb-0">{{ $t('working_hours') }}</h3>
    </v-card-title>
    <v-divider></v-divider>
    <v-card-text>
      <v-container fluid grid-list-lg>
        <v-layout row wrap>
          <template v-for="(day, index) in editedWorkinghours">
            <v-flex xs12 :key="day.id">
              <v-card flat>
                <v-layout row wrap>
                  <v-flex xs11 sm11 md11>
                    <div class="pl-0 headline">{{ day.name }}</div>
                    <v-range-slider
                      :tick-labels="timesLabel"
                      :value="[getHour(day.start_time), getHour(day.end_time)]"
                      :disabled="day.status == 0"
                      always-dirty
                      min="0"
                      max="24"
                      thumb-label
                      height="20"
                      thumb-size="64"
                      ticks="always"
                      @change="timeChanged(index, $event !== null, $event)"
                    >
                      <template v-slot:thumb-label="props">
                        <span>{{ time(props.value) }}</span>
                      </template>
                    </v-range-slider>
                  </v-flex>
                  <v-flex xs1 sm1 md1>
                    <v-switch
                      :value="true"
                      :input-value="day.status == 1"
                      @change="toggle(index, $event !== null, $event)"
                    ></v-switch>
                  </v-flex>
                </v-layout>
              </v-card>
            </v-flex>
          </template>
        </v-layout>
      </v-container>
    </v-card-text>
    <v-card-actions>
      <v-spacer></v-spacer>
      <v-btn :disabled="busy" color="red lighten-1" class="white--text" @click="reset">Reset</v-btn>
      <v-btn :loading="busy" color="green lighten-1" class="white--text" @click="update">Update</v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'admin-company-workinghour-view',
  metaInfo () {
    return { title: this.$t('working_hours') }
  },
  data: () => ({
    timesLabel: [
      '00:00',
      '',
      '02:00',
      '',
      '04:00',
      '',
      '06:00',
      '',
      '08:00',
      '',
      '10:00',
      '',
      '12:00',
      '',
      '14:00',
      '',
      '16:00',
      '',
      '18:00',
      '',
      '20:00',
      '',
      '22:00',
      '',
      '24:00'
    ],
    times: [
      '00:00',
      '01:00',
      '02:00',
      '03:00',
      '04:00',
      '05:00',
      '06:00',
      '07:00',
      '08:00',
      '09:00',
      '10:00',
      '11:00',
      '12:00',
      '13:00',
      '14:00',
      '15:00',
      '16:00',
      '17:00',
      '18:00',
      '19:00',
      '20:00',
      '21:00',
      '22:00',
      '23:00',
      '24:00'
    ],
    workinghours: [],
    defaultWorkinghours: [
      {
        id: 1,
        name: 'Sunday',
        start_time: null,
        end_time: null,
        status: null
      },
      {
        id: 2,
        name: 'Monday',
        start_time: null,
        end_time: null,
        status: null
      },
      {
        id: 3,
        name: 'Tuesday',
        start_time: null,
        end_time: null,
        status: null
      },
      {
        id: 4,
        name: 'Wednesday',
        start_time: null,
        end_time: null,
        status: null
      },
      {
        id: 5,
        name: 'Thursday',
        start_time: null,
        end_time: null,
        status: null
      },
      {
        id: 6,
        name: 'Friday',
        start_time: null,
        end_time: null,
        status: null
      },
      {
        id: 7,
        name: 'Saturday',
        start_time: null,
        end_time: null,
        status: null
      }
    ],
    editedWorkinghours: [
      {
        id: 1,
        name: 'Sunday',
        start_time: null,
        end_time: null,
        status: null
      },
      {
        id: 2,
        name: 'Monday',
        start_time: null,
        end_time: null,
        status: null
      },
      {
        id: 3,
        name: 'Tuesday',
        start_time: null,
        end_time: null,
        status: null
      },
      {
        id: 4,
        name: 'Wednesday',
        start_time: null,
        end_time: null,
        status: null
      },
      {
        id: 5,
        name: 'Thursday',
        start_time: null,
        end_time: null,
        status: null
      },
      {
        id: 6,
        name: 'Friday',
        start_time: null,
        end_time: null,
        status: null
      },
      {
        id: 7,
        name: 'Saturday',
        start_time: null,
        end_time: null,
        status: null
      }
    ],
    submit: {
      workinghours: []
    },
    busy: false
  }),

  computed: {
    ...mapGetters([
      'allWorkingHours'
    ])
  },
  async created () {
    this.initialize()
  },

  methods: {
    initialize () {
      this.workinghours = this.allWorkingHours.data
      this.defaultWorkinghours = JSON.parse(JSON.stringify(this.workinghours))
      this.editedWorkinghours = JSON.parse(JSON.stringify(this.defaultWorkinghours))
    },

    time (val) {
      return this.times[val]
    },
    getHour (time) {
      if (!time) return null

      const [hour] = time.split(':')
      return parseInt(hour)
    },
    toggle (index, value, event) {
      console.log(`update ${index} ${value} ${event}`)
      if (value) {
        value = 1
      } else {
        value = 0
      }
      this.editedWorkinghours[index].status = value
      // this.$store.dispatch('updateWorkingHour', { index, value })
    },
    timeChanged (index, value, event) {
      console.log(`slider ${index} ${value} ${event}`)
      this.editedWorkinghours[index].start_time = `${event[0]}:00:00`
      this.editedWorkinghours[index].end_time = `${event[1]}:00:00`
    },
    reset () {
      this.editedWorkinghours = Object.assign({}, this.defaultWorkinghours)
    },
    async update () {
      this.submit.workinghours = Object.assign({}, this.editedWorkinghours)
      console.log(this.submit)
      this.busy = true
      await this.$store.dispatch('updateWorkingHours', this.submit)
      this.busy = false
    }
  }
}
</script>
