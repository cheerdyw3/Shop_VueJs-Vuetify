<template>
  <v-card elevation="0" title>
    <v-row no-gutters>
      <v-col cols="12" class="py-0 pa-2">
        <v-card
          elevation="2"
          tile
          class="pa-2 ma-0 mt-2 pb-3"
          v-for="shops in shopsOrders"
          :key="shops.id"
        >
          <v-row no-gutters class="lineH">
            <v-col cols="12" class="pa-0">
              <v-icon class="grey--text text--dark-2 mr-1" size="20"
                >mdi-checkbox-marked-circle</v-icon
              >
              <b>หมายเลขคำสั่งซื้อ {{ shops.order_id }}</b>
            </v-col>
            <v-card class="justBasket" elevation="0">
              <small class="text-caption lh1">
                <v-btn x-small color="warning" @click="shopOrderId=shops.id,dialog=true">ยืนยัน</v-btn>
              </small>
            </v-card>
            <v-card class="pa-5 py-0 py-2 mt-1" elevation="1">
              <small>
                <v-row no-gutters>
                  <v-col cols="12" class="pa-0">
                    ที่อยู่ในการจัดส่ง
                  </v-col>
                  <v-col cols="12" class="pa-0 pt-1">
                    <b>{{ shops.deliveryNameAddress }}</b>
                  </v-col>
                  <v-col cols="12" class="pa-0">
                    <b>{{ shops.deliveryAddress }}</b>
                  </v-col>
                  <v-col cols="12" class="pa-0 pt-1">
                    <b> การขนส่ง {{ shops.deliveryName }}</b>
                  </v-col>
                </v-row>
              </small>
            </v-card>
          </v-row>
          <v-card class="pa-0 mt-1" elevation="1">
            <v-row no-gutters>
              <b>รายการสินค้า</b>
              <v-col cols="12" class="pa-0">
              <v-card
                elevation="0"
                class="px-3 mx-2"
                v-for="orDetail in shops.orders_detail"
                :key="orDetail.id"
              >
                <v-row no-gutters>
                  <v-col cols="12" class="pa-0">
                    <small>
                      <v-row no-gutters class="lineH">
                        <v-col cols="5" class="pa-0 ">
                          <b>{{ orDetail.name }}</b>
                        </v-col>
                        <v-col cols="2" class="pa-0">
                          <b>x{{ orDetail.amount }}</b>
                        </v-col>
                        <v-col cols="3" class="pa-0 text-end">
                          <b>฿{{ Number(orDetail.price).toLocaleString() }}</b>
                        </v-col>
                      </v-row>
                    </small>
                  </v-col>
                </v-row>
                
              </v-card>
              </v-col>
              <v-col cols="7" class="pa-0 text-end">
                <h5>รวมสินค้าทั้งหมด</h5>
              </v-col>
              <v-col cols="3" class="pa-0 text-end pr-3">
                <h5>฿{{shops.price}}</h5>
              </v-col>
              
            </v-row>
          </v-card>
        </v-card>
      </v-col>
    </v-row>
        <v-row no-gutters>
      <v-dialog v-model="dialog" persistent max-width="290">
        <v-card>
          <v-card-title class="headline">ยืนยันคำสั่งซื้อ</v-card-title>
          <v-card-actions class="pa-0">
            <v-row justify="center" class="pa-0 ma-0">
              <v-col cols="6" class="pa-0">
                <v-btn
                  color="yellow darken-2"
                  tile
                  text
                  block
                  outlined
                  @click="dialog = false"
                  >ไม่</v-btn
                >
              </v-col>
              <v-col cols="6" class="pa-0">
                <v-btn
                  color="yellow darken-2"
                  tile
                  text
                  block
                  outlined
                  @click="sendData()"
                  >ใช่</v-btn
                >
              </v-col>
            </v-row>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-row>
  </v-card>
</template>

<script>
import { HTTP } from "@/Connect/http";
import moment from "moment";
import Member from "@/Models/Member";

export default {
  name: "orders1",
  data() {
    return {
      API: process.env.VUE_APP_API,
      orders: "",
      shopsOrders: "",
      dialog: false,
      shopOrderId:''
    };
  },
  methods: {
    async initialize() {
      try {
        await HTTP.get(
          "http://localhost/adminAppLK/public/api/v1/shopsOrders/show/" +
            Member.query().first().id+"/0"
        ).then((res) => {
          if (res.data.data) {
            this.shopsOrders = res.data.data;
            console.log("++ ", this.shopsOrders);
          }
        });
      } catch (e) {
        console.log(e);
      }
    },
   async sendData() {
      console.log("id++++ ",this.shopOrderId)
        try {
        await HTTP.post(
          "http://localhost/adminAppLK/public/api/v1/shopsOrders/" +this.shopOrderId,{orderStatus:"1"} 
        ).then((res) => {
          if (res.data.data) {
            console.log("++ ", res.data.data);
            this.dialog = false;
            this.initialize();
          }
        });
      } catch (e) {
        console.log(e);
      }
    },
    moment: function(date) {
      return moment(date);
    },
  },
  watch: {
    tab() {
      this.initialize();
    },
  },
  props: {
    tab: Number,
  },
  created() {
    this.initialize();
  },
};
</script>

<style>
.v-application small.lh1 {
  line-height: 0.4em;
}
.lineH {
  line-height: 16px;
}
.justEMS {
  position: absolute;
  bottom: 11px;
}
.justBasket {
  position: absolute;
  right: 5px;
}
</style>
