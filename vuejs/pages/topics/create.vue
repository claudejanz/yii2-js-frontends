<template>
  <panel title='Create Topic'>
    <topic-form :topic="topic">
      <v-btn
      v-bind:class="this.$store.state.colorHeader"
      dark
      @click="create"
      >Create</v-btn>
    </topic-form>
  </panel>
</template>

<script>
import { Topic } from '@/models/Topic'
import TopicForm from '@/components/forms/Topic'
import Panel from '@/components/Panel'

export default {
  components: {
    TopicForm,
    Panel
  },
  data () {
    return {
      valid: false,
      topic: new Topic(),
      errors: null
    }
  },
  methods: {
    async create () {
      try {
        await this.topic.save()
        this.$store.dispatch('getTopics')
        this.$router.push({name:'index'});
      } catch (error) {
        this.errors = {}
        console.log(error)
        error.response.data.forEach(element => {
          this.errors[element.field] = element.message
        })
      }
    }
  }
}
</script>
