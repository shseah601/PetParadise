<template>
  <v-card>
    <progress-bar :show="busy"></progress-bar>
    <v-card-title class="grey lighten-4">
      <h3 class="headline mb-0">{{ $t('pending_bookings') }}</h3>
      <v-spacer></v-spacer>
      <v-text-field v-model="search" append-icon="search" label="Search" single-line hide-details></v-text-field>
    </v-card-title>
    <v-card-text>
      <v-data-table :headers="headers" :items="pendingBookings" :search="search" class="elevation-1">
        <template v-slot:items="props">
          <td>{{ props.item.id }}</td>
          <td class="text-xs-left">{{ props.item.service.name }}</td>
          <td class="text-xs-left">{{ props.item.start_time }}</td>
          <td class="text-xs-left">{{ props.item.end_time }}</td>
          <td class="text-xs-left">{{ props.item.client.name }}</td>
          <td class="text-xs-left">{{ props.item.pet.name }}</td>
          <td class="text-xs-left">{{ props.item.status }}</td>
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
    headers: [
      { text: 'id', align: 'left', value: 'id' },
      { text: 'Service', value: 'service.name' },
      { text: 'Start Time', value: 'start_time' },
      { text: 'End Time', value: 'end_time' },
      { text: 'Client', value: 'client.name' },
      { text: 'Pet', value: 'pet.name' },
      { text: 'Status', value: 'status' }
    ]
  }),

  computed: {
    ...mapGetters([
      'pendingBookings'
    ])
  },

  watch: {
    dialog (val) {
      val || this.close()
    }
  }
}
</script>
