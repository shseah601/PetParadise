<template>
  <v-container grid-list-md text-center>
    <v-layout row wrap>
      <v-flex xs12>
        <v-card>
          <v-card-title primary-title>
            <div class="display-3">{{ $t('app_name') }}</div>
          </v-card-title>
          <v-card-text>
            <v-img
            src="/img/home1.jpg"
            contain
            >
            </v-img>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn large color="primary" :to="{ name: 'client.book' }">Book Now</v-btn>
            <v-spacer></v-spacer>
          </v-card-actions>
        </v-card>
      </v-flex>
      <v-flex xs12>
        <v-layout wrap>
          <v-flex d-flex xs12 sm4 md4>
            <v-card class>
              <v-card-title class="headline">
                <strong>Operating Hours</strong>
              </v-card-title>
              <v-card-text>
                <v-data-table :items="workinghours" class="elevation-1" hide-actions hide-headers>
                  <template v-slot:items="props">
                    <td>{{ props.item.name }}</td>
                    <td
                      class="text-xs-right"
                    >{{ getTimeRange(props.item.start_time, props.item.end_time) }}</td>
                  </template>
                </v-data-table>
              </v-card-text>
            </v-card>
          </v-flex>
          <v-flex d-flex xs12 sm4 md4>
            <v-card class>
              <v-card-text>
                <v-layout row wrap>
                  <v-flex xs12>
                    <strong>{{companyDetail.title}}</strong>
                  </v-flex>
                  <v-flex xs12>
                    <div>{{companyDetail.description}}</div>
                  </v-flex>
                </v-layout>
              </v-card-text>
            </v-card>
          </v-flex>
          <v-flex d-flex xs12 sm4 md4>
            <v-card class>
              <v-card-title class="headline">
                <strong>Contact Us</strong>
              </v-card-title>
              <v-card-text>
                <v-flex xs12>
                  <v-layout>
                    <v-flex xs2>
                      <v-icon>call</v-icon>
                    </v-flex>
                    <v-flex xs10>
                      <div>012 - 3456789</div>
                    </v-flex>
                  </v-layout>
                </v-flex>
                <v-flex xs12>
                  <v-layout>
                    <v-flex xs2>
                      <v-icon>email</v-icon>
                    </v-flex>
                    <v-flex xs10>
                      <div>petparadise@petparadise.com</div>
                    </v-flex>
                  </v-layout>
                </v-flex>
              </v-card-text>
            </v-card>
          </v-flex>
        </v-layout>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'home-view',
  metaInfo () {
    return { title: this.$t('home') }
  },
  data: () => ({

  }),
  computed: {
    ...mapGetters([
      'companyDetail',
      'workinghours'
    ])
  },
  methods: {
    getTimeRange (startTime, endTime) {
      const [hour1, min1, sec1] = startTime.split(':')
      sec1
      const start = `${hour1}:${min1}`
      const [hour2, min2, sec2] = endTime.split(':')
      sec2
      const end = `${hour2}:${min2}`

      return `${start} - ${end}`
    }
  }
}
</script>
