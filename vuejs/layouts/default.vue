<template>
  <div>
    <v-app>
      <v-content>
        <v-container>
          <page-header/>
          <nuxt/>
        </v-container>
      </v-content>
    </v-app>
  </div>
</template>
<script>
import PageHeader from '@/components/Header'
import {Topics} from '@/models/Topic'
import {User, Users} from '@/models/User'
export default {
  name: 'App',
  components: {
    PageHeader
  },
  async created (){
    let topics = new Topics()
    await topics.fetch()
    this.$store.commit('setTopics', topics)
    const users = new Users()
    await users.fetch()
    this.$store.commit('setUsers', users)
  }
}
</script>
<style>

</style>
