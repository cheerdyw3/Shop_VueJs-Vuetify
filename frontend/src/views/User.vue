<template>
  <v-card elevation="0" class="pa-0 ma-0">
    <v-card elevation="0" class="pa-2 ma-0 pa-0 mt-15">
      <v-row>
        <v-col cols="6" class="py-0">
          <h3>จัดการข้อมูล</h3>
        </v-col>
        <v-col cols="6" class="py-0 text-end mt-n1">
          <v-btn color="error" fab x-small dark @click="Logout()">
            <v-icon>mdi-logout</v-icon>
          </v-btn>
        </v-col>
      </v-row>
    </v-card>

    <v-card elevation="0" title>
      <v-tabs v-model="tab" background-color="#283593" dark grow>
        <v-tabs-slider color="yellow"></v-tabs-slider>
        <v-tab v-for="item in items" :key="item.tab">
          <span>{{ item.tab }}</span>
        </v-tab>
      </v-tabs>

      <v-tabs-items v-model="tab">
        <v-tab-item>
          <v-card flat>
            <v-card-text class="pa-0">
              <Orders :tab="tab"></Orders>
            </v-card-text>
          </v-card>
        </v-tab-item>
        <v-tab-item>
          <v-card flat>
            <v-card-text class="pa-0">
              <Orders :tab="tab"></Orders>
            </v-card-text>
          </v-card>
        </v-tab-item>
        <v-tab-item>
          <v-card flat>
            <v-card-text class="pa-0">
              <Account></Account>
            </v-card-text>
          </v-card>
        </v-tab-item>
      </v-tabs-items>
    </v-card>
  </v-card>
</template>

<script>
// import { HTTP } from "@/Connect/http";
import Customer from "@/Models/Customer";
import Basket from "@/Models/Basket";
import ProductList from "@/Models/ProductList";
import Shops from "@/Models/Shops";
import TypeLogin from "@/Models/TypeLogin";

import Account from "@/components/Account";
import Orders from "@/components/Orders";

export default {
  name:'user',
  data() {
    return {
      showAlert: false,
      account: [],
      tab: null,
      items: [
        { tab: "ข้อมูลการสั่งซื้อ" },
        { tab: "รายการสิ้นค้าที่ต้องได้รับ" },
        { tab: "ข้อมูลส่วนตัว" },
      ],
    };
  },
  methods: {
    initial() {
      if (Customer.query().first() != null) {
        this.account = Customer.query().first();
      } else {
        this.$router.push("/login");
      }
    },
    Logout() {
      Customer.deleteAll();
      Basket.deleteAll();
      ProductList.deleteAll();
      Shops.deleteAll();
      TypeLogin.deleteAll();
      this.$router.push({ path: "/Login" }, () => {});
    },
  },
  computed: {},
  watch: {
    
  },
  components: { Account, Orders },
  created() {
    this.initial();
  },
};
</script>

<style></style>
