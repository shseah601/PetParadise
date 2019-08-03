<template>
  <v-card>
    <v-card-title class="grey lighten-4">
      <h3 class="headline mb-0">{{ $t('employees') }}</h3>
    </v-card-title>
    <v-divider></v-divider>
    <v-card-text>
      Employees View
    </v-card-text>
  </v-card>
</template>

<script>
export default {
  name: 'employees-view',
  metaInfo () {
    return { title: 'Employees' }
  }
}
</script>
