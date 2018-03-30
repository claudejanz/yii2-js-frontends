<template>
  <div>
    <div v-if="topic">
      <panel :title='topic.title'>
        <div v-if="posts">
            <post-view v-for="(post,index) in posts"
            :key="post.id"
            :post="post"
            :index="index"
            :max='posts.length'/>
        </div>
        <div v-else>no posts</div>
      </panel>
    </div>
  </div>
</template>

<script>
import Panel from '@/components/subs/Panel'
import TopicServices from '@/services/TopicServices'
import PostView from '@/components/posts/PostView'

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
        const response = await TopicServices.view(this.$route.params.id)
        this.topic = response.data
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
