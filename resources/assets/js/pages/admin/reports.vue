<template>
  <v-card>
    <v-card-title class="grey lighten-4">
      <h3 class="headline mb-0">{{ $t('reports') }}</h3>
    </v-card-title>
    <v-divider></v-divider>
    <v-card-text>
      Reports
    </v-card-text>
  </v-card>
</template>

<script>
export default {
  name: 'admin-reports-view',
  metaInfo () {
    return { title: this.$t('reports') }
  }
}
</script>
