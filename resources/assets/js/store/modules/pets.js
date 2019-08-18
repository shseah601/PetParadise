import axios from 'axios'
import * as types from '../mutation-types'

// state
export const state = {
  pet: null,
  pets: null
}

// mutations
export const mutations = {
  [types.CREATE_PET] (state, { pet }) {
    state.pets.data.push(pet.data)
  },
  [types.FETCH_PETS] (state, { pets }) {
    state.pets = pets
  },
  [types.FETCH_PET] (state, { pet }) {
    state.pet = pet
  },
  [types.UPDATE_PET] (state, { pet }) {
    const index = state.pets.data.findIndex(item => item.id === pet.data.id)
    state.pets.data = Object.assign([...state.pets.data], { [index]: pet.data })
  },
  [types.DELETE_PET] (state, { pet }) {
    const index = state.pets.data.findIndex(item => item.id === pet.data.id)
    state.pets.data.splice(index, 1)
  },
  [types.CLEAR_PETS] (state) {
    state.pet = null
    state.pets.data = []
  },
  [types.FETCH_CLIENT_PETS] (state, { pets }) {
    state.pets = pets
  }

}

// actions
export const actions = {
  async createPet ({ commit }, pet) {
    const { data } = await axios.post('/api/pets', pet)
    commit(types.CREATE_PET, { pet: data })
  },
  async fetchPets ({ commit }) {
    const { data } = await axios.get('/api/pets')
    commit(types.FETCH_PETS, { pets: data })
  },
  async fetchPet ({ commit }, pet) {
    const { data } = await axios.get('/api/pets/' + pet.id)
    commit(types.FETCH_PET, { pet: data })
  },
  async updatePet ({ commit }, pet) {
    const { data } = await axios.put('/api/pets/' + pet.id, pet)
    commit(types.UPDATE_PET, { pet: data })
  },
  async deletePet ({ commit }, pet) {
    const { data } = await axios.delete('/api/pets/' + pet.id, pet)
    commit(types.DELETE_PET, { pet: data })
  },
  async fetchClientPets ({ commit }, clientId) {
    const { data } = await axios.get('/api/clientPets/' + clientId)
    commit(types.FETCH_CLIENT_PETS, { pets: data })
  }
}

// getters
export const getters = {
  pets: state => state.pets.data,
  pet: state => state.pet
}
