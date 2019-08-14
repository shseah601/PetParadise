<template>
  <main>
    <v-content>
      <v-container fluid>
        <v-layout column align-center>
          <div class="display-3 grey--text mt-5">{{ $t('page_not_found') }}</div>
          <div class="body-2 my-3">
            <router-link v-if="role && (role.name == 'admin' || role.name == 'employee')" :to="{ name: 'admin.dashboard' }">
              {{ $t('go_home') }}
            </router-link>
            <router-link v-else :to="{ name: 'client.home' }">
              {{ $t('go_home') }}
            </router-link>
          </div>
        </v-layout>
      </v-container>
    </v-content>
  </main>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
  name: 'not-found',
  layout: 'default',
  computed: {
    ...mapGetters({
      role: 'authRole'
    })
  }
}
</script>
