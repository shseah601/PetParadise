<template>
  <v-card>
    <progress-bar :show="busy"></progress-bar>
    <v-card-title class="grey lighten-4">
      <h3 class="headline mb-0">{{ $t('pets') }}</h3>
      <v-spacer></v-spacer>
      <v-text-field v-model="search" append-icon="search" label="Search" single-line hide-details></v-text-field>
    </v-card-title>
    <v-card-text>
      <v-data-table :headers="headers" :items="pets" :search="search" class="elevation-1">
        <template v-slot:items="props">
          <td>{{ props.item.name }}</td>
          <td class="text-xs-left">{{ props.item.type }}</td>
          <td class="text-xs-left">{{ props.item.gender }}</td>
          <td class="text-xs-left">{{ props.item.age }}</td>
          <td class="text-xs-left">{{ props.item.client.name }}</td>
          <td class="justify-center layout px-0">
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
  name: 'admin-pets-view',
  metaInfo () {
    return { title: this.$t('pets') }
  },
  data: () => ({
    search: '',
    busy: false,
    dialog: false,
    headers: [
      { text: 'Name', align: 'left', value: 'name' },
      { text: 'Type', value: 'type' },
      { text: 'Gender', value: 'gender' },
      { text: 'Age', value: 'age' },
      { text: 'Owner', value: 'client.name' },
      { text: 'Actions', value: 'name', sortable: false }
    ]
  }),

  computed: {
    formTitle () {
      return this.editedIndex === -1 ? 'New' : 'Edit'
    },
    ...mapGetters([
      'pets'
    ])
  },

  watch: {
    dialog (val) {
      val || this.close()
    }
  },

  methods: {
    editItem (item) {
      this.editedIndex = this.pets.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialog = true
    },

    async deleteItem (pet) {
      var r = confirm('Are you sure you want to delete this item?')
      if (r) {
        this.busy = true
        await this.$store.dispatch('deletePet', pet)
        this.busy = false
        this.$store.dispatch('responseMessage', {
          type: 'success',
          text: 'Successfully Deleted Pet'
        })
      } else {

      }
    }
  }
}
</script>
