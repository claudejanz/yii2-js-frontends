<template>
  <panel title='Login'>
    <v-form v-model="valid">
      <v-text-field
      label="username or email"
      name="usernameEmail"
      v-model="usernameEmail"
      :rules="nameRules"
      required
      ></v-text-field>
      <div v-html="errors.usernameEmail" class='red--text' />
      <v-text-field
      label="password"
      name="password"
      v-model='password'
      required
      ></v-text-field>
      <br>
      <div v-html="errors.password" class='red--text' />
      <br>
      <v-btn
      v-bind:class="this.$store.state.colorHeader"
      dark
      @click="login"
      >Login</v-btn>
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
      usernameEmail: 'claude',
      password: '12345678',
      nameRules: [
        v => !!v || 'Name is required'
      ],
      errors: {}
    }
  },
  methods: {
    async login () {
      try {
        const response = await UserServices.login({
          usernameEmail: this.usernameEmail,
          password: this.password
        })
        this.$store.dispatch('setUser', response.data)
        this.$router.push({name: 'home'})
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
