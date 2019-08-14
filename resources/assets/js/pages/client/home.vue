<template>
  <v-container grid-list-md text-center>
    <v-layout wrap>
      <v-flex md12>
        <v-card>
          <v-card-text>
            <p class="display-3">{{ $t('app_name') }}</p>
            <v-divider></v-divider>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn large color="primary">Book Now</v-btn>
            <v-spacer></v-spacer>
          </v-card-actions>
        </v-card>
      </v-flex>
      <v-flex d-flex md3>
        <v-card class>
          <v-card-title class="headline">
            <strong>Operating Hours</strong>
          </v-card-title>
          <v-card-text>
            <v-data-table :items="times" class="elevation-1" hide-actions hide-headers>
              <template v-slot:items="props">
                <td class="text-xs-right">{{ props.item.day }}</td>
                <td class="text-xs-right">{{ props.item.time }}</td>
              </template>
            </v-data-table>
          </v-card-text>
        </v-card>
      </v-flex>
      <v-flex d-flex md6>
        <v-card class>
          <v-card-text>
            <p>
              <strong>Pet Care Centre, We Are Dedicated To Provide The Highest Quality Of Services For Your Pet.</strong>
            </p>
            <p>
              Your pets will get the best care and most comfortable from us.
              Experience our Pet Care Centre service and beautiful facilities that we hope can become your pet's home away from home.
            </p>
          </v-card-text>
        </v-card>
      </v-flex>
      <v-flex d-flex md3>
        <v-card class>
          <v-card-title class="headline">
            <strong>Contact Us</strong>
          </v-card-title>
          <v-card-text>
            <p>
            <v-icon>call</v-icon>
            012 - 3456789
            </p>
            <p>
            <v-icon>email</v-icon>
            petparadise@petparadise.com
            </p>
          </v-card-text>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
export default {
  name: 'home-view',
  metaInfo () {
    return { title: this.$t('home') }
  },
  data: () => ({
    times: [
      {
        day: 'Sun',
        time: 'Closed'
      },
      {
        day: 'Mon',
        time: '10:00 - 18:00'
      },
      {
        day: 'Tue',
        time: '10:00 - 18:00'
      },
      {
        day: 'Wed',
        time: '10:00 - 18:00'
      },
      {
        day: 'Thu',
        time: '10:00 - 18:00'
      },
      {
        day: 'Fri',
        time: '10:00 - 20:00'
      },
      {
        day: 'Sat',
        time: 'Closed'
      }
    ]
  }),
  methods: {
    ...mapGetters([
      'company'
    ])
  }
}
</script>
