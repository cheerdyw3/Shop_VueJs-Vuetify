<template> 
    <v-card class="elevation-10 mx-auto mt-12" max-width="350">
        <v-toolbar color="primary" dark flat dense>
            <v-toolbar-title>Login form</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-tooltip bottom>
                
            </v-tooltip>
        </v-toolbar>
        <v-card-text >
            <v-form>
                <v-text-field label="Login" name="login" v-model="username" prepend-icon="mdi-account" type="text">
                </v-text-field>

                <v-text-field id="password" label="Password" v-model="password" name="password" prepend-icon="mdi-lock" type="password">
                </v-text-field>
            </v-form>
        </v-card-text>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn  color="primary" @click="login()">Login</v-btn>
        </v-card-actions>
    </v-card> 
</template>


<script> 
import { HTTP } from "@/Connect/http";
import Admin from '@/Models/Admin'  
export default {
  name: 'Login',
  data () {
    return {
      username: '',
      password: '',
      error: false
    }
  },
  computed: {
      Admins() {  return Admin.query().first(); }, 
  },
  created () {
    this.checkCurrentLogin()
  },
  updated () {
    this.checkCurrentLogin()
  },
  methods: {
    checkCurrentLogin () {
      if (this.Admins) {
        this.$router.replace(this.$route.query.redirect || '/authors')
      }
    },
    login () {    
      HTTP.post('login', { email: this.username, password: this.password })
        .then(request => this.loginSuccessful(request.data))
        .catch(() => this.loginFailed())
    },
    loginSuccessful (req) {  
        Admin.insert({
            data: { data: req } 
        }) 
        this.$router.replace(this.$route.query.redirect || '/authors')
    },
    loginFailed () {
      Admin.deleteAll()
    }
  }
}
</script>