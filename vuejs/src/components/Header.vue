<template>
  <v-toolbar fixed class="cyan">
    <v-toolbar-title class="white--text">
    <v-toolbar-items>
      <v-btn flat dark @click="navigateTo({name: 'home'})">
      Application
      </v-btn>
    </v-toolbar-items>
    </v-toolbar-title>
    <v-spacer></v-spacer>
    <v-toolbar-items>
      <v-btn dark flat @click="navigateTo({name: 'login'})">
        Login
      </v-btn>
      <v-btn dark flat @click="navigateTo({name: 'register'})">
        Register
      </v-btn>
    </v-toolbar-items>
  </v-toolbar>
</template>
<script>
export default {
  methods: {
    navigateTo(route) {
      this.$router.push(route);
    }
  }
};
</script>
<style scoped>

</style>
