import axios from 'axios'
import * as types from '../mutation-types'

// state
export const state = {
  pendingBooking: null,
  pendingBookings: null
}

// mutations
export const mutations = {
  [types.CREATE_PENDING_BOOKING] (state, { pendingBooking }) {
    state.pendingBookings.data.push(pendingBooking)
  },
  [types.FETCH_PENDING_BOOKINGS] (state, { pendingBookings }) {
    state.pendingBookings = pendingBookings
  },
  [types.FETCH_PENDING_BOOKING] (state, { pendingBooking }) {
    state.pendingBooking = pendingBooking
  },
  [types.UPDATE_PENDING_BOOKING] (state, { pendingBooking }) {
    const index = state.pendingBookings.data.findIndex(item => item.id === pendingBooking.data.id)
    state.pendingBookings.data = Object.assign([...state.pendingBookings.data], { [index]: pendingBooking.data })
  },
  [types.DELETE_PENDING_BOOKING] (state, { pendingBooking }) {
    const index = state.pendingBookings.data.findIndex(item => item.id === pendingBooking.data.id)
    state.pendingBookings.data.splice(index, 1)
  },
  [types.CLEAR_PENDING_BOOKINGS] (state) {
    state.pendingBooking = null
    state.pendingBookings = null
    state.groomingBookings = null
    state.boardingBookings = null
  },
  [types.FETCH_CLIENT_PENDING_BOOKINGS] (state, { pendingBookings }) {
    state.pendingBookings = pendingBookings
  }

}

// actions
export const actions = {
  async createPendingBooking ({ commit }, pendingBooking) {
    const { data } = await axios.post('/api/pendingBookings', pendingBooking)
    commit(types.CREATE_PENDING_BOOKING, { pendingBooking: data })
  },
  async fetchPendingBookings ({ commit }) {
    const { data } = await axios.get('/api/pendingBookings')
    commit(types.FETCH_PENDING_BOOKINGS, { pendingBookings: data })
  },
  async fetchPendingBooking ({ commit }, pendingBooking) {
    const { data } = await axios.get('/api/pendingBookings/' + pendingBooking.id)
    commit(types.FETCH_PENDING_BOOKING, { pendingBooking: data })
  },
  async updatePendingBooking ({ commit }, pendingBooking) {
    const { data } = await axios.put('/api/pendingBookings/' + pendingBooking.id, pendingBooking)
    commit(types.UPDATE_PENDING_BOOKING, { pendingBooking: data })
  },
  async deletePendingBooking ({ commit }, pendingBooking) {
    const { data } = await axios.delete('/api/pendingBookings/' + pendingBooking.id, pendingBooking)
    commit(types.DELETE_PENDING_BOOKING, { pendingBooking: data })
  },
  async fetchClientPendingBookings ({ commit }, clientId) {
    const { data } = await axios.get('/api/clientPendingBookings/' + clientId)
    commit(types.FETCH_CLIENT_PENDING_BOOKINGS, { pendingBookings: data })
  }
}

// getters
export const getters = {
  pendingBookings: state => state.pendingBookings.data,
  pendingBooking: state => state.pendingBooking
}
