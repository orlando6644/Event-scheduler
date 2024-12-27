import { createStore } from 'vuex';
import axios from 'axios';

export default createStore({
  state: {
    user: null,
    token: localStorage.getItem('token') || '',
  },
  mutations: {
    SET_USER(state, user) {
      state.user = user;
    },
    SET_TOKEN(state, token) {
      state.token = token;
      localStorage.setItem('token', token);
    },
    LOGOUT(state) {
      state.user = null;
      state.token = '';
      localStorage.removeItem('token');
    }
  },
  actions: {
    async login({ commit }, credentials) {
      try {
        const response = await axios.post('/api/login', credentials);
        const token = response.data.token;
        commit('SET_TOKEN', token);

        const userResponse = await axios.get('/api/user', {
          headers: {
            Authorization: `Bearer ${token}`
          }
        });
        commit('SET_USER', userResponse.data);
      } catch (error) {
        console.error('Login error:', error);
      }
    },
    logout({ commit }) {
      commit('LOGOUT');
    }
  },
  getters: {
    isAuthenticated(state) {
      return !!state.token && !!state.user;
    }
  }
});
