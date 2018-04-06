<template>
  <div>
    <div v-if="topic">
      <panel :title='topic.title'>
        <v-btn v-if='topic.can_update'>
          <v-icon>
            edit
          </v-icon>
        </v-btn>
        <div v-if="posts">
            <post-view v-for="(post,index) in posts"
            :key="post.id"
            :postFromParent="post"
            :index="index"
            :max='posts.length'/>
        </div>
        <div v-else>no posts</div>
      </panel>
    </div>
  </div>
</template>

<script>
import Panel from '~/components/Panel'
import Topic from '~/models/Topic'
import PostView from '~/components/posts/PostView'

export default {
  components: {
    Panel,
    PostView
  },
  data () {
    return {
      title: 'coucou',
      topic: null,
      error: null
    }
  },
  computed: {
    // un accesseur (getter) calculé
    posts: function () {
      // `this` pointe sur l'instance vm
      return (this.topic && this.topic.posts) ? this.topic.posts : null
    }
  },
  methods: {
    async init () {
      try {
        const topic = new Topic({id: this.$route.params.id})
        await topic.fetch()
        this.topic = topic
        this.error = null
      } catch (error) {
        this.topic = null
        this.error = error.response.data
      }
    }
  },
  watch: {
    '$route' (to, from) {
      this.init()
    }
  },
  created () {
    this.init()
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
