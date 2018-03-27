<template>
  <v-container fluid>
    <v-layout>
      <v-flex xs6 offset-xs3>
        <div class="white elevation-2">
          <v-form v-model="valid">
            <v-toolbar flat dark v-bind:class="this.$store.state.colorHeader">
              <v-toolbar-title class="white--text">Register</v-toolbar-title>
            <!-- <v-spacer></v-spacer>
            <v-btn icon>
              <v-icon>search</v-icon>
            </v-btn>
            <v-btn icon>
              <v-icon>apps</v-icon>
            </v-btn>
            <v-btn icon>
              <v-icon>refresh</v-icon>
            </v-btn>
            <v-btn icon>
              <v-icon>more_vert</v-icon>
            </v-btn> -->
            </v-toolbar>
            <div class="pl-4 pr-4 pt-2 pb-2">
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

            </div>
           </v-form>
        </div>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import AuthenticationService from '@/services/AuthenticationService'
export default {
  name: 'Register',
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
      const response = await AuthenticationService.register({
        usernameEmail: this.usernameEmail,
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
