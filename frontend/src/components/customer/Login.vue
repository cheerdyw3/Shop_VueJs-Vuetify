<template>
  <v-card elevation="0" class="pa-5 ma-0 pt-0">
    <v-card elevation="0" class="pa-2 ma-0 pb-0 ml-3">
      <v-col cols="12" class="pa-0 ma-0" v-if="isFalseAlert">
        <v-alert outlined type="error" class="pa-3">
          <small><b>อีเมล หรือ รหัสผ่านไม่ถูกต้อง</b></small>
        </v-alert>
      </v-col>
      <small
        ><b>LOGIN / เข้าสู่ระบบ {{ typeLogin }}</b></small
      >
    </v-card>
    <v-card elevation="0" class="px-5 ma-0 mt-2">
      <v-form ref="form" lazy-validation>
        <v-row no-gutters>
          <v-col cols="12" class="pa-0 ma-0">
            <v-text-field
              v-model="account.email"
              label="email"
              prepend-inner-icon="mdi-email"
              :rules="rules.emailRules"
            ></v-text-field>
          </v-col>
          <v-col cols="12" class="pa-0 ma-0 mb-5">
            <v-text-field
              v-model="account.password"
              label="password"
              :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
              :rules="[rules.required]"
              :type="show1 ? 'text' : 'password'"
              hint="At least 6 characters"
              @click:append="show1 = !show1"
              prepend-inner-icon="mdi-lock"
            ></v-text-field>
          </v-col>

          <v-col cols="12">
            <v-btn height="35" block color="success" @click="login"
              >เข้าสู่ระบบ</v-btn
            >
          </v-col>
          <v-col cols="12" class="mt-1">
            <!-- to="/Register" -->
            <cusRegister></cusRegister>
            <!-- <v-btn height="35" block color="warning" 
              >ลงทะเบียน</v-btn
            > -->
          </v-col>
          <v-col cols="6" class="mt-2 text-start"> </v-col>
          <v-col cols="6" class="mt-2 text-end">
            <router-link to="/ForgotPassword">ลืมรหัสผ่าน</router-link>
          </v-col>
          <v-progress-linear
            class="my-3"
            color="grey lighten-2"
            rounded
            value="100"
            height="2"
          ></v-progress-linear>
          <v-col cols="12" class="mt-2">
            <v-btn height="35" block color="primary"
              ><v-icon left class="align-start">mdi-google-plus</v-icon>
              ดำเนินการต่อด้วยบัญชี Google</v-btn
            >
          </v-col>

          <v-col cols="12" class="mt-1">
            <v-btn height="35" block color="primary"
              ><v-icon left>mdi-facebook-messenger</v-icon> ดำเนินการต่อด้วย
              Facebook</v-btn
            >
          </v-col>
        </v-row>
      </v-form>
    </v-card>
  </v-card>
</template>

<script>
import { HTTP } from "@/Connect/http";
import Customer from "@/Models/Customer";
import Member from "@/Models/Member";
import Shops from "@/Models/Shops";
import TypeLogin from "@/Models/TypeLogin";

import cusRegister from "@/components/customer/Register";
export default {
  data() {
    return {
      show1: false,
      isFalseAlert: false,
      account: {
        email: "",
        password: "",
      },
      rules: {
        required: (value) => !!value || "Required.",
        min: (v) => v.length >= 6 || "Min 6 characters",
        emailRules: [
          (v) => !!v || "กรุณากรอก อีเมล",
          (v) => /.+@.+\..+/.test(v) || "E-mail must be valid",
        ],
      },
    };
  },
  methods: {
    async login() {
      // console.log("send ", this.account);
      try {
        if (this.$refs.form.validate()) {
          if (this.typeLogin == "Customer") {
            await HTTP.post(
              "http://localhost/adminAppLK/public/api/v1/login/customer",
              this.account
            ).then((res) => {
              if (res.data.data) {
                Customer.deleteAll();
                Customer.insert({
                  data: {
                    created_at: res.data.data.created_at,
                    id: res.data.data.id,
                    name: res.data.data.name,
                    surname: res.data.data.surname,
                    phone: res.data.data.phone,
                    email: res.data.data.email,
                    password: res.data.data.password,
                    address: res.data.data.address,
                    district: res.data.data.district,
                    amphoe: res.data.data.amphoe,
                    province: res.data.data.province,
                    zipcode: res.data.data.zipcode,
                  },
                });
                TypeLogin.deleteAll();
                TypeLogin.insert({
                  data: {
                    type: this.typeLogin,
                  },
                });
                if (Shops.query().first() != null) {
                  this.$router.push("/Basket");
                } else {
                  this.$router.push({ path: "/" }, () => {});
                }
                this.$emit("status", false);
              } else {
                this.alertFalse();
              }
            });
          } else if (this.typeLogin == "Member") {
            console.log("member");
            await HTTP.post(
              "http://localhost/adminAppLK/public/api/v1/login/member",
              this.account
            ).then((res) => {
              if (res.data.data) {
                console.log("++++++++++ ",res.data.data);
                Member.deleteAll();
                Member.insert({
                  data: {
                    id: res.data.data.id,
                    region_id: res.data.data.region_id,
                    name: res.data.data.name,
                    shop: res.data.data.shop,
                    phone: res.data.data.phone,
                    email: res.data.data.email,
                    password: res.data.data.password,
                    address: res.data.data.address,
                    district: res.data.data.district,
                    amphoe: res.data.data.amphoe,
                    province: res.data.data.province,
                    zipcode: res.data.data.zipcode,
                    image: res.data.data.image,
                    created_at: res.data.data.created_at,
                    updated_at: res.data.data.updated_at,
                  },
                });
                TypeLogin.deleteAll();
                TypeLogin.insert({
                  data: {
                    type: this.typeLogin,
                  },
                });
                this.$router.push({ path: "/" }, () => {});
                this.$emit("status", false);
              } else {
                this.alertFalse();
              }
            });
          }
        }
      } catch (error) {
        console.error(error);
      }
    },
    alertFalse() {
      this.isFalseAlert = true;
      setTimeout(() => {
        this.isFalseAlert = false;
      }, 4000);
    },
    checkLogin() {
      if (Customer.query().first() != null) {
        // this.$router.go(-1);
      } else {
        // this.$router.push("/login").catch(() => {});
      }
    },
  },
  components: {
    cusRegister,
  },
  props: {
    typeLogin: String,
  },
  created() {
    this.checkLogin();
  },
};
</script>

<style></style>
