import {Topics} from '@/models/Topic'
import {User, Users} from '@/models/User'

export const state = () => ({
  user: null,
  users: null,
  token: null,
  colorHeader: 'indigo',
  links: [
    {text: 'Login', to: 'login', visible: true},
    {text: 'Register', to: 'register', visible: true}
  ],
  topics: null
});
export const computed = {
  isGuest: function () {
    return !this.user
  },
  token: function () {
    return (this.user) ? this.user.token : false
  }
}
export const mutations= {
  setUser (state, user) {
    state.user = (user != null ) ? new User(user): null
    state.links = [
      {text: 'Login', to: 'login', visible: !user},
      {text: 'Register', to: 'register', visible: !user}
    ]
  },
  setTopics (state, topics) {
    state.topics = topics
  },
  setUsers (state, users) {
    state.users = users
  }
}
export const actions= {
  setUser ({commit}, user) {
    this.commit('setUser', user)
  },
  async getTopics ({commit}) {
    let topics = new Topics()
    await topics.fetch()
    this.commit('setTopics', topics)
  },
  async nuxtServerInit ({ dispatch }) {
    let topics = new Topics()
    await topics.fetch()
    this.commit('setTopics', topics)
    const users = new Users()
    await users.fetch()
    this.commit('setUsers', users)
    // await dispatch('core/load')
  }
}
