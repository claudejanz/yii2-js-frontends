<template>
  <div>
    <v-layout v-if="post">
      <panel :title='post.title'>
        <div v-html="post.content"></div>
        <div v-if="!comments">
          <v-btn
            :to='{name:"posts-view",params:{"id":post.id}}'
          >View
          </v-btn>
        </div>
        <panel v-if="comments" title='Comments' class="md6 ml-2">
           <v-expansion-panel>
            <v-expansion-panel-content v-for="(comment) in comments" :key="comment.id">
              <div slot="header">{{comment.created_by}}</div>
              <div v-html="comment.content"></div>
            </v-expansion-panel-content>
           </v-expansion-panel>
        <!-- <comment-view v-for="(comment,index) in comments"
            :key="comment.id"
            :comment="comment"
            :index="index"
            :max='comments.length'/> -->
        </panel>
      </panel>
    </v-layout>
    <div v-else><v-icon class="spin">cached</v-icon></div>
    <v-divider v-if="index!=undefined && index + 1 < max"></v-divider>
  </div>
</template>

<script>
import Panel from '@/components/subs/Panel'
import PostServices from '@/services/PostServices'
import CommentView from '@/components/comments/CommentView'

export default {
  components: {
    Panel,
    CommentView
  },
  data () {
    return {
      error: null
    }
  },
  props: [
    'post',
    'index',
    'max'
  ],
  computed: {
    // un accesseur (getter) calculé
    comments: function () {
      // `this` pointe sur l'instance vm
      return (this.post && this.post.comments) ? this.post.comments : null
    }
  },
  methods: {
    async init () {
      try {
        const response = await PostServices.view(this.$route.params.id)
        this.post = response.data
        this.error = null
      } catch (error) {
        this.post = null
        console.log(error.response)
        this.error = error.response.error
      }
    }
  },
  // watch: {
  //   '$route' (to, from) {
  //     this.init()
  //   }
  // },
  mounted () {
    if (this.post === undefined) {
      this.init()
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
