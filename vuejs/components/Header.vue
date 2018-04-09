<template>
    <v-toolbar dark fixed v-bind:class="$store.state.colorHeader">
      <v-toolbar-title>
         <img src="../assets/logo.png" class="logo">
      </v-toolbar-title>
      <v-toolbar-items>
        <v-btn v-for="topic in $store.state.topics.models" flat :to='{name:"topics-id",params:{"id":topic.id}}' :key='topic.id'>{{topic.title}}</v-btn>
      </v-toolbar-items>
      <v-spacer></v-spacer>
      <v-toolbar-items>
        <v-btn flat :to="{name: 'topics-create'}">Create</v-btn>
        <v-btn v-for="link in $store.state.links" flat :to='{name:link.to}' :key='link.to' v-if='link.visible'>{{link.text}}</v-btn>
        <v-btn flat @click='logout' v-if='$store.state.user'>Logout</v-btn>
      </v-toolbar-items>
    </v-toolbar>
</template>
<script>
export default {
  data () {
    return {
    }
  },
  methods: {
    logout () {
      this.$store.dispatch('setUser', null)
      this.$router.push({name: 'index'})
    }
  }
}
</script>
<style scoped>
.logo{
  height:2em;
  margin-right:1rem;
  vertical-align: middle;
}
</style>
