<template>
  <v-card>
    <progress-bar :show="busy"></progress-bar>
    <v-card-title class="grey lighten-4">
      <h3 class="headline mb-0">{{ $t('clients') }}</h3>
      <v-spacer></v-spacer>
      <v-text-field v-model="search" append-icon="search" label="Search" single-line hide-details></v-text-field>
      <v-spacer></v-spacer>
      <v-dialog v-model="dialog" max-width="500px">
        <template v-slot:activator="{ on }">
          <v-btn color="primary" dark class="mb-2" v-on="on">
            <v-icon left dark>add_circle</v-icon>New
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
                      :counter="100"
                      :rules="rules.name"
                      label="Client Name"
                      required
                    ></v-text-field>
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
                      mask="01# - ########"
                      maxlength="11"
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
      <v-data-table :headers="headers" :items="clients" :search="search" class="elevation-1">
        <template v-slot:items="props">
          <td>{{ props.item.name }}</td>
          <td class="text-xs-left">{{ props.item.user.email }}</td>
          <td class="text-xs-left">{{ props.item.phone }}</td>
          <td class="text-xs-left">{{ props.item.address }}</td>
          <td class="justify-center layout px-0">
            <v-icon small class="mr-2" @click="editItem(props.item)">edit</v-icon>
            <v-icon small @click="deleteItem(props.item)">delete</v-icon>
          </td>
        </template>
        <template v-slot:no-results>
          <v-alert
            :value="true"
            color="error"
            icon="warning"
          >Your search for "{{ search }}" found no results.</v-alert>
        </template>
      </v-data-table>
    </v-card-text>
  </v-card>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'admin-clients-view',
  metaInfo () {
    return { title: this.$t('clients') }
  },
  data: () => ({
    search: '',
    busy: false,
    dialog: false,
    headers: [
      { text: 'Name', align: 'left', value: 'name' },
      { text: 'Email', value: 'user.email' },
      { text: 'Phone', value: 'phone' },
      { text: 'Address', value: 'address' },
      { text: 'Actions', value: 'name', sortable: false }
    ],
    editedIndex: -1,
    editedItem: {
      name: '',
      phone: '',
      user: {
        email: ''
      },
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
        v => /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(v) || 'E-mail must be valid'
      ],
      address: [
        v => !!v || 'Address is required'
      ]
    }
  }),

  computed: {
    formTitle () {
      return this.editedIndex === -1 ? 'New' : 'Edit'
    },
    ...mapGetters([
      'clients'
    ])
  },

  watch: {
    dialog (val) {
      val || this.close()
    }
  },

  methods: {

    editItem (item) {
      this.editedIndex = this.clients.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialog = true
    },

    async deleteItem (client) {
      var r = confirm('Are you sure you want to delete this item?')
      if (r) {
        this.busy = true
        await this.$store.dispatch('deleteClient', client)
        this.busy = false
        this.$store.dispatch('responseMessage', {
          type: 'success',
          text: 'Successfully Removed Client'
        })
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
        await this.$store.dispatch('updateClient', this.editedItem)
        this.busy = false
        this.$store.dispatch('responseMessage', {
          type: 'success',
          text: 'Successfully Edit Client'
        })
      } else {
        var newItem = Object.assign({}, this.editedItem)
        var otherDetail = {
          email: newItem.user.email,
          password: '123456789',
          password_confirmation: '123456789'
        }
        Object.assign(newItem, otherDetail)
        this.busy = true
        await this.$store.dispatch('createClient', newItem)
        this.busy = false
        this.$store.dispatch('responseMessage', {
          type: 'success',
          text: 'Successfully Add New Client'
        })
      }
      this.close()
    }
  }
}
</script>
