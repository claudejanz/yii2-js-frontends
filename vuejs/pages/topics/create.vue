<template>
  <panel title='Create Topic'>
    eregr
    <topic :topic=topic>
      <v-btn
      v-bind:class="this.$store.state.colorHeader"
      dark
      @click="create"
      >Create</v-btn>
    </topic>
  </panel>
</template>

<script>
import Topic from '@/components/forms/Topic'
import Panel from '@/components/Panel'

export default {
  components: {
    Panel,
    Topic
  },
  data () {
    return {
      valid: false,
      topic: {
        title: null
      },
      errors: {}
    }
  },
  methods: {
    async create () {
      try {
        await TopicServices.create(this.topic)
        this.$store.dispatch('getTabs')
        this.topic.title = null
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
