import Vue from 'vue'
import Vuex from 'vuex'
import VuexPersist from 'vuex-persist';
import VuexORM from '@vuex-orm/core'
import Customer from '@/Models/Customer'
import Member from '@/Models/Member'
import ProductList from '@/Models/ProductList'
import Basket from '@/Models/Basket'
import Shops from '@/Models/Shops'
import TypeLogin from '@/Models/TypeLogin'

Vue.use(Vuex)
const vuexLocalStorage = new VuexPersist({
  storage: window.sessionStorage,
})

const database = new VuexORM.Database()
database.register(Customer)
database.register(Member)
database.register(ProductList)
database.register(Basket)
database.register(Shops)
database.register(TypeLogin)

const store = new Vuex.Store({
  plugins: [VuexORM.install(database), vuexLocalStorage.plugin]
})

export default store