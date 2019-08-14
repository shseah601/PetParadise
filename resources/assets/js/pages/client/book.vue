<template>
  <v-container grid-list-md text-center>
    <v-layout wrap>
      <v-flex md12>
        <v-card>
          <v-card-title primary-title>
            <div class="display-3">{{ $t('app_name') }}</div>
          </v-card-title>
          <v-card-text>
            <v-stepper v-model="step">
              <v-stepper-header>
                <v-stepper-step :complete="step > 1" step="1">Choose a service</v-stepper-step>

                <v-divider></v-divider>

                <v-stepper-step :complete="step > 2" step="2">Choose a time</v-stepper-step>

                <v-divider></v-divider>

                <v-stepper-step step="3">Select Your Pet</v-stepper-step>
              </v-stepper-header>
              <v-stepper-items>
                <v-stepper-content step="1">
                  <v-card class="mb-5" flat>
                    <v-layout wrap>
                      <v-flex d-flex md3 v-for="(item, i) in services" :key="i">
                        <v-card>
                          <v-card-title class="headline" v-text="item.name"></v-card-title>
                          <v-card-text>
                            <v-layout row wrap>
                              <v-flex xs12>
                                <v-img
                                  :src="item.image"
                                  aspect-ratio="1"
                                  max-width="500"
                                  max-height="200"
                                  contain
                                ></v-img>
                              </v-flex>
                              <v-flex xs12>
                                <v-divider></v-divider>
                                <div class="mt-3">Price: RM {{item.price_min}} - {{item.price_max}}</div>
                              </v-flex>
                              <v-flex xs12>
                                <div>Description:</div>
                              </v-flex>
                              <v-flex xs12>
                                <div>{{truncate(item.description)}}</div>
                              </v-flex>
                            </v-layout>
                          </v-card-text>
                          <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="primary" @click="step = 2">Book</v-btn>
                          </v-card-actions>
                        </v-card>
                      </v-flex>
                    </v-layout>
                  </v-card>
                </v-stepper-content>

                <v-stepper-content step="2">
                  <v-card class="mb-5" color="grey lighten-1" height="200px"></v-card>

                  <v-btn flat @click="step = 1">Back</v-btn>
                  <v-btn color="primary" @click="step = 3">Continue</v-btn>
                </v-stepper-content>

                <v-stepper-content step="3">
                  <v-card class="mb-5" color="grey lighten-1" height="200px"></v-card>
                  <v-btn flat @click="step = 2">Back</v-btn>
                  <v-btn color="primary">Continue</v-btn>
                </v-stepper-content>
              </v-stepper-items>
            </v-stepper>
          </v-card-text>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'services-view',
  metaInfo () {
    return { title: this.$t('services') }
  },
  data: () => ({
    step: 0
  }),
  computed: {
    ...mapGetters([
      'services'
    ])
  },
  methods: {
    truncate (text) {
      text = text.substr(0, 80)
      return text + '...'
    }
  }
}
</script>
