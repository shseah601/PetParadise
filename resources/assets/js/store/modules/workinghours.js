import axios from 'axios'
import * as types from '../mutation-types'

// state
export const state = {
  workinghours: null
}

// mutations
export const mutations = {
  [types.FETCH_WORKINGHOURS] (state, { workinghours }) {
    state.workinghours = workinghours
  },
  [types.UPDATE_WORKINGHOURS] (state, { workinghours }) {
    state.workinghours = workinghours
  },
  [types.CLEAR_WORKINGHOURS] (state) {
    state.workinghours = null
  }

}

// actions
export const actions = {
  async fetchWorkingHours ({ commit }) {
    const { data } = await axios.get('/api/workinghours')
    commit(types.FETCH_WORKINGHOURS, { workinghours: data })
  },
  async updateWorkingHours ({ commit }, workinghours) {
    const { data } = await axios.post('/api/updateWorkingHours', workinghours)
    commit(types.UPDATE_WORKINGHOURS, { workinghours: data })
  }
}

// getters
export const getters = {
  allWorkingHours: state => state.workinghours
}
