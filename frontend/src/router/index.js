import Vue from "vue";
import VueRouter from "vue-router";
import Home from "../views/Home.vue";

Vue.use(VueRouter);

const routes = [
  {
    path: "/",
    name: "Home",
    component: Home
  },
  {
    path: "/shop/:id",
    name: "Shop", 
    component: () =>
      import(/* webpackChunkName: "about" */ "../views/Shop.vue")
  },
  {
    path: "/basket",
    name: "Basket", 
    component: () =>
      import("../views/Basket.vue")
  },
  {
    path: "/shippingStatus",
    name: "ShippingStatus", 
    component: () =>
      import("../views/ShippingStatus.vue")
  },
  {
    path: "/login",
    name: "Login", 
    component: () =>
      import("../views/Login.vue")
  },
  {
    path: "/register",
    name: "Register", 
    component: () =>
      import("../components/customer/Register.vue")
  },
  {
    path: "/forgotpassword",
    name: "ForgotPassword", 
    component: () =>
      import("../views/ForgotPassword.vue")
  },
  {
    path: "/user",
    name: "User", 
    component: () =>
      import("../views/User.vue")
  },
  {
    path: "/confirmOrders",
    name: "ConfirmOrders", 
    component: () =>
      import("../views/ConfirmOrders.vue")
  },
  {
    path: "/oderDetails",
    name: "OderDetails", 
    component: () =>
      import("../views/OrderDetails.vue")
  },
  {
    path: "/member",
    name: "Member", 
    component: () =>
      import("../views/member/member.vue")
  }
];

const router = new VueRouter({
  mode: 'hash',
  routes
});

export default router;
