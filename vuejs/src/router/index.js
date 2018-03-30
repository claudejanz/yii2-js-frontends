import Vue from 'vue'
import Home from '@/components/Home'
import Register from '@/components/Register'
import Login from '@/components/Login'
import TopicCreate from '@/components/topics/TopicCreate'
import TopicView from '@/components/topics/TopicView'
import PostView from '@/components/posts/PostView'

import Router from 'vue-router'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home
    },
    {
      path: '/register',
      name: 'register',
      component: Register
    },
    {
      path: '/login',
      name: 'login',
      component: Login
    },
    {
      path: '/topics/create',
      name: 'topics-create',
      component: TopicCreate
    },
    {
      path: '/topics/view/:id',
      name: 'topics-view',
      component: TopicView
    },
    {
      path: '/posts/view/:id',
      name: 'posts-view',
      component: PostView
    }
  ]
})
