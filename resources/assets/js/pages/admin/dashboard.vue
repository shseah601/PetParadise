<template>
  <v-card>
    <v-card-title class="grey lighten-4">
      <h3 class="headline mb-0">{{ $t('dashboard') }}</h3>
    </v-card-title>
    <v-divider></v-divider>
    <v-card-text>
      <v-layout wrap>
        <v-flex v-for="stat in stats" :key="stat.number" xs6>
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
</template>

<script>
export default {
  name: 'admin-dashboard-view',
  metaInfo () {
    return { title: this.$t('dashboard') }
  },
  data: () => ({
    stats: [
      {
        number: '2',
        label: 'Bookings this week'
      },
      {
        number: 'RM 60 - 150',
        label: 'Bookings Sales this week'
      },
      {
        number: '2',
        label: 'Bookings this month'
      },
      {
        number: 'RM 60 - 150',
        label: 'Bookings Sales this month'
      }
    ]
  })
}
</script>
