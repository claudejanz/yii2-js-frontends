<template>
  <div id="app">
    <v-app>
      <v-content>
        <v-container>
          <page-header />
          <router-view/>
        </v-container>
      </v-content>
    </v-app>
  </div>
</template>

<script>
import PageHeader from '@/components/Header'
export default {
  name: 'App',
  components: {
    PageHeader
  }
}
</script>

<style>
#app {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
