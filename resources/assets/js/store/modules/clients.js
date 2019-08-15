import axios from 'axios'
import * as types from '../mutation-types'

// state
export const state = {
  client: null,
  clients: []
}

// mutations
export const mutations = {
  [types.CREATE_CLIENT] (state, { client }) {
    state.clients.data.push(client)
  },
  [types.FETCH_CLIENTS] (state, { clients }) {
    state.clients = clients
  },
  [types.FETCH_CLIENT] (state, { client }) {
    state.client = client
  },
  [types.UPDATE_CLIENT] (state, { client }) {
    const index = state.clients.data.findIndex(item => item.id === client.data.id)
    state.clients.data = Object.assign([...state.clients.data], { [index]: client.data })
  },
  [types.DELETE_CLIENT] (state, { client }) {
    const index = state.clients.data.findIndex(item => item.id === client.data.id)
    state.clients.data.splice(index, 1)
  },
  [types.CLEAR_CLIENTS] (state) {
    state.client = null
    state.clients = null
  }

}

// actions
export const actions = {
  async createClient ({ commit }, client) {
    const { data } = await axios.post('/api/clients', client)
    commit(types.CREATE_CLIENT, { client: data })
  },
  async fetchClients ({ commit }) {
    const { data } = await axios.get('/api/clients')
    commit(types.FETCH_CLIENTS, { clients: data })
  },
  async fetchClient ({ commit }, client) {
    const { data } = await axios.get('/api/clients/' + client.id)
    commit(types.FETCH_CLIENT, { client: data })
  },
  async updateClient ({ commit }, client) {
    const { data } = await axios.put('/api/clients/' + client.id, client)
    commit(types.UPDATE_CLIENT, { client: data })
  },
  async deleteClient ({ commit }, client) {
    const { data } = await axios.delete('/api/clients/' + client.id, client)
    commit(types.DELETE_CLIENT, { client: data })
  }
}

// getters
export const getters = {
  clients: state => state.clients.data,
  client: state => state.client.data
}
