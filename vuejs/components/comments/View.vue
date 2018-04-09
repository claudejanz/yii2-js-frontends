<template>
  <div>
    <div v-if="comment">
      <h2>{{comment.title}}</h2>
      <div v-html="comment.content"></div>
    </div>
    <div v-else><v-icon class="spin">cached</v-icon></div>
    <v-divider v-if="index!=undefined && index + 1 < max"></v-divider>
  </div>
</template>

<script>
import Panel from '~/components/Panel'

export default {
  components: {
    Panel
  },
  data () {
    return {
      error: null
    }
  },
  props: [
    'comment',
    'index',
    'max'
  ],
  // watch: {
  //   '$route' (to, from) {
  //     this.init()
  //   }
  // },
  mounted () {
    if (this.comment === undefined) {
      this.init()
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
