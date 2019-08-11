<template>
  <v-container fluid grid-list-md>
    <v-layout row wrap>
      <v-flex xs12 sm12 md12>
        <v-card>
          <v-card-title class="grey lighten-4">
            <h3 class="headline mb-0">{{ $t('company') }}</h3>
          </v-card-title>
          <v-divider></v-divider>
          <v-card-text>
            <v-layout row wrap>
              <v-flex d-flex xs6 sm4 md4>
                <v-img
                  :src="company.logo ? company.logo : '/img/default-image.jpg'"
                  contain
                ></v-img>
              </v-flex>
              <v-flex d-flex xs6 sm8 md8 class="mb-5">
                <h4 class="title font-weight-regular">Logo</h4>
                <p></p>
              </v-flex>
            </v-layout>
          </v-card-text>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
  name: 'admin-company-detail-view',
  metaInfo () {
    return { title: this.$t('company') }
  },
  data: () => ({
  }),
  computed: {
    ...mapGetters([
      'companyDetail'
    ])
  },
  async created () {
    this.initialize()
  },

  methods: {
    initialize () {
      this.company = this.companyDetail
    }

  }
}
</script>
