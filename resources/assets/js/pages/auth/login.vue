<template>
  <v-layout row>
    <v-flex xs12 sm8 offset-sm2 lg4 offset-lg4>
      <v-card>
        <progress-bar :show="busy"></progress-bar>
        <form @submit.prevent="login" @keydown="form.onKeydown($event)">
          <v-card-title primary-title>
            <h3 class="headline mb-0">{{ $t('login') }}</h3>
          </v-card-title>
          <v-card-text>
            <!-- Email -->
            <email-input
              :form="form"
              :label="$t('email')"
              :v-errors="errors"
              :value.sync="form.email"
              name="email"
              prepend="person_outline"
              v-validate="'required|email'"
            ></email-input>

            <!-- Password -->
            <password-input
              :v-errors="errors"
              :form="form"
              :value.sync="form.password"
              prepend="lock_outline"
              v-validate="'required|min:8'"
            ></password-input>

            <!-- Remember Me -->
            <v-checkbox
              :label="$t('remember_me')"
              color="primary"
              type="checkbox"
              v-model="remember"
              value="true"
            ></v-checkbox>

            <submit-button :block="true" :form="form" :label="$t('login')"></submit-button>
          </v-card-text>
          <v-card-actions>
            <router-link :to="{ name: 'register' }">{{ $t('register') }}</router-link>
            <v-spacer></v-spacer>
            <router-link :to="{ name: 'password.request' }">{{ $t('forgot_password') }}</router-link>
          </v-card-actions>
        </form>
      </v-card>
    </v-flex>
  </v-layout>
</template>

<script>
import Form from 'vform'
import { mapGetters } from 'vuex'

export default {
  name: 'login-view',
  metaInfo () {
    return { title: this.$t('login') }
  },
  data: () => ({
    form: new Form({
      email: '',
      password: ''
    }),
    eye: true,
    remember: false,
    busy: false
  }),
  computed: {
    ...mapGetters({
      role: 'authRole',
      user: 'authUser',
      loaded: 'authLoaded'
    })
  },

  methods: {
    async login () {
      if (await this.formHasErrors()) return
      this.busy = !this.loaded

      // Submit the form.
      const { data } = await this.form.post('/api/login')
      this.form.busy = this.busy

      // Save the token.
      this.$store.dispatch('saveToken', {
        token: data.token,
        remember: this.remember
      })

      // Fetch the user.
      await this.$store.dispatch('fetchUser')


      // Redirect home.
      if (this.role.name === 'admin' || this.role.name === 'employee') {
        await this.$store.dispatch('fetchEmployees')
        await this.$store.dispatch('fetchBookings')
        await this.$store.dispatch('fetchPendingBookings')
        await this.$store.dispatch('fetchServices')
        this.$store.dispatch('fetchClients')
        this.$store.dispatch('fetchCompany')
        this.$store.dispatch('fetchWorkingHours')
        this.$store.dispatch('fetchPets')

        if (this.role.name === 'admin') {

        } else {
          this.$store.dispatch('fetchEmployee', this.user.employee)
        }

        this.$router.push({ name: 'admin.dashboard' })
      } else {
        await this.$store.dispatch('fetchCompany')
        await this.$store.dispatch('fetchWorkingHours')
        this.$store.dispatch('fetchServices')
        this.$store.dispatch('fetchClient', this.user.client)
        this.$store.dispatch('fetchClientPendingBookings', this.user.client.id)
        this.$store.dispatch('fetchClientBookings', this.user.client.id)
        this.$store.dispatch('fetchClientPets', this.user.client.id)

        this.$router.push({ name: 'client.home' })
      }
      this.$store.dispatch('dataLoaded', true)
    }
  }
}
</script>
