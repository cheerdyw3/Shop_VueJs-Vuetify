import Vue from "vue";
import VueRouter from "vue-router";
import Login from "../views/Login.vue";
import Home from "../views/Home.vue";

Vue.use(VueRouter);

const routes = [
  {
    path: "/",
    name: "Login",
    component: Login
  },
  {
    path: '/authors',
    name: 'Authors',
    component: Home
  },
  {
    path: "/home",
    name: "Home",
    component: Home
  },
  {
    path: "/Unit",
    name: "Unit", 
    component: () =>  import("../views/Unit.vue")
  },
  {
    path: "/Region",
    name: "Region", 
    component: () =>  import("../views/Region.vue")
  },
  {
    path: "/Delivery",
    name: "Delivery", 
    component: () =>  import("../views/Delivery.vue")
  },
  {
    path: "/SouvenirGroup",
    name: "SouvenirGroup", 
    component: () =>  import("../views/SouvenirGroup.vue")
  },
  {
    path: "/Souvenir",
    name: "Souvenir", 
    component: () =>  import("../views/Souvenir.vue")
  },
  {
    path: "/Member",
    name: "Member", 
    component: () =>  import("../views/Member.vue")
  }
];

const router = new VueRouter({
  routes
});

export default router;
