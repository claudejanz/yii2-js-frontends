<template>
  <div>
    <div v-if="post">
      <panel :title='post.title'>
        <v-layout>
          <v-flex xs6>
            <div v-html="post.content"></div>
            <div v-if="!comments">
              <v-btn
                :to='{name:"posts-id",params:{"id":post.id}}'
              >View
              </v-btn>
            </div>
          </v-flex>
          <v-flex xs6>
            <panel v-if="comments" :title='"Comments "+comments.models.length'>
              <v-expansion-panel>
                <v-expansion-panel-content v-for="(comment) in comments.models" :key="comment.id">
                  <div slot="header">
                    <v-chip class="white elevation-1">
                      <v-avatar class="teal elevation-3">
                        <v-icon >account_box</v-icon>
                      </v-avatar>
                      {{comment.username}} |
                        {{comment.created_at | date}}
                    </v-chip>
                  </div>
                  <div v-html="comment.content" class="mx-4"></div>
                </v-expansion-panel-content>
              </v-expansion-panel>
            </panel>
          </v-flex>
        </v-layout>
      </panel>
    </div>
    <loader v-else/>
    <v-divider v-if="index!=undefined && index + 1 < max"></v-divider>
  </div>
</template>

<script>
import Panel from '~/components/Panel'
import {Post} from '~/models/Post'
import {Comments} from '~/models/Comment'
import CommentView from '~/components/comments/View'
import Loader from '@/components/Loader'

export default {
  components: {
    Panel,
    CommentView,
    Loader
  },
  data () {
    return {
      error: null,
      postFromLoad: null
    }
  },
  props: ['postFromParent', 'index', 'max'],
  computed: {
    comments: function () {
      if (this.post && this.post.comments) {
        return new Comments(this.post.comments)
      } else {
        return null
      }
    },
    post: function () {
      return (this.postFromLoad) ? this.postFromLoad : this.postFromParent
    }
  },
  methods: {
    async init () {
      try {
        const post = new Post({ id: this.$route.params.id })
        await post.fetch()
        this.postFromLoad = post
        this.error = null
      } catch (error) {
        this.post = null
        this.error = error.response.error
      }
    }
  },
  // watch: {
  //   '$route' (to, from) {
  //     this.init()
  //   }
  // },
  async created () {
    if (this.postFromParent === undefined) {
      this.init()
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
