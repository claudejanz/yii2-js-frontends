import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  strict: true,
  state: {
    token: null,
    user: null,
    isUserLoggedIn: false,
    colorHeader: 'blue',
    links: [
      {text: 'Login', to: 'login', visible: true},
      {text: 'Register', to: 'register', visible: true}
    ]
  },
  mutations: {
    setUser (state, user) {
      state.user = user
      state.token = (user)?user.access_token:null
      state.links = [
        {text: 'Login', to: 'login', visible: !user},
        {text: 'Register', to: 'register', visible: !user}
      ]
    }
  },
  actions: {
    setUser ({commit}, user) {
      commit('setUser', user)
    }
  }

})
