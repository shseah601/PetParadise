<template>
  <v-card>
    <v-card-title class="grey lighten-4">
      <h3 class="headline mb-0">{{ $t('clients') }}</h3>
    </v-card-title>
    <v-divider></v-divider>
    <v-card-text>
      Company Working Hour View
    </v-card-text>
  </v-card>
</template>

<script>
export default {
  name: 'admin-company-workinghour-view',
  metaInfo () {
    return { title: 'Clients' }
  }
}
</script>
