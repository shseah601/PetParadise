import axios from 'axios'
import * as types from '../mutation-types'

// state
export const state = {
  booking: null,
  bookings: null
}

// mutations
export const mutations = {
  [types.CREATE_BOOKING] (state, { booking }) {
    state.bookings.data.push(booking)
  },
  [types.FETCH_BOOKINGS] (state, { bookings }) {
    state.bookings = bookings
  },
  [types.FETCH_BOOKING] (state, { booking }) {
    state.booking = booking
  },
  [types.UPDATE_BOOKING] (state, { booking }) {
    const index = state.bookings.data.findIndex(item => item.id === booking.data.id)
    state.bookings.data = Object.assign([...state.bookings.data], { [index]: booking.data })
  },
  [types.UPDATE_BOOKING_MENU] (state, { booking }) {
    
  },
  [types.CLEAR_BOOKINGS] (state) {
    state.booking = null
    state.bookings = null
    state.groomingBookings = null
    state.boardingBookings = null
  }

}

// actions
export const actions = {
  async createBooking ({ commit }, booking) {
    const { data } = await axios.post('/api/bookings', booking)
    commit(types.CREATE_BOOKING, { booking: data })
  },
  async fetchBookings ({ commit }) {
    const { data } = await axios.get('/api/bookings')
    commit(types.FETCH_BOOKINGS, { bookings: data })
  },
  async fetchBooking ({ commit }, booking) {
    const { data } = await axios.get('/api/bookings/' + booking.id)
    commit(types.FETCH_BOOKING, { booking: data })
  },
  async updateBooking ({ commit }, booking) {
    const { data } = await axios.put('/api/bookings/' + booking.id, booking)
    commit(types.UPDATE_BOOKING, { booking: data })
  }
}

// getters
export const getters = {
  bookings: state => state.bookings.data,
  booking: state => state.booking
}
