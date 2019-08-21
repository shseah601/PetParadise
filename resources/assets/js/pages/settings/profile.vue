<template>
  <v-card flat>
    <form @submit.prevent="update" @keydown="form.onKeydown($event)">
      <v-card-title primary-title>
        <h5 class="subheading mb-0">{{ $t('your_info') }}</h5>
      </v-card-title>
      <v-card-text>
        <!-- Name -->
        <v-text-field
          v-model="form.name"
          :form="form"
          :label="$t('name')"
          :v-errors="errors"
          :rules="rules.name"
          counter="30"
          name="name"
        ></v-text-field>

        <!-- Email -->
        <v-text-field
          v-model="form.email"
          :form="form"
          :label="$t('email')"
          :v-errors="errors"
          :rules="rules.email"
          disabled
          name="email"
        ></v-text-field>

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
        <template v-if="this.role.name == 'admin' || this.role.name == 'employee'">
          <v-text-field
            v-model="form.ic_no"
            :form="form"
            label="IC No"
            :v-errors="errors"
            :rules="rules.ic_no"
            counter
            name="ic_no"
          ></v-text-field>

          <v-select
            v-model="form.gender"
            :items="gender"
            label="Gender"
            :rules="rules.gender"
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
                :rules="rules.dob"
                prepend-icon="event"
                v-on="on"
              ></v-text-field>
            </template>
            <v-date-picker v-model="form.dob" no-title @input="dobMenu = false"></v-date-picker>
          </v-menu>
        </template>
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
    dobMenu: false,
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
      ],
      ic_no: [
        v => !!v || 'IC No is required',
        v => /^\d{12}$/.test(v) || 'IC No must be 12 digits'

      ],
      gender: [
        v => !!v || 'Gender is required'
      ],
      dob: [
        v => !!v || 'Date of Birth is required'
      ]
    }
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
    this.form.address = this.detail.address
    if (this.role.name === 'admin' || this.role.name === 'employee') {
      this.form.ic_no = this.detail.ic_no
      this.form.gender = this.detail.gender
      this.form.dob = this.detail.dob
    }
  },

  methods: {
    async update () {
      if (await this.formHasErrors()) return

      this.$emit('busy', true)

      this.form.patch('/api/settings/profile')

      if (this.role.name === 'admin') {
        await this.form.put('/api/admins/' + this.user.admin.id)
      } else if (this.role.name === 'employee') {
        await this.form.put('/api/employees/' + this.user.employee.id)
      } else {
        await this.form.put('/api/clients/' + this.user.client.id)
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

