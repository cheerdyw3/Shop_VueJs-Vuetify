<template>
  <v-app id="inspire">
    <v-navigation-drawer v-if="Admins"
       permanent
      :clipped="$vuetify.breakpoint.lgAndUp"
      app
    >
       <NavigationC></NavigationC>
    </v-navigation-drawer>

    <v-app-bar 
      :clipped-left="$vuetify.breakpoint.lgAndUp"
      app
      color="blue darken-3"
      dark
      dense
    >
      <v-app-bar-nav-icon ></v-app-bar-nav-icon>
      <v-toolbar-title
        style="width: 300px"
        class="ml-0 pl-4"
      >
        <span class="hidden-sm-and-down">Administrator</span>
      </v-toolbar-title>
       
      <v-spacer></v-spacer>
      <v-btn icon v-if="Admins" @click="logout()">
        <v-icon>mdi-logout</v-icon>
      </v-btn>
       
    </v-app-bar>
     <v-main>

    <!-- Provides the application the proper gutter -->
    <v-container fluid>

      <!-- If using vue-router -->
      <router-view></router-view>
    </v-container>
  </v-main> 
      
     
  </v-app>
</template>

<script> 
import Admin from '@/Models/Admin' 
import NavigationC from '@/components/NavigationC'  

export default {
  name: 'app', 
   components: {
    NavigationC, 
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
      if (!this.Admins && this.$route.path !== '/') {
        this.$router.push('/?redirect=' + this.$route.path)
      }
    },
    logout(){
       Admin.deleteAll()
    }
  },
}
</script>

