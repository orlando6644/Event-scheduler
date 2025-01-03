import axios from 'axios';

export default {
    async login({ commit }, credentials) {
        try {
            await axios.get('/sanctum/csrf-cookie');
            const { data } = await axios.post('/api/login', credentials);
            commit('SET_USER', data.data.user);
        } catch (error) {
            let errors = '';

            if(error.response.status === 422) {
                const validationErrors = error.response.data.errors || {};
                errors = Object.values(validationErrors)[0][0] || 'Login failed';
            } else {
                errors = error.response.data.message || 'An error occurred. Please try again.';
            }

            throw new Error(errors);
        }
    },
    async logout({ commit }) {
        try {
            await axios.post('/api/logout');
            commit('CLEAR_USER');
        } catch (error) {
            console.error('Logged out failed', error);
        }
    },
    async fetchUser({ commit }) {
        try {
          const { data } = await axios.get('/api/user');
          commit('SET_USER', data.data);
        } catch (error) {
          commit('CLEAR_USER');
        }
    },
}
