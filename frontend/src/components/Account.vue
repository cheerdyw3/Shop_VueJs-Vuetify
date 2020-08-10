<template>

    <v-row no-gutters>
      <v-col>
        <v-card elevation="0">
          <v-form ref="form" lazy-validation>
            <v-row no-gutters>

              <v-col cols="12" class="mt-0 px-3 mt-2" v-if="showAlert">
                <v-alert type="success">
                  แก้ไขข้อมูลสำเร็จ
                </v-alert>
              </v-col>
              <v-col cols="12" class="pa-0 ma-0 mt-2">
                <div class="pt-2 pl-4"><h3>ข้อมูลส่วนตัว</h3></div>
              </v-col>
              <v-col cols="4" class="pa-0 ma-0 mt-2">
                <div class="pt-3 pl-4"><b>ชื่อ</b></div>
              </v-col>
              <v-col cols="8" class="pa-0 ma-0 mt-2">
                <v-text-field dense v-model="account.name"></v-text-field>
              </v-col>
              <v-col cols="4" class="pa-0 ma-0">
                <div class="pt-3 pl-4"><b>นามสกุล</b></div>
              </v-col>
              <v-col cols="8" class="pa-0 ma-0">
                <v-text-field dense v-model="account.surname"></v-text-field>
              </v-col>
              <v-col cols="4" class="pa-0 ma-0">
                <div class="pt-3 pl-4"><b>เบอร์โทรศัพท์</b></div>
              </v-col>
              <v-col cols="8" class="pa-0 ma-0">
                <v-text-field dense v-model="account.phone"></v-text-field>
              </v-col>
              <v-col cols="4" class="pa-0 ma-0">
                <div class="pt-3 pl-4"><b>Email</b></div>
              </v-col>
              <v-col cols="8" class="pa-0 ma-0">
                <v-text-field
                  dense
                  v-model="account.email"
                  disabled
                ></v-text-field>
              </v-col>
              <v-col cols="4" class="pa-0 ma-0">
                <div class="pt-3 pl-4"><b>ที่อยู่</b></div>
              </v-col>
              <v-col cols="8" class="pa-0 ma-0">
                <v-text-field dense v-model="account.address"></v-text-field>
              </v-col>
              <v-col cols="4" class="pa-0 ma-0">
                <div class="pt-3 pl-4"><b>ตำบล</b></div>
              </v-col>
              <v-col cols="8" class="pa-0 ma-0">
                <v-text-field dense v-model="account.district"></v-text-field>
              </v-col>
              <v-col cols="4" class="pa-0 ma-0">
                <div class="pt-3 pl-4"><b>อำเภอ</b></div>
              </v-col>
              <v-col cols="8" class="pa-0 ma-0">
                <v-text-field dense v-model="account.amphoe"></v-text-field>
              </v-col>
              <v-col cols="4" class="pa-0 ma-0">
                <div class="pt-3 pl-4"><b>จังหวัด</b></div>
              </v-col>
              <v-col cols="8" class="pa-0 ma-0">
                <v-text-field dense v-model="account.province"></v-text-field>
              </v-col>
              <v-col cols="4" class="pa-0 ma-0">
                <div class="pt-3 pl-4"><b>รหัสไปรษณีย์</b></div>
              </v-col>
              <v-col cols="8" class="pa-0 ma-0 mb-5">
                <v-text-field dense v-model="account.zipcode"></v-text-field>
              </v-col>

              <v-col cols="12" class="pa-2">
                <v-btn
                  depressed
                  block
                  tile
                  color="primary"
                  @click="save()"
                  :disabled="showAlert"
                  >บันทึก</v-btn
                >
              </v-col>
            </v-row>
          </v-form>
        </v-card>
      </v-col>
    </v-row>

</template>

<script>
import { HTTP } from "@/Connect/http";
import Customer from "@/Models/Customer";
export default {
  data() {
    return {
      showAlert: false,
      account: [],
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
    save() {
      console.log(this.account);

      try {
        HTTP.post(
          "http://localhost/adminAppLK/public/api/v1/customer/" +
            this.account.id,
          this.account
        ).then((res) => {
          if (res.data.data) {
            Customer.deleteAll();
            Customer.insert({
              data: {
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
                created_at: res.data.data.created_at,
              },
            });
            this.fnShowAlert();
          } else {
            console.log("err");
          }
        });
      } catch (error) {
        console.error(error);
      }
    },
    disableData() {
      console.log("ss");
    },
    fnShowAlert() {
      this.showAlert = true;
      setTimeout(() => {
        this.showAlert = false;
      }, 4000);
    },
  },
    created() {
    this.initial();
  },
};
</script>

<style></style>
