<template>
  <v-container grid-list-md text-center>
    <v-layout wrap>
      <v-flex md12>
        <v-card>
          <v-card-text>
            <p class="display-3">{{ $t('app_name') }}</p>
            <v-divider></v-divider>
          </v-card-text>
        </v-card>
      </v-flex>
      <v-flex d-flex md3 v-for="(item, i) in services" :key="i">
        <v-card class>
          <v-card-title class="headline" v-text="item.name"></v-card-title>
          <v-card-text>
            <v-img :src="item.image" aspect-ratio="1" max-width="500" max-height="200"></v-img>
            <v-divider></v-divider>
            {{item.price}}
          </v-card-text>
          <v-divider></v-divider>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="primary">Book</v-btn>
          </v-card-actions>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
export default {
  name: 'services-view',
  metaInfo () {
    return { title: this.$t('services') }
  },
  data: () => ({
    services: [
      {
        name: 'Pet Grooming',
        image: '/img/services/pet-grooming.png',
        price: 'RM 30-90'
      },
      {
        name: 'Pet Boarding',
        image: '/img/services/pet-boarding.png',
        price: 'RM 40-100'

      }
    ]
  })
}
</script>
