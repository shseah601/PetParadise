<template>
  <v-layout row>
    <v-flex xs12 sm8 offset-sm2 lg4 offset-lg4>
      <v-card>
        <progress-bar :show="form.busy"></progress-bar>
        <v-form ref="form" @submit.prevent="register" @keydown="form.onKeydown($event)">
          <v-card-title primary-title>
            <h3 class="headline mb-0">{{ $t('register') }}</h3>
          </v-card-title>
          <v-card-text>
            <!-- Name -->
            <v-text-field
              v-model="form.name"
              :form="form"
              :label="$t('name')"
              :v-errors="errors"
              :rules="rules.name"
              browser-autocomplete="name"
              counter="30"
              name="name"
              v-validate="'required|max:30'"
            ></v-text-field>

            <!-- Email -->
            <v-text-field
              v-model="form.email"
              :form="form"
              :label="$t('email')"
              :v-errors="errors"
              :rules="rules.email"
              name="email"
              v-validate="'required|email'"
            ></v-text-field>

            <!-- Password -->
            <password-input
              v-model="form.password"
              :form="form"
              :hint="$t('password_length_hint')"
              :v-errors="errors"
              browser-autocomplete="new-password"
              v-on:eye="eye = $event"
              name="password"
              v-validate="'required|min:8'"
              required
            ></password-input>

            <!-- Password Confirmation -->
            <password-input
              v-model="form.password_confirmation"
              :form="form"
              :hide="eye"
              :label="$t('confirm_password')"
              :v-errors="errors"
              browser-autocomplete="new-password"
              data-vv-as="password"
              hide-icon="true"
              name="password_confirmation"
              v-validate="'required|confirmed:password'"
              required
            ></password-input>

            <v-text-field
              v-model="form.phone"
              :form="form"
              label="Phone"
              :v-errors="errors"
              :rules="rules.phone"
              counter
              maxlength="11"
              name="phone"
            ></v-text-field>

            <v-textarea
              v-model="form.address"
              :form="form"
              label="Address"
              :v-errors="errors"
              :rules="rules.address"
              counter
              name="address"
            ></v-textarea>
          </v-card-text>

          <v-card-actions>
            <submit-button :form="form" :label="$t('register')"></submit-button>
          </v-card-actions>
        </v-form>
      </v-card>
    </v-flex>
  </v-layout>
</template>

<script>
import Form from 'vform'

export default {
  name: 'register-view',
  metaInfo () {
    return { title: this.$t('register') }
  },

  data: () => ({
    form: new Form({
      name: '',
      email: '',
      password: '',
      password_confirmation: '',
      phone: '',
      address: ''
    }),
    eye: true,
    rules: {
      name: [
        v => !!v || 'Name is required',
        v => (v && v.length <= 100) || 'Name must be less than 100 characters'
      ],
      phone: [
        v => !!v || 'Phone is required',
        v => /^(01)[0-46-9][0-9]{7,8}$/.test(v) || 'Phone must be valid'
      ],
      email: [
        v => !!v || 'E-mail is required',
        v => /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(v) || 'E-mail must be valid'
      ],
      address: [
        v => !!v || 'Address is required'
      ]
    }
  }),

  methods: {
    async register () {
      if (!this.$refs.form.validate()) return
      if (await this.formHasErrors()) return

      // Register the user.
      await this.form.post('/api/register')

      // // Log in the user.
      // const { data: { token } } = await this.form.post('/api/login')

      // // Save the token.
      // this.$store.dispatch('saveToken', { token })

      // // Update the user.
      // await this.$store.dispatch('updateUser', { user: data })

      // Redirect home.
      this.$router.push({ name: 'login' })
      this.$store.dispatch('responseMessage', {
        type: 'success',
        text: 'Successfully Register Account'
      })
    }
  }
}
</script>
