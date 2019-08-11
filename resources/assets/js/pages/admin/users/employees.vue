<template>
  <v-card>
    <progress-bar :show="busy"></progress-bar>
    <v-card-title class="grey lighten-4">
      <h3 class="headline mb-0">{{ $t('employees') }}</h3>
      <v-spacer></v-spacer>
      <v-dialog v-model="dialog" max-width="500px">
        <template v-slot:activator="{ on }">
          <v-btn color="primary" dark class="mb-2" v-on="on">
            <v-icon left dark>add_circle</v-icon>New Item
          </v-btn>
        </template>
        <v-card>
          <v-form ref="form" @submit.prevent="submit">
            <v-card-title>
              <span class="headline">{{ formTitle }}</span>
            </v-card-title>

            <v-card-text>
              <v-container grid-list-md>
                <v-layout wrap>
                  <v-flex xs12 sm12 md12>
                    <v-text-field
                      v-model="editedItem.name"
                      :rules="rules.name"
                      label="Employee name"
                      required
                    ></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm12 md12>
                    <v-text-field
                      v-model="editedItem.ic_no"
                      :rules="rules.ic_no"
                      label="IC No"
                      required
                    ></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm12 md12>
                    <v-select
                      v-model="editedItem.gender"
                      :items="gender"
                      :rules="rules.gender"
                      label="Gender"
                      required
                    ></v-select>
                  </v-flex>
                  <v-flex xs12 sm12 md12>
                    <v-text-field
                      v-model="editedItem.user.email"
                      :disabled="editedIndex != -1"
                      :rules="(editedIndex != -1) ? [] : rules.email"
                      label="Email"
                      required
                    ></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm12 md12>
                    <v-text-field
                      v-model="editedItem.phone"
                      :rules="rules.phone"
                      label="Phone"
                      required
                    ></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm12 md12>
                    <v-text-field
                      v-model="editedItem.address"
                      :rules="rules.address"
                      label="Address"
                      required
                    ></v-text-field>
                  </v-flex>
                </v-layout>
              </v-container>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn :disabled="busy" color="blue darken-1" flat @click="close">Cancel</v-btn>
              <v-btn :loading="busy" :disabled="busy" color="blue darken-1" flat @click="save">Save</v-btn>
            </v-card-actions>
          </v-form>
        </v-card>
      </v-dialog>
    </v-card-title>
    <v-card-text>
      <v-data-table :headers="headers" :items="employees" class="elevation-1">
        <template v-slot:items="props">
          <td>{{ props.item.name }}</td>
          <td class="text-xs-left">{{ props.item.ic_no }}</td>
          <td class="text-xs-left">{{ props.item.gender }}</td>
          <td class="text-xs-left">{{ props.item.user.email }}</td>
          <td class="text-xs-left">{{ props.item.phone }}</td>
          <td class="text-xs-left">{{ props.item.address }}</td>
          <td class="justify-center layout px-0">
            <v-icon small class="mr-2" @click="editItem(props.item)">edit</v-icon>
            <v-icon small @click="deleteItem(props.item)">delete</v-icon>
          </td>
        </template>
      </v-data-table>
    </v-card-text>
  </v-card>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'admin-employees-view',
  metaInfo () {
    return { title: this.$t('employees') }
  },
  data: () => ({
    busy: false,
    dialog: false,
    headers: [
      { text: 'Name', align: 'left', value: 'name' },
      { text: 'IC No', value: 'ic_no' },
      { text: 'Gender', value: 'gender' },
      { text: 'Email', value: 'email' },
      { text: 'Phone', value: 'phone' },
      { text: 'Address', value: 'address' },
      { text: 'Actions', value: 'name', sortable: false }
    ],
    employees: [],
    editedIndex: -1,
    editedItem: {
      name: '',
      ic_no: '',
      gender: '',
      user: {
        email: ''
      },
      phone: '',
      address: ''
    },
    defaultItem: {
      name: '',
      phone: '',
      user: {
        email: ''
      },
      address: ''
    },
    gender: ['M', 'F'],
    form: Object.assign({}, this.defaultItem),
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
        v => /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/.test(v) || 'E-mail must be valid'
      ],
      address: [
        v => !!v || 'Address is required'
      ],
      ic_no: [
        v => !!v || 'IC No is required'
      ],
      gender: [
        v => !!v || 'Gender is required'
      ]
    }
  }),

  computed: {
    formTitle () {
      return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
    },
    ...mapGetters([
      'allEmployees'
    ])
  },

  watch: {
    dialog (val) {
      val || this.close()
    }
  },

  created () {
    this.initialize()
  },

  methods: {
    initialize () {
      this.employees = this.allEmployees.data
    },

    editItem (item) {
      this.editedIndex = this.employees.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialog = true
    },

    async deleteItem (item) {
      const index = this.employees.indexOf(item)
      var r = confirm('Are you sure you want to delete this item?') && this.employees.splice(index, 1)
      if (r) {
        console.log('delete')
        this.busy = true
        await this.$store.dispatch('deleteEmployee', item)
        this.busy = false
      } else {

      }
    },

    close () {
      this.dialog = false
      this.editedItem = Object.assign({}, this.defaultItem)
      this.editedIndex = -1
      this.$refs.form.reset()

    },

    async save () {
      if (!this.$refs.form.validate()) return

      if (this.editedIndex > -1) {
        this.busy = true
        await this.$store.dispatch('updateEmployee', this.editedItem)
        this.busy = false
        Object.assign(this.employees[this.editedIndex], this.editedItem)
      } else {
        var newItem = Object.assign({}, this.editedItem)
        var otherDetail = {
          email: newItem.user.email,
          password: '123456789',
          password_confirmation: '123456789'
        }
        Object.assign(newItem, otherDetail)
        this.busy = true
        await this.$store.dispatch('createEmployee', newItem)
        this.busy = false
        this.employees.push(this.editedItem)
      }
      this.close()
    }
  }
}
</script>
