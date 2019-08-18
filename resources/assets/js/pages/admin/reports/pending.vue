<template>
  <v-card>
    <progress-bar :show="busy"></progress-bar>
    <v-card-title class="grey lighten-4">
      <h3 class="headline mb-0">{{ $t('pending_bookings') }}</h3>
      <v-spacer></v-spacer>
      <v-text-field v-model="search" append-icon="search" label="Search" single-line hide-details></v-text-field>
    </v-card-title>
    <v-card-text>
      <v-data-table
        :headers="headers"
        :items="pendingBookings"
        :search="search"
        :pagination.sync="pagination"
        class="elevation-1"
      >
        <template v-slot:items="props">
          <td>{{ props.item.id }}</td>
          <td class="text-xs-left">{{ props.item.service.name }}</td>
          <td class="text-xs-left">{{ props.item.start_time }}</td>
          <td class="text-xs-left">{{ props.item.end_time }}</td>
          <td class="text-xs-left">{{ props.item.client.name }}</td>
          <td class="text-xs-left">{{ props.item.pet.name }}</td>
          <td class="text-xs-left">{{ props.item.status }}</td>
          <td class="justify-center layout px-0">
            <v-icon medium @click="acceptItem(props.item)">done</v-icon>
            <v-icon medium @click="rejectItem(props.item)">clear</v-icon>
          </td>
        </template>
        <template v-slot:no-results>
          <v-alert
            :value="true"
            color="error"
            icon="warning"
          >Your search for "{{ search }}" found no results.</v-alert>
        </template>
      </v-data-table>
    </v-card-text>
  </v-card>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'pending-booking-view',
  metaInfo () {
    return { title: this.$t('pending_bookings') }
  },
  data: () => ({
    search: '',
    busy: false,
    pagination: {
      descending: true,
      sortBy: 'start_time'
    },
    headers: [
      { text: 'id', align: 'left', value: 'id' },
      { text: 'Service', value: 'service.name' },
      { text: 'Start Time', value: 'start_time' },
      { text: 'End Time', value: 'end_time' },
      { text: 'Client', value: 'client.name' },
      { text: 'Pet', value: 'pet.name' },
      { text: 'Status', value: 'status' },
      { text: 'Actions', value: 'id', sortable: false }

    ]
  }),

  computed: {
    ...mapGetters([
      'pendingBookings',
      'authUser'
    ])
  },

  watch: {
    dialog (val) {
      val || this.close()
    }
  },
  methods: {
    async acceptItem (pendingBooking) {
      var r = confirm('Are you sure you want to accept this item?')
      if (r) {
        this.busy = true
        await this.$store.dispatch('deletePendingBooking', pendingBooking)
        var booking = {
          status: 'accepted',
          pet_id: pendingBooking.pet.id,
          client_id: pendingBooking.client.id,
          service_id: pendingBooking.service.id,
          employee_id: this.authUser.employee ? this.authUser.employee.id : '',
          start_time: pendingBooking.start_time,
          end_time: pendingBooking.end_time
        }
        await this.$store.dispatch('createBooking', booking)
        this.busy = false
        this.$store.dispatch('responseMessage', {
          type: 'success',
          text: 'Successfully Accepted Pending Booking'
        })
      } else {

      }
    },
    async rejectItem (pendingBooking) {
      var r = confirm('Are you sure you want to reject this item?')
      if (r) {
        this.busy = true
        await this.$store.dispatch('deletePendingBooking', pendingBooking)
        var booking = {
          status: 'rejected',
          pet_id: pendingBooking.pet.id,
          client_id: pendingBooking.client.id,
          service_id: pendingBooking.service.id,
          start_time: pendingBooking.start_time,
          end_time: pendingBooking.end_time
        }
        await this.$store.dispatch('createBooking', booking)
        this.busy = false
        this.$store.dispatch('responseMessage', {
          type: 'success',
          text: 'Successfully Rejected Pending Booking'
        })
      } else {

      }
    }
  }
}
</script>
