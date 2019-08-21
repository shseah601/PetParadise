<template>
  <v-card>
    <progress-bar :show="busy"></progress-bar>
    <v-card-title class="grey lighten-4">
      <h3 class="headline mb-0">{{ $t('bookings') }}</h3>
      <v-spacer></v-spacer>
      <v-text-field v-model="search" append-icon="search" label="Search" single-line hide-details></v-text-field>
    </v-card-title>
    <v-card-text>
      <v-data-table
        :headers="headers"
        :items="bookings"
        :search="search"
        class="elevation-1"
        :pagination.sync="pagination"
      >
        <template v-slot:items="props">
          <td>{{ props.item.id }}</td>
          <td class="text-xs-left">{{ props.item.service.name }}</td>
          <td class="text-xs-left">{{ props.item.start_time }}</td>
          <td class="text-xs-left">{{ props.item.end_time }}</td>
          <td class="text-xs-left">{{ props.item.pet.name }}</td>
          <td class="text-xs-left">{{ props.item.employee ? props.item.employee.name : '-' }}</td>
          <td class="text-xs-left">{{ props.item.status }}</td>
          <td class="text-xs-left">{{ getISOString(props.item.created_at.date) }}</td>
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
  name: 'bookings-view',
  metaInfo () {
    return { title: this.$t('bookings') }
  },
  data: () => ({
    search: '',
    busy: false,
    dialog: false,
    pagination: {
      descending: true,
      sortBy: 'created_at.date'
    },
    headers: [
      { text: 'id', align: 'left', value: 'id' },
      { text: 'Service', value: 'service.name' },
      { text: 'Start Time', value: 'start_time' },
      { text: 'End Time', value: 'end_time' },
      { text: 'Pet', value: 'pet.name' },
      { text: 'Employee', value: 'employee.name' },
      { text: 'Status', value: 'status' },
      { text: 'Booked on', value: 'created_at.date' }

    ]
  }),

  computed: {
    ...mapGetters([
      'bookings'
    ])
  },

  watch: {
    dialog (val) {
      val || this.close()
    }
  },
  methods: {
    getISOString (date) {
      const d = new Date(date).toISOString().substr(0, 10)
      const t = new Date(date).toTimeString().substr(0, 8)

      return `${d} ${t}`
    }
  }
}
</script>
