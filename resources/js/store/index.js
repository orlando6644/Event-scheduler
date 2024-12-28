import { createStore } from 'vuex'
import auth from './modules/auth'

/**
 * Create a new Vuex Store instance.
 * The store has been divided into modules for better organization.
 * In case that we want to add more modules, we can add them here.
 */

const store = createStore({
    modules: {
        auth,
    }
})

export default store
