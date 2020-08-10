<template>
  <v-app>
    <v-navigation-drawer app v-if="drawer">
      <!-- -->
    </v-navigation-drawer>

    <v-app-bar app color="white" dark>
      <div class="mx-auto align-center">
        <v-img
          alt="Vuetify Logo"
          class="shrink mx-auto"
          contain
          src="@/assets/Logo-lucky.png"
          transition="scale-transition"
          width="150"
        />
      </div>
    </v-app-bar>

    <!-- Sizes your content based upon application components -->
    <v-main class="pa-0 ma-0">
      <!-- Provides the application the proper gutter -->
      <v-container fluid class="pa-0 ma-0 px-1 mb-10 pb-10">
        <!-- If using vue-router -->
        <router-view></router-view>
      </v-container>
    </v-main>

    <v-footer app class="ma-0 pa-0">
      <v-bottom-navigation color="amber" grow>
        <v-btn height="100%" to="/">
          <span class="mt-1">หน้าแรก</span>
          <v-icon>mdi-home</v-icon>
        </v-btn>
        <!-- ${this.$route.params.id} -->
        <!-- @click="()=>{this.$router.go(-1)}" -->
        <v-btn height="100%" to="/shop">
          <span class="mt-1">รายการสินค้า</span>
          <v-icon>mdi-equal-box</v-icon>
        </v-btn>

        <v-btn height="100%" to="/basket">
          <span class="mt-1">ตะกร้าสินค้า</span>
          <v-badge
            color="red"
            :content="getLengthBasket"
            overlap
            v-if="getLengthBasket > 0"
          >
            <v-icon>mdi-basket</v-icon>
          </v-badge>
          <v-icon v-else>mdi-basket</v-icon>
        </v-btn>

        <v-btn height="100%" to="/ShippingStatus">
          <span class="mt-1">สถานะคำสั่งซื้อ</span>
          <v-icon>mdi-map-marker</v-icon>
        </v-btn>
        <!-- to="/user" -->
        <v-btn height="100%" @click="goTo()">
          <span class="mt-1">บัญชีผู้ใช้</span>
          <v-icon>mdi-account</v-icon>
        </v-btn>
      </v-bottom-navigation>
    </v-footer>

    <!-- start dialog -->
    <v-dialog
      v-model="dialogAccount"
      fullscreen
      transition="dialog-bottom-transition"
    >
      <v-card>
        <v-toolbar white color="">
          <v-btn icon white @click="dialogAccount = false , typeLogin=''">
            <v-icon>mdi-arrow-left</v-icon>
          </v-btn>
          <v-toolbar-title>กลับ</v-toolbar-title>
        </v-toolbar>
        <v-row no-gutters>
          <v-col cols="12" class="py-0 pa-2">
            <v-card elevation="0" tile class="pa-3 ma-0 mt-2 py-0">
              <v-row no-gutters>
                <v-col cols="12" class="pa-16 py-9">
                  <v-img
                    aspect-ratio="4"
                    :src="require('./assets/Logo-lucky.png')"
                    contain
                  ></v-img>
                </v-col>
              </v-row>
            </v-card>
            <v-card elevation="0" tile class="pa-3 ma-0 py-0" v-if="typeLogin==''">
              <v-row no-gutters class="justify-center text-center">
                  <v-col cols="12"><small><b>LOGIN / เข้าสู่ระบบ</b></small></v-col>
                  <v-btn width="150" height="35" color="#FDC33D" class="ma-1 mt-3" elevation="4" @click="typeLogin='Customer'"><b>ลูกค้าทั่วไป</b></v-btn>
                  <v-btn width="150" height="35" color="#FDC33D" class="ma-1 mt-3" elevation="4" @click="typeLogin='Member'"><b>ร้านค้า</b></v-btn>
              </v-row>
            </v-card>
            <cusLogin v-if="typeLogin!=''" :typeLogin="typeLogin" @status="getStatus($event)"></cusLogin>
            <!-- <memLogin v-if="typeLogin=='member'"></memLogin> -->
          </v-col>
        </v-row>
      </v-card>
    </v-dialog>
    <!-- end dialog -->
  </v-app>
</template>

<script>
import Basket from "@/Models/Basket";
import Customer from "@/Models/Customer";
import TypeLogin from "@/Models/TypeLogin";
// import CheckTypeLogin from "@/components/CheckTypeLogin";
import cusLogin from "@/components/customer/Login";
// import memLogin from "@/components/member/Login";


export default {
  name: "App",
  data: () => ({
    drawer: false,
    links: [
      "หน้าหลัก",
      "รายการสินค้า",
      "ตะกร้าสินค้า",
      "สถานะคำสั่งซื้อ",
      " สมาชิก",
    ],
    dialogAccount: false,
    typeLogin:''
  }),
  methods: {
    getStatus(status){
      console.log("+++ ",status)
      this.dialogAccount = status;
    },
    goTo(){
      if(!this.getTypeLogin){
        this.dialogAccount = true
      }else{
        if(this.getTypeLogin.type == "Customer"){
          console.log("type Customer")
          this.$router.push("/user").catch(() => {});

        }else if(this.getTypeLogin.type == "Member"){
          console.log("type Member")
          this.$router.push("/member").catch(() => {});
        }
        
      }


    }
  },
  computed: {
    getLengthBasket() {
      return Basket.query().all().length;
    },
    account() {
      return Customer.query().first();
    },
    getTypeLogin() {
      return TypeLogin.query().first();
    }
  },
  components: {
    cusLogin,
    // memLogin
  },
  watch: {

  },
  created() {},
};
</script>
<style>
.v-application .v-item-group.v-bottom-navigation .v-btn {
  border-radius: 0;
  box-shadow: none;
  flex: 0 1 auto;
  font-size: 0.75rem;
  height: inherit;
  max-width: 20%;
  min-width: 20%;
  position: relative;
  text-transform: none;
}
</style>
