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


export default {
  name: 'App',
  components: {
    PageHeader
  },
  // async fetch () {
  //   //  await this.$store.dispatch('init')
  // }
}
</script>
<style>

</style>
