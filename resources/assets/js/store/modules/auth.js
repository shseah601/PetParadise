import axios from 'axios'
import Cookies from 'js-cookie'
import * as types from '../mutation-types'

// state
export const state = {
  user: null,
  role: null,
  detail: null,
  loaded: null,
  token: Cookies.get('token')
}

// mutations
export const mutations = {
  [types.SAVE_TOKEN] (state, { token, remember }) {
    state.token = token
    Cookies.set('token', token, { expires: remember ? 365 : null })
  },

  [types.FETCH_USER_SUCCESS] (state, { user }) {
    state.user = user
    if (user.admin) {
      state.role = { name: 'admin' }
      state.detail = user.admin
    } else if (user.employee) {
      state.role = { name: 'employee' }
      state.detail = user.employee
    } else {
      state.role = { name: 'client' }
      state.detail = user.client
    }
  },

  [types.FETCH_USER_FAILURE] (state) {
    state.token = null
    Cookies.remove('token')
  },

  [types.LOGOUT] (state) {
    state.user = null
    state.token = null
    state.role = null
    state.detail = null
    state.loaded = null

    Cookies.remove('token')
  },

  [types.UPDATE_USER] (state, { user }) {
    state.user = user
  },

  [types.UPDATE_LOADED] (state, loaded) {
    state.loaded = loaded
  }
}

// actions
export const actions = {
  saveToken ({ commit, dispatch }, payload) {
    commit(types.SAVE_TOKEN, payload)
  },

  async fetchUser ({ commit }) {
    try {
      const { data } = await axios.get('/api/user')
      commit(types.FETCH_USER_SUCCESS, { user: data })
    } catch (e) {
      commit(types.FETCH_USER_FAILURE)
    }
  },

  async updateUser ({ commit }, payload) {
    commit(types.UPDATE_USER, payload)
  },

  async dataLoaded ({ commit }, payload) {
    commit(types.UPDATE_LOADED, payload)
  },

  async logout ({ commit }) {
    try {
      await axios.post('/api/logout')
    } catch (e) { }

    commit(types.LOGOUT)
    commit(types.CLEAR_CLIENTS)
    commit(types.CLEAR_EMPLOYEES)
    commit(types.CLEAR_COMPANY)
    commit(types.CLEAR_WORKINGHOURS)
    commit(types.CLEAR_PETS)
    commit(types.CLEAR_BOOKINGS)
    commit(types.CLEAR_PENDING_BOOKINGS)
    commit(types.CLEAR_SERVICES)
  },

  async clientLogout ({ commit }) {
    try {
      await axios.post('/api/logout')
    } catch (e) { }

    commit(types.LOGOUT)
    commit(types.CLEAR_CLIENTS)
    commit(types.CLEAR_COMPANY)
    commit(types.CLEAR_WORKINGHOURS)
    commit(types.CLEAR_PETS)
    commit(types.CLEAR_BOOKINGS)
    commit(types.CLEAR_PENDING_BOOKINGS)
    commit(types.CLEAR_SERVICES)
  }
}

// getters
export const getters = {
  authUser: state => state.user,
  authToken: state => state.token,
  authCheck: state => state.user !== null,
  authRole: state => state.role,
  authDetail: state => state.detail,
  authLoaded: state => state.loaded
}
