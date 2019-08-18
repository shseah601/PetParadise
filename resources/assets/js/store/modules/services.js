import axios from 'axios'
import * as types from '../mutation-types'

// state
export const state = {
  service: null,
  services: null
}

// mutations
export const mutations = {
  [types.CREATE_SERVICE] (state, { service }) {
    state.services.data.push(service)
  },
  [types.FETCH_SERVICES] (state, { services }) {
    state.services = services
  },
  [types.FETCH_SERVICE] (state, { service }) {
    state.service = service
  },
  [types.UPDATE_SERVICE] (state, { service }) {
    const index = state.services.data.findIndex(item => item.id === service.data.id)
    state.services.data = Object.assign([...state.services.data], { [index]: service.data })
  },
  [types.DELETE_SERVICE] (state, { service }) {
    const index = state.services.data.findIndex(item => item.id === service.data.id)
    state.services.data.splice(index, 1)
  },
  [types.CLEAR_SERVICES] (state) {
    state.service = null
    state.services.data = []
  }

}

// actions
export const actions = {
  async createService ({ commit }, service) {
    const { data } = await axios.post('/api/services', service)
    commit(types.CREATE_SERVICE, { service: data })
  },
  async fetchServices ({ commit }) {
    const { data } = await axios.get('/api/services')
    commit(types.FETCH_SERVICES, { services: data })
  },
  async fetchService ({ commit }, service) {
    const { data } = await axios.get('/api/services/' + service.id)
    commit(types.FETCH_SERVICE, { service: data })
  },
  async updateService ({ commit }, service) {
    const { data } = await axios.put('/api/services/' + service.id, service)
    commit(types.UPDATE_SERVICE, { service: data })
  },
  async deleteService ({ commit }, service) {
    const { data } = await axios.delete('/api/services/' + service.id, service)
    commit(types.DELETE_SERVICE, { service: data })
  }
}

// getters
export const getters = {
  services: state => state.services.data,
  service: state => state.service
}
