<template>
  <panel title='Create Topic'>
    <v-form v-model="valid">
      <v-text-field
      label="title"
      name="title"
      v-model="topic.title"
      required
      ></v-text-field>
      <div v-html="errors.title" class='red--text' />
      <br>
      <v-btn
      v-bind:class="this.$store.state.colorHeader"
      dark
      @click="create"
      >Create</v-btn>
    </v-form>
  </panel>
</template>

<script>
import Panel from '@/components/subs/Panel'
import TopicServices from '@/services/TopicServices'

export default {
  components: {
    Panel
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
  // mounted () {
  //   console.log('coucou')
  // }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
