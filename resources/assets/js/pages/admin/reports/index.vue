<template>
  <v-layout row>
    <v-flex >
      <v-card>
        <progress-bar :show="busy"></progress-bar>
        <v-card-title class="grey lighten-4">
          <h3 class="headline mb-0">{{ $t('reports') }}</h3>
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
            <pending-booking-view v-on:busy="busy = $event"></pending-booking-view>
          </v-tab-item>
          <v-tab-item :value="'tab-booking'">
            <booking-view v-on:busy="busy = $event"></booking-view>
          </v-tab-item>

        </v-tabs>
      </v-card>
    </v-flex>
  </v-layout>
</template>

<script>
import Pending from '~/pages/admin/reports/pending'
import Booking from '~/pages/admin/reports/booking'

export default {
  name: 'reports-view',
  components: {
    'pending-booking-view': Pending,
    'booking-view': Booking
  },
  data () {
    return {
      busy: false
    }
  }
}
</script>
