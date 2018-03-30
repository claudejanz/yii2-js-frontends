<template>
    <v-flex xs12>
      <div class="white elevation-2">
          <v-toolbar flat dark v-bind:class="this.$store.state.colorHeader">
            <v-toolbar-title>{{title}}</v-toolbar-title>
            <v-spacer></v-spacer>
            <slot name="action"></slot>
          </v-toolbar>
          <div class="pl-4 pr-4 pt-2 pb-2 text-sm-left">
            <slot>
              Content here
            </slot>
          </div>
      </div>
    </v-flex>
</template>
<script>
export default {
  props: [
    'title'
  ]
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
