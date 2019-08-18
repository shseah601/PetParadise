<template>
  <v-card>
    <progress-bar :show="busy"></progress-bar>
    <v-card-title class="grey lighten-4">
      <h3 class="headline mb-0">{{ $t('services') }}</h3>
      <v-spacer></v-spacer>
      <v-text-field v-model="search" append-icon="search" label="Search" single-line hide-details></v-text-field>
      <v-spacer></v-spacer>
      <v-dialog v-model="dialog" max-width="500px">
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
                      label="Service Name"
                      required
                    ></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm12 md12>
                    <v-text-field
                      v-model="editedItem.type"
                      :rules="rules.type"
                      label="Type"
                      required
                    ></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm12 md12>
                    <v-text-field
                      v-model.number="editedItem.price_min"
                      :rules="rules.price_min"
                      ref="price_min"
                      type="number"
                      prefix="RM"
                      label="Minimum Price"
                      required
                    ></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm12 md12>
                    <v-text-field
                      v-model.number="editedItem.price_max"
                      :rules="rules.price_max"
                      ref="price_max"
                      type="number"
                      prefix="RM"
                      label="Maximum Price"
                      required
                    ></v-text-field>
                  </v-flex>
                  <v-flex v-if="editedItem.duration > -1" xs12 sm12 md12>
                    <v-text-field
                      v-model.number="editedItem.duration"
                      :rules="rules.duration"
                      type="number"
                      label="Duration"
                      min="1"
                      required
                    ></v-text-field>
                  </v-flex>
                  <v-flex v-if="editedItem.capacity > -1" xs12 sm12 md12>
                    <v-text-field
                      v-model.number="editedItem.capacity"
                      :rules="rules.capacity"
                      type="number"
                      label="Capacity"
                      min="1"
                      required
                    ></v-text-field>
                  </v-flex>
                  <v-flex v-show="false" xs12 sm12 md12>
                    <v-text-field
                      v-model="editedItem.image"
                      :rules="rules.image"
                      label="Image"
                      required
                    ></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm12 md12>
                    <v-textarea
                      v-model="editedItem.description"
                      :rules="rules.description"
                      label="Description"
                      required
                    ></v-textarea>
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
      <v-data-table :headers="headers" :items="services" :search="search" class="elevation-1">
        <template v-slot:items="props">
          <td>{{ props.item.name }}</td>
          <td class="text-xs-left">{{ props.item.type }}</td>
          <td class="text-xs-left">RM {{ props.item.price_min }}</td>
          <td class="text-xs-left">RM {{ props.item.price_max }}</td>
          <td class="text-xs-left">{{ props.item.duration ? props.item.duration : '-' }}</td>
          <td class="text-xs-left">{{ props.item.capacity ? props.item.capacity : '-' }}</td>
          <td class="text-xs-left">{{ props.item.description }}</td>
          <td class="justify-center layout px-0">
            <v-icon small class="mr-2" @click="editItem(props.item)">edit</v-icon>
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
  name: 'admin-services-view',
  metaInfo () {
    return { title: this.$t('services') }
  },
  data: () => ({
    search: '',
    busy: false,
    dialog: false,
    price_min_error: null,
    price_max_error: null,
    headers: [
      { text: 'Name', align: 'left', value: 'name' },
      { text: 'Type', value: 'type' },
      { text: 'Price Mininum', value: 'price_min' },
      { text: 'Price Maximum', value: 'price_max' },
      { text: 'Duration (hour)', value: 'duration' },
      { text: 'Capacity (pets)', value: 'capacity' },
      { text: 'Description', value: 'description' },
      { text: 'Actions', value: 'name', sortable: false }
    ],
    editedIndex: -1,
    editedItem: {
      name: '',
      type: '',
      price_min: 0,
      price_max: 0,
      duration: 1,
      capacity: 1,
      description: '',
      image: ''
    },
    defaultItem: {
      name: '',
      type: '',
      price_min: 0,
      price_max: 0,
      duration: 1,
      capacity: 1,
      description: '',
      image: ''
    },
    form: Object.assign({}, this.defaultItem),
    rules: {
      name: [
        v => !!v || 'Name is required',
        v => (v && v.length <= 100) || 'Name must be less than 100 characters'
      ],
      type: [
        v => !!v || 'Type is required'
      ],
      price_min: [
        v => !!v || 'Minimum Price is required'
      ],
      price_max: [
        v => !!v || 'Maximum Price is required'
      ],
      description: [
        v => !!v || 'Description is required'
      ]
    }
  }),

  computed: {
    formTitle () {
      return this.editedIndex === -1 ? 'New' : 'Edit'
    },
    ...mapGetters([
      'services'
    ])
  },

  watch: {
    dialog (val) {
      val || this.close()
    }
  },

  methods: {
    editItem (item) {
      this.editedIndex = this.services.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialog = true
    },

    async deleteItem (service) {
      var r = confirm('Are you sure you want to delete this item?')
      if (r) {
        this.busy = true
        await this.$store.dispatch('deleteService', service)
        this.busy = false
        console.log('service deleted', service)
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
      this.editedItem.price_min = parseFloat(this.editedItem.price_min)
      this.editedItem.price_max = parseFloat(this.editedItem.price_max)

      if (this.editedIndex > -1) {
        this.busy = true
        await this.$store.dispatch('updateService', this.editedItem)
        this.busy = false
      } else {
        var newItem = Object.assign({}, this.editedItem)
        this.busy = true
        await this.$store.dispatch('createService', newItem)
        this.busy = false
      }
      this.close()
    }
  }
}
</script>
