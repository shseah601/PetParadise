<template>
  <v-card flat>
    <form @submit.prevent="update" @keydown="form.onKeydown($event)">
      <v-card-title primary-title>
        <h5 class="subheading mb-0">{{ $t('your_info') }}</h5>
      </v-card-title>
      <v-card-text>
        <!-- Name -->
        <text-input
          v-model="form.name"
          :form="form"
          :label="$t('name')"
          :v-errors="errors"
          :value.sync="form.name"
          counter="30"
          name="name"
          v-validate="'required|max:30'"
        ></text-input>

        <!-- Email -->
        <email-input
          :form="form"
          :label="$t('email')"
          :v-errors="errors"
          :value.sync="form.email"
          name="email"
          v-validate="'required|email'"
        ></email-input>

        <text-input
          v-model="form.phone"
          :form="form"
          label="Phone"
          :v-errors="errors"
          :value.sync="form.phone"
          counter
          name="phone"
          v-validate="'required|max:11'"
        ></text-input>
        <template v-if="this.role.name == 'admin' || this.role.name == 'employee'">
          <text-input
            v-model="form.ic_no"
            :form="form"
            label="IC No"
            :v-errors="errors"
            :value.sync="form.ic_no"
            counter
            name="ic_no"
            v-validate="'required|max:12'"
          ></text-input>

          <v-select
            v-model="form.gender"
            :items="gender"
            :value.sync="form.gender"
            label="Gender"
            required
          ></v-select>
          <v-menu
            v-model="dobMenu"
            :close-on-content-click="false"
            :nudge-right="40"
            lazy
            transition="scale-transition"
            offset-y
            full-width
            max-width="290px"
            min-width="290px"
          >
            <template v-slot:activator="{ on }">
              <v-text-field
                v-model="form.dob"
                label="Date of Birth"
                persistent-hint
                prepend-icon="event"
                v-on="on"
              ></v-text-field>
            </template>
            <v-date-picker v-model="form.dob" no-title @input="dobMenu = false"></v-date-picker>
          </v-menu>
          <v-textarea
            v-model="form.address"
            :form="form"
            label="Address"
            :v-errors="errors"
            :value.sync="form.address"
            counter
            name="address"
          ></v-textarea>
        </template>
      </v-card-text>
      <v-card-actions>
        <submit-button :flat="true" :form="form" :label="$t('update')"></submit-button>
      </v-card-actions>
    </form>
  </v-card>
</template>

<script>
import Form from 'vform'
import { mapGetters } from 'vuex'

export default {
  name: 'profile-view',
  data: () => ({
    form: new Form({
      name: '',
      email: '',
      ic_no: 0,
      address: '',
      gender: '',
      dob: '',
      phone: ''
    }),
    gender: ['M', 'F'],
    dobMenu: false

  }),

  computed: mapGetters({
    role: 'authRole',
    user: 'authUser',
    detail: 'authDetail'
  }),

  created () {
    // Fill the form with user data.
    this.form.keys().forEach(key => {
      this.form[key] = this.user[key]
    })
    this.form.name = this.detail.name
    this.form.phone = this.detail.phone
    if (this.role.name === 'admin' || this.role.name === 'employee') {
      this.form.ic_no = this.detail.ic_no
      this.form.address = this.detail.address
      this.form.gender = this.detail.gender
      this.form.dob = this.detail.dob
    }
  },

  methods: {
    async update () {
      if (await this.formHasErrors()) return

      this.$emit('busy', true)

      const { data } = await this.form.patch('/api/settings/profile')

      if (this.role.name === 'admin') {
        this.form.put('/api/admins/' + this.user.admin.id)
      } else if (this.role.name === 'employee') {
        this.form.put('/api/employees/' + this.user.employee.id)
      } else {
        this.form.put('/api/clients/' + this.user.client.id)
      }

      await this.$store.dispatch('fetchUser')
      this.$emit('busy', false)

      this.$store.dispatch('responseMessage', {
        type: 'success',
        text: this.$t('info_updated')
      })
    }
  }
}
</script>

