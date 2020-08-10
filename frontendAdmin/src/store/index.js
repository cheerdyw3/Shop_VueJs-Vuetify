import Vue from 'vue'
import Vuex from 'vuex'
import VuexPersist from 'vuex-persist';
import VuexORM from '@vuex-orm/core'
import Admin from '@/Models/Admin'   

Vue.use(Vuex) 
const vuexLocalStorage = new VuexPersist({ 
  storage: window.sessionStorage,  
})

const database = new VuexORM.Database()   
database.register(Admin)   
 
const store = new Vuex.Store({
  plugins: [VuexORM.install(database),vuexLocalStorage.plugin] 
})

export default store