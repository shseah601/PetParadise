import axios from 'axios'
import * as types from '../mutation-types'

// state
export const state = {
  employee: null,
  employees: null
}

// mutations
export const mutations = {
  [types.CREATE_EMPLOYEE] (state, { employee }) {
    state.employees.data.push(employee)
  },
  [types.FETCH_EMPLOYEES] (state, { employees }) {
    state.employees = employees
  },
  [types.FETCH_EMPLOYEE] (state, { employee }) {
    state.employee = employee
  },
  [types.UPDATE_EMPLOYEE] (state, { employee }) {
    const index = state.employees.data.findIndex(item => item.id === employee.data.id)
    state.employees.data = Object.assign([...state.employees.data], { [index]: employee.data })
  },
  [types.DELETE_EMPLOYEE] (state, { employee }) {
    const index = state.employees.data.findIndex(item => item.id === employee.data.id)
    state.employees.data.splice(index, 1)
  },
  [types.CLEAR_EMPLOYEES] (state) {
    state.employee = null
    state.employees = null
  }

}

// actions
export const actions = {
  async createEmployee ({ commit }, employee) {
    const { data } = await axios.post('/api/employees', employee)
    commit(types.CREATE_EMPLOYEE, { employee: data })
  },
  async fetchEmployees ({ commit }) {
    const { data } = await axios.get('/api/employees')
    commit(types.FETCH_EMPLOYEES, { employees: data })
  },
  async fetchEmployee ({ commit }, employee) {
    const { data } = await axios.get('/api/employees/' + employee.id)
    commit(types.FETCH_EMPLOYEE, { employee: data })
  },
  async updateEmployee ({ commit }, employee) {
    const { data } = await axios.put('/api/employees/' + employee.id, employee)
    commit(types.UPDATE_EMPLOYEE, { employee: data })
  },
  async deleteEmployee ({ commit }, employee) {
    const { data } = await axios.delete('/api/employees/' + employee.id, employee)
    commit(types.DELETE_EMPLOYEE, { employee: data })
  }
}

// getters
export const getters = {
  employees: state => state.employees.data,
  employee: state => state.employee
}
