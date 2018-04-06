<template>
  <panel title='Register'>
    <v-form v-model="valid">
      <v-text-field
      label="username or email"
      name="username"
      v-model="username"
      :rules="nameRules"
      required
      ></v-text-field>
      <div v-html="errors.usernameEmail" class='red--text' />
      <v-text-field
      label="password"
      name="password"
      type='password'
      v-model='password'
      required
      ></v-text-field>
      <br>
      <div v-html="errors.password" class='red--text' />
      <br>
      <v-btn
      v-bind:class="this.$store.state.colorHeader"
      dark
      @click="register"
      >Register</v-btn>
    </v-form>
  </panel>
</template>

<script>
import UserServices from '@/services/UserServices'
import Panel from '@/components/Panel'
export default {
  components: {
    Panel
  },
  data () {
    return {
      valid: false,
      usernameEmail: '',
      password: '',
      nameRules: [
        v => !!v || 'Name is required'
      ],
      errors: {}
    }
  },
  methods: {
    async register () {
      const response = await UserServices.register({
        username: this.username,
        password: this.password
      })
      try {
        this.$store.dispatch('setUser', response.data.user)
      } catch (error) {
        this.errors = {}
        error.response.data.forEach(element => {
          this.errors[element.field] = element.message
        })
      }
    }
  }
  //        mounted(){
  //            setTimeout(()=>{
  //                this.email='Hello world!'
  //            },1000)
  //        }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.error {
  color: red;
}
</style>
