import axios from 'axios'
import * as types from '../mutation-types'

// state
export const state = {
  company: null
}

// mutations
export const mutations = {

  [types.FETCH_COMPANY] (state, { company }) {
    state.company = company
  },
  [types.UPDATE_COMPANY] (state, employees) {
    // const index = state.clients.indexOf(item => item.id === client.id)
    // state.clients = Object.assign([...state.clients], { [index]: client })
  },
  [types.CLEAR_COMPANY] (state) {
    state.company = null
  }

}

// actions
export const actions = {
  async fetchCompany ({ commit }) {
    const { data } = await axios.get('/api/company/' + 1)
    commit(types.FETCH_COMPANY, { company: data })
  },
  async updateCompany ({ commit }, company) {
    const { data } = await axios.put('/api/compan/' + 1, company)
    commit(types.UPDATE_EMPLOYEE, { company: data })
  }
}

// getters
export const getters = {
  companyDetail: state => state.company
}
