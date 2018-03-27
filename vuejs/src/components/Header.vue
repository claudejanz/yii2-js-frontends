<template>
  <v-toolbar dark fixed v-bind:class="$store.state.colorHeader">
    <v-toolbar-title>
    <v-toolbar-items>
      <v-btn flat :to='home'>
      Application
      </v-btn>
    </v-toolbar-items>
    </v-toolbar-title>
    <v-spacer></v-spacer>
    <v-toolbar-items>
      <v-btn v-for="link in $store.state.links" flat :to='link.to' :key='link.to' v-if='link.visible'>{{link.text}}</v-btn>
      <v-btn flat @click='logout' v-if='$store.state.user'>Logout</v-btn>
    </v-toolbar-items>
  </v-toolbar>
</template>
<script>
export default {
  methods: {
    logout () {
      this.$store.dispatch('setUser', null)
      this.$router.push({name: 'home'})
    }
  }
}
</script>
<style scoped>

</style>
