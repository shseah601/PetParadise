<template>
  <v-layout row>
    <v-flex >
      <v-card>
        <progress-bar :show="busy"></progress-bar>
        <v-card-title class="grey lighten-4">
          <h3 class="headline mb-0">Bookings History</h3>
        </v-card-title>
        <v-divider></v-divider>

        <v-tabs icons-and-text centered fixed>
          <v-tabs-slider color="primary"></v-tabs-slider>

          <v-tab href="#tab-pending">
            {{ $t('pending_bookings') }}
            <v-icon>history</v-icon>
          </v-tab>
          <v-tab href="#tab-booking">
            {{ $t('bookings') }}
            <v-icon>event</v-icon>
          </v-tab>

          <v-tab-item :value="'tab-pending'">
            <pending-bookings-view v-on:busy="busy = $event"></pending-bookings-view>
          </v-tab-item>
          <v-tab-item :value="'tab-booking'">
            <bookings-view v-on:busy="busy = $event"></bookings-view>
          </v-tab-item>
        </v-tabs>
      </v-card>
    </v-flex>
  </v-layout>
</template>

<script>
import Pending from '~/pages/client/history/pending'
import Booking from '~/pages/client/history/booking'

export default {
  name: 'bookings-history-view',
  components: {
    'pending-bookings-view': Pending,
    'bookings-view': Booking
  },
  data () {
    return {
      busy: false
    }
  }
}
</script>
