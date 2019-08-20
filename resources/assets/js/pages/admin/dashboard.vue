<template>
  <v-card>
    <v-card-title class="grey lighten-4">
      <h3 class="headline mb-0">{{ $t('dashboard') }}</h3>
    </v-card-title>
    <v-divider></v-divider>
    <v-card-text>
      <v-card flat>
        <v-card-title class="display-1" primary-title>Bookings</v-card-title>
        <v-card-text>
          <v-layout wrap class="mb-5">
            <v-flex v-for="stat in bookingStats" :key="stat.number" xs6>
              <v-card class="text-xs-center" height="100%">
                <v-card-text>
                  <div class="display-1 mb-2">{{ stat.number }}</div>
                  {{ stat.label }}
                </v-card-text>
              </v-card>
            </v-flex>
          </v-layout>
        </v-card-text>
      </v-card>
      <v-card flat>
        <v-card-title class="display-1" primary-title>Pending Bookings</v-card-title>
        <v-card-text>
          <v-layout wrap class="mb-5">
            <v-flex v-for="stat in pendingBookingStats" :key="stat.number" xs6>
              <v-card class="text-xs-center" height="100%">
                <v-card-text>
                  <div class="display-1 mb-2">{{ stat.number }}</div>
                  {{ stat.label }}
                </v-card-text>
              </v-card>
            </v-flex>
          </v-layout>
        </v-card-text>
      </v-card>
    </v-card-text>
  </v-card>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'admin-dashboard-view',
  metaInfo () {
    return { title: this.$t('dashboard') }
  },
  data: () => ({
    today: new Date().toISOString().substr(0, 10),
    firstDateOfWeek: null,
    lastDateOfWeek: null,
    firstDateOfMonth: null,
    lastDateOfMonth: null,
    bookingStats: [],
    pendingBookingStats: []
  }),

  computed: {
    ...mapGetters([
      'bookings',
      'pendingBookings'
    ])
  },

  created () {
    this.calculateAcceptedBookings()
    this.calculatePendingBookings()
  },

  methods: {
    calculateAcceptedBookings () {
      var totalInWeek = 0
      var totalMinInWeek = 0
      var totalMaxInWeek = 0
      var totalInMonth = 0
      var totalMinInMonth = 0
      var totalMaxInMonth = 0

      const date = new Date(this.today)

      var first = date.getDate() - date.getDay()
      var startDateOfWeek = new Date(date.setDate(first))
      var lastDateOfWeek = new Date(date.setDate(date.getDate() + 6))
      this.firstDateOfWeek = startDateOfWeek.toISOString().substr(0, 10)
      this.lastDateOfWeek = lastDateOfWeek.toISOString().substr(0, 10)

      var startDateOfMonth = new Date(date.setDate(0))
      var lastDateOfMonth = new Date(date.getFullYear(), date.getMonth() + 2, 0)
      this.firstDateOfMonth = startDateOfMonth.toISOString().substr(0, 10)
      this.lastDateOfMonth = lastDateOfMonth.toISOString().substr(0, 10)

      this.bookings.forEach(booking => {
        if (this.isBiggerThanThisMonth(booking.start_time) && this.isSmallerThanThisMonth(booking.end_time)) {
          if (booking.status === 'accepted') {
            totalInMonth += 1
            totalMinInMonth += booking.service.price_min
            totalMaxInMonth += booking.service.price_max
          }
        }
        if (this.isBiggerThanThisWeek(booking.start_time) && this.isSmallerThanThisWeek(booking.end_time)) {
          if (booking.status === 'accepted') {
            totalInWeek += 1
            totalMinInWeek += booking.service.price_min
            totalMaxInWeek += booking.service.price_max
          }
        }
      })
      var bookingsThisWeek = {
        number: totalInWeek,
        label: 'Bookings this week'
      }
      var salesThisWeek = {
        number: `RM ${totalMinInWeek} - ${totalMaxInWeek}`,
        label: 'Bookings Sales this week'
      }
      var bookingsThisMonth = {
        number: totalInMonth,
        label: 'Bookings this month'
      }
      var salesThisMonth = {
        number: `RM ${totalMinInMonth} - ${totalMaxInMonth}`,
        label: 'Bookings Sales this month'
      }
      this.bookingStats.push(bookingsThisWeek)
      this.bookingStats.push(salesThisWeek)
      this.bookingStats.push(bookingsThisMonth)
      this.bookingStats.push(salesThisMonth)
    },

    calculatePendingBookings () {
      var totalInWeek = 0
      var totalMinInWeek = 0
      var totalMaxInWeek = 0
      var totalInMonth = 0
      var totalMinInMonth = 0
      var totalMaxInMonth = 0

      const date = new Date(this.today)

      var first = date.getDate() - date.getDay()
      var startDateOfWeek = new Date(date.setDate(first))
      var lastDateOfWeek = new Date(date.setDate(date.getDate() + 6))
      this.firstDateOfWeek = startDateOfWeek.toISOString().substr(0, 10)
      this.lastDateOfWeek = lastDateOfWeek.toISOString().substr(0, 10)

      var startDateOfMonth = new Date(date.setDate(0))
      var lastDateOfMonth = new Date(date.getFullYear(), date.getMonth() + 2, 0)
      this.firstDateOfMonth = startDateOfMonth.toISOString().substr(0, 10)
      this.lastDateOfMonth = lastDateOfMonth.toISOString().substr(0, 10)

      this.pendingBookings.forEach(booking => {
        if (this.isBiggerThanThisMonth(booking.start_time) && this.isSmallerThanThisMonth(booking.end_time)) {
          totalInMonth += 1
          totalMinInMonth += booking.service.price_min
          totalMaxInMonth += booking.service.price_max
        }
        if (this.isBiggerThanThisWeek(booking.start_time) && this.isSmallerThanThisWeek(booking.end_time)) {
          totalInWeek += 1
          totalMinInWeek += booking.service.price_min
          totalMaxInWeek += booking.service.price_max
        }
      })
      var bookingsThisWeek = {
        number: totalInWeek,
        label: 'Bookings this week'
      }
      var salesThisWeek = {
        number: `RM ${totalMinInWeek} - ${totalMaxInWeek}`,
        label: 'Projected Bookings Sales this week'
      }
      var bookingsThisMonth = {
        number: totalInMonth,
        label: 'Bookings this month'
      }
      var salesThisMonth = {
        number: `RM ${totalMinInMonth} - ${totalMaxInMonth}`,
        label: 'Projected Bookings Sales this month'
      }
      this.pendingBookingStats.push(bookingsThisWeek)
      this.pendingBookingStats.push(salesThisWeek)
      this.pendingBookingStats.push(bookingsThisMonth)
      this.pendingBookingStats.push(salesThisMonth)
    },

    isSmallerThanThisWeek (date) {
      const lastDayinWeek = new Date(this.lastDateOfWeek + ' 11:59:59')
      const diff = lastDayinWeek - new Date(date)

      if (Math.sign(diff) === 1) {
        return true
      } else {
        return false
      }
    },

    isBiggerThanThisWeek (date) {
      const firstDayinWeek = new Date(this.firstDateOfWeek + ' 00:00:00')
      const diff = firstDayinWeek - new Date(date)

      if (Math.sign(diff) === -1) {
        return true
      } else {
        return false
      }
    },

    isSmallerThanThisMonth (date) {
      const lastDayinMonth = new Date(this.lastDateOfMonth + ' 11:59:59')
      const diff = lastDayinMonth - new Date(date)

      if (Math.sign(diff) === 1) {
        return true
      } else {
        return false
      }
    },

    isBiggerThanThisMonth (date) {
      const firstDayinMonth = new Date(this.firstDateOfMonth + ' 00:00:00')
      const diff = firstDayinMonth - new Date(date)

      if (Math.sign(diff) === -1) {
        return true
      } else {
        return false
      }
    }
  }
}
</script>
