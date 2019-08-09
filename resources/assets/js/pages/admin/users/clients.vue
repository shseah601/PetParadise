<template>
  <v-card>
    <progress-bar :show="busy"></progress-bar>
    <v-card-title class="grey lighten-4">
      <h3 class="headline mb-0">{{ $t('clients') }}</h3>
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
                  <v-flex xs12 sm6 md6>
                    <v-text-field v-model="editedItem.name" :rules="rules.name" label="Client name" required></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm6 md6>
                    <v-text-field v-model="editedItem.phone" label="Phone" required></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm12 md12>
                    <v-text-field
                      v-model="editedItem.user.email"
                      :readonly="editedIndex != -1"
                      label="Email"
                      required
                    ></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm12 md12>
                    <v-text-field v-model="editedItem.address" label="Address" required></v-text-field>
                  </v-flex>
                </v-layout>
              </v-container>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn :disabled="busy" color="blue darken-1" flat @click="close">Cancel</v-btn>
              <v-btn
                :loading="busy"
                :disabled="!formIsValid || busy"
                color="blue darken-1"
                flat
                type="submit"
                @click="save"
              >Save</v-btn>
            </v-card-actions>
          </v-form>
        </v-card>
      </v-dialog>
    </v-card-title>
    <v-card-text>
      <v-data-table :headers="headers" :items="clients" class="elevation-1">
        <template v-slot:items="props">
          <td>{{ props.item.name }}</td>
          <td class="text-xs-left">{{ props.item.phone }}</td>
          <td class="text-xs-left">{{ props.item.user.email }}</td>
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
  name: 'clients-view',
  metaInfo () {
    return { title: 'Clients' }
  },
  data: () => ({
    busy: false,
    dialog: false,
    headers: [
      { text: 'Name', align: 'left', value: 'name' },
      { text: 'Phone', value: 'phone' },
      { text: 'Email', value: 'email' },
      { text: 'Address', value: 'address' },
      { text: 'Actions', value: 'name', sortable: false }
    ],
    clients: [],
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
      name: [val => (val || '').length > 0 || 'This field is required'],
      phone: [val => (val || '').length > 0 || 'This field is required']
    }
  }),

  computed: {
    formTitle () {
      return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
    },
    ...mapGetters({
      allClients: 'clients'
    }),
    formIsValid () {
      return (
        this.form.first &&
        this.form.last &&
        this.form.favoriteAnimal &&
        this.form.terms
      )
    }
  },

  watch: {
    dialog (val) {
      val || this.close()
    }
  },

  created () {
    this.$store.dispatch('fetchClients')
    this.initialize()
  },

  methods: {
    async initialize () {
      this.clients = this.allClients.clients.data
      console.log(this.clients)
    },

    editItem (item) {
      this.editedIndex = this.clients.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialog = true
    },

    async deleteItem (item) {
      const index = this.clients.indexOf(item)
      var r = confirm('Are you sure you want to delete this item?') && this.clients.splice(index, 1)
      if (r) {
        console.log('delete')
        this.busy = true
        await this.$store.dispatch('deleteClient', item)
        this.busy = false
      } else {

      }
    },

    close () {
      this.dialog = false
      setTimeout(() => {
        this.editedItem = Object.assign({}, this.defaultItem)
        this.editedIndex = -1
      }, 300)
    },

    async save () {
      if (this.editedIndex > -1) {
        this.busy = true
        await this.$store.dispatch('updateClient', this.editedItem)
        this.busy = false
        Object.assign(this.clients[this.editedIndex], this.editedItem)
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
        this.clients.push(this.editedItem)
        console.log(this.$store.getters.clients)
      }
      this.close()
    }
  }
}
</script>
