<template>
  <v-container grid-list-md text-center>
    <v-layout wrap>
      <v-flex xs12 sm12 md12>
        <v-card>
          <v-card-text>
            <p class="display-3">{{ $t('app_name') }}</p>
            <v-divider></v-divider>
          </v-card-text>
        </v-card>
      </v-flex>
      <v-flex xs12 sm12 md3>
        <v-flex v-for="(item, i) in services" :key="i">
          <v-card class>
            <v-card-title class="headline" v-text="item.name"></v-card-title>
            <v-card-text>
              <v-img :src="item.image" aspect-ratio="1" max-width="500" max-height="200"></v-img>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="primary">Book</v-btn>
            </v-card-actions>
          </v-card>
        </v-flex>
      </v-flex>
      <v-flex d-flex xs12 sm12 md9>
        <v-card>
          <v-card-title align-center>
            <v-btn>&lt; Previous Week</v-btn>
            <v-spacer></v-spacer>
            <p class="headline">4/8/2019 - 10/8/2019</p>
            <v-spacer></v-spacer>
            <v-btn>Next Week &gt;</v-btn>
          </v-card-title>
          <v-divider></v-divider>
          <v-card-text>
            <p>Select a time below</p>
            <br />
            <p>4/8/2019 - Sunday</p>
            <p>N/A</p>
            <br />
            <p>5/8/2019 - Monday</p>
            <p>N/A</p>
            <br />
            <p>6/8/2019 - Tuesday</p>
            <p>N/A</p>
            <br />
            <p>7/8/2019 - Wednesday</p>
            <v-btn>10:00</v-btn>
            <v-btn>12:00</v-btn>
            <v-btn>14:00</v-btn>
            <v-btn>16:00</v-btn>
            <br />
            <p>8/8/2019 - Thursday</p>
            <v-btn>10:00</v-btn>
            <v-btn>14:00</v-btn>
            <v-btn>16:00</v-btn>
            <br />
            <p>9/8/2019 - Friday</p>
            <v-btn>10:00</v-btn>
            <v-btn>12:00</v-btn>
            <v-btn>14:00</v-btn>
            <br />
            <p>10/8/2019 - Saturday</p>
            <p>N/A</p>
          </v-card-text>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
export default {
  name: 'booking-view',
  metaInfo () {
    return { title: this.$t('booking') }
  },
  data: () => ({
    services: [
      {
        name: 'Pet Grooming',
        image: '/img/services/pet-grooming.png'
      }
    ]
  })
}
</script>
