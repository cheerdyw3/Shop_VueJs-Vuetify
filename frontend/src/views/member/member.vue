<template>
  <v-card elevation="0" class="pa-0 ma-0">
    <v-card elevation="0" class="pa-2 ma-0 pa-0 mt-15">
      <v-row no-gutters>
        <v-col cols="12" class="py-0 text-end">
          <small
            ><b>{{ getMember.shop }}</b>
            <v-avatar size="35" class="ml-1">
              <img :src="`${API}${getMember.image}`" /> </v-avatar
          ></small>
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
              <Orders2></Orders2>
            </v-card-text>
          </v-card>
        </v-tab-item>
        <v-tab-item>
          <v-card flat>
            <v-card-text class="pa-0"> </v-card-text>
          </v-card>
        </v-tab-item>
      </v-tabs-items>
    </v-card>
  </v-card>
</template>

<script>
// import { HTTP } from "@/Connect/http";
import Member from "@/Models/Member";
import Basket from "@/Models/Basket";
import ProductList from "@/Models/ProductList";
import Shops from "@/Models/Shops";
import TypeLogin from "@/Models/TypeLogin";

import Orders from "@/components/member/Orders";
import Orders2 from "@/components/member/Orders2";

export default {
  name: "user",
  data() {
    return {
      API: process.env.VUE_APP_API,
      showAlert: false,
      account: [],
      tab: null,
      items: [
        { tab: "รายการสินค้า" },
        { tab: "ยืนยันการจัดส่ง" },
        { tab: "ส่งสนค้าสำเร็จ" },
      ],
    };
  },
  methods: {
    initial() {
      if (Member.query().first() != null) {
        this.account = Member.query().first();
      } else {
        // this.$router.push("/login");
      }
    },
    Logout() {
      Member.deleteAll();
      Basket.deleteAll();
      ProductList.deleteAll();
      Shops.deleteAll();
      TypeLogin.deleteAll();
      this.$router.push({ path: "/" }, () => {});
    },
  },
  computed: {
    getMember() {
      return Member.query().first();
    },
  },
  watch: {},
    components: { Orders , Orders2 },
  created() {
    this.initial();
  },
};
</script>

<style></style>
