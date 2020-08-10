<template>
  <v-card elevation="0" class="pa-5 ma-0 pt-0">
    <v-card elevation="0" class="pa-2 ma-0 mt-15">
      <small><h3>ลงทะเบียน</h3></small>
    </v-card>
    <v-card elevation="0" class="px-5 ma-0">
      <v-form ref="form" lazy-validation>
        <v-row no-gutters>
          <v-col cols="12" class="pa-0 ma-0">
            <v-text-field
              v-model="account.name"
              :rules="[rules.required]"
              label="name"
              prepend-inner-icon="mdi-account"
            ></v-text-field>
          </v-col>
          <v-col cols="12" class="pa-0 ma-0">
            <v-text-field
              v-model="account.surname"
              :rules="[rules.required]"
              label="surname"
              prepend-inner-icon="mdi-account"
            ></v-text-field>
          </v-col>
          <v-col cols="12" class="pa-0 ma-0">
            <v-text-field
              v-model="account.email"
              :rules="rules.emailRules"
              label="email"
              prepend-inner-icon="mdi-email"
            ></v-text-field>
          </v-col>
          <v-col cols="12" class="pa-0 ma-0 mb-5">
            <v-text-field
              v-model="account.phone"
              :rules="rules.phoneRules"
              label="หมายเลขโทรศัพท์"
              prepend-inner-icon="mdi-phone"
            ></v-text-field>
          </v-col>
          <v-col cols="12">
            <v-btn height="35" block color="success" @click="register">ลงทะเบียน</v-btn>
          </v-col>

          <v-progress-linear
            class="my-3"
            color="grey lighten-2"
            rounded
            value="100"
            height="2"
          ></v-progress-linear>
          <v-col cols="12" class="mt-1">
            <v-btn height="35" block color="primary"
              ><v-icon left>mdi-google-plus</v-icon> ดำเนินการต่อด้วยบัญชี
              Google</v-btn
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

export default {
  data() {
    return {
      account: {
        name: "",
        surname: "",
        email: "",
        phone: "",
      },
      rules: {
        required: (value) => !!value || "Required.",
        min: (v) => v.length >= 6 || "Min 6 characters",
        phoneRules: [
          (v) => !!v || "กรุณากรอก เบอร์โทรศัพท์",
          (v) => v && v.length == 10,
        ],
        emailRules: [
          (v) => !!v || "กรุณากรอก อีเมล",
          (v) => /.+@.+\..+/.test(v) || "E-mail must be valid",
        ],
      },
    };
  },
  methods: {
    register() {
      if (this.$refs.form.validate()) {
        console.log("send ", this.account);
        try {
          HTTP.post(
            "http://localhost/adminAppLK/public/api/v1/customer",
            this.account
          ).then((res) => {
            // console.log("res ", res.data.data);
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
              console.log(Customer.all());
              this.$router.push({ path: "basket" }, () => {});
            }
          });
        } catch (error) {
          console.error(error);
        }
      }
    },
    checkLogin() {
      if (Customer.query().first() != null) {
        this.$router.go(-1);
      } else {
        this.$router.push("/register").catch(() => {});
      }
    },
  },
  created() {
    this.checkLogin();
  },
};
</script>

<style></style>
