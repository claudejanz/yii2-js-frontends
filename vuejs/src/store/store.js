import Vue from 'vue'
import Vuex from 'vuex'

import TopicServices from '@/services/TopicServices'
import UserServices from '@/services/UserServices'

import {Topics} from '@/models/Topic'
import {User, Users} from '@/models/User'

Vue.use(Vuex)

export default new Vuex.Store({
  strict: true,
  state: {
    token: null,
    user: null,
    users: null,
    colorHeader: 'blue',
    links: [
      {text: 'Login', to: 'login', visible: true},
      {text: 'Register', to: 'register', visible: true}
    ],
    topics: []
  },
  computed: {
    isGuest: function () {
      return !this.user
    },
    token: function () {
      return (this.user) ? this.user.token : false
    }
  },
  mutations: {
    setUser (state, user) {
      state.user = new User(user)
      state.links = [
        {text: 'Login', to: '/login', visible: !user},
        {text: 'Register', to: '/register', visible: !user}
      ]
    },
    setTopics (state, topics) {
      state.topics = topics
    },
    setUsers (state, users) {
      state.users = users
    }
  },
  actions: {
    setUser ({commit}, user) {
      commit('setUser', user)
    },
    async getTopics ({commit}) {
      const response = await TopicServices.index()
      commit('setTopics', response.data)
    },
    async init ({commit}) {
      let topics = new Topics()
      await topics.fetch()
      commit('setTopics', topics)
      const users = new Users()
      await users.fetch()
      commit('setUsers', users)
      return true
    }
  }
})
