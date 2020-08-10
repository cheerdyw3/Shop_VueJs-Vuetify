<template>
  <v-card elevation="0" class="pa-0 ma-0">
    <v-card elevation="0" class="pa-2 ma-0 pa-0 mt-15">
      <h3>เข้าสู่ระบบ</h3>
    </v-card>
    <v-card elevation="0" class="px-5 ma-0">
      <v-form ref="form" lazy-validation>
        <v-row no-gutters>
          <v-col cols="12" class="pa-0 ma-0" v-if="isFalseAlert">
            <v-alert type="error">
              อีเมล หรือ รหัสผ่านไม่ถูกต้อง
            </v-alert>
          </v-col>
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
            <v-btn block color="success" @click="login">เข้าสู่ระบบ</v-btn>
          </v-col>
          <v-col cols="12" class="mt-2">
            <v-btn block color="warning" to="/Register">ลงทะเบียน</v-btn>
          </v-col>
          <v-col cols="6" class="mt-2 text-start">
            <router-link to="/Register">ลงทะเบียน</router-link>
          </v-col>
          <v-col cols="6" class="mt-2 text-end">
            <router-link to="/ForgotPassword">ลืมรหัสผ่าน</router-link>
          </v-col>
          <v-progress-linear
            class="my-5"
            color="grey lighten-2"
            rounded
            value="100"
            height="2"
          ></v-progress-linear>
          <v-col cols="12" class="mt-2">
            <v-btn block color="primary"
              ><v-icon left class="align-start">mdi-google-plus</v-icon>
              ดำเนินการต่อด้วยบัญชี Google</v-btn
            >
          </v-col>

          <v-col cols="12" class="mt-2">
            <v-btn block color="primary"
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
import Shops from "@/Models/Shops";

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
    login() {
      if (this.$refs.form.validate()) {
        // console.log("send ", this.account);
        try {
          HTTP.post(
            "http://localhost/adminAppLK/public/api/v1/login/customer",
            this.account
          ).then((res) => {
            if (res.data.data) {
              console.log("res ", res.data.data);
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
              console.log(Customer.all());

              let checkShops = Shops.query().first();
              if (checkShops != null) {
                this.$router.push("/Basket");
              } else {
                this.$router.push({ path: "/" }, () => {});
              }
            } else {
              console.log("null");
              this.alertFalse();
            }
          });
        } catch (error) {
          console.error(error);
        }
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
        this.$router.go(-1);
      } else {
        this.$router.push("/login").catch(()=>{});
      }
    },
  },
  created() {
    this.checkLogin();
  },
};
</script>

<style></style>
