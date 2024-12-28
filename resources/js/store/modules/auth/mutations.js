export default {
    SET_USER(state, user) {
        state.user = user;
        state.isAuthenticated = !!user;
    },
    CLEAR_USER(state) {
        state.user = null;
        state.isAuthenticated = false;
    }
}
