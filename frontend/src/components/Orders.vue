<template>
  <v-card elevation="0" title>
    <v-card elevation="0" class="pa-2 ma-0 pa-0">
      <h4>คำสั่งซื้อ</h4>
    </v-card>
    <v-row no-gutters>
      <v-col cols="12" class="py-0">
        <v-card
          tile
          elevation="2"
          class="pa-3 ma-0 mt-2"
          v-for="order in orders"
          :key="order.id"
          @click="OpenDialog(order)"
        >
          <v-row no-gutters class="lineH">
            <v-col cols="9" class="pa-0">
              <b>ออเดอร์ # {{ order.id }}</b>
            </v-col>
            <!-- <v-col cols="8" class="pa-0 ml-n3">
              <b v-if="order.status == 0">รอการชำระเงิน</b>
              <b v-if="order.status == 1">ส่งแล้ว</b>
            </v-col> -->
            <v-col cols="3" class="pa-0 mb-2 text-end">
              <small class="">รายละเอียดสินค้า</small>
              <span>
                <v-icon size="15" class="">mdi-play</v-icon>
              </span>
            </v-col>
            <v-col cols="12" class="pa-0 text-end">
              <!-- <b>{{ order.orders_detail.length }}</b> สินค้า ยอดรวม: -->
              <b>฿{{ Number(order.price).toLocaleString() }}</b> ค่าขนส่ง:
              <b>฿{{ Number(order.shipping).toLocaleString() }} </b>
            </v-col>
            <v-col cols="12" class="pa-0 text-end">
              ยอดรวมทั้งหมด:<b> ฿{{ Number(order.total).toLocaleString() }}</b>
            </v-col>
            <v-col cols="12" class="pa-0 text-end">
              <small>
                สั่งซื้อวันที่
                {{ moment(order.created_at).format("DD/MM/YYYY, h:mm:ss") }}
              </small>
            </v-col>
          </v-row>
        </v-card>
      </v-col>
    </v-row>

    <!-- start dialog -->
    <v-dialog
      v-model="dialog"
      fullscreen
      hide-overlay
      transition="dialog-bottom-transition"
      :retain-focus="false"
    >
      <v-card>
        <v-toolbar dark color="primary">
          <v-btn icon dark @click="dialog = false">
            <v-icon>mdi-close</v-icon>
          </v-btn>
          <v-toolbar-title>รายละอียดคำสั่งซื้อ</v-toolbar-title>
        </v-toolbar>
        <v-card elevation="0" class="pa-2 ma-0 pa-0">
          <h4>ออเดอร์ # {{ shopsOrders.id }}</h4>
        </v-card>
        <v-row no-gutters>
          <v-col cols="12" class="py-0 pa-2">
            <v-card
              elevation="2"
              tile
              class="pa-2 ma-0 mt-2 pb-3"
              v-for="shops in shopsOrders.shops_orders"
              :key="shops.id"
            >
              <v-row no-gutters class="lineH">
                <small>
                  <v-col cols="12" class="pa-0">
                    <v-icon class="grey--text text--dark-2 mr-1" size="20"
                      >mdi-home</v-icon
                    >
                    <b>ร้าน {{ shops.member.name }}</b>
                  </v-col>
                  <v-col cols="12" class="pa-0">
                    รวมราคาสินค้า:
                    <b>฿{{ Number(shops.price).toLocaleString() }}</b>
                  </v-col>
                  <v-col cols="12" class="pa-0">
                    รวมราคาส่ง:
                    <b>฿{{ Number(shops.shipping).toLocaleString() }}</b>
                  </v-col>
                  <v-col cols="12" class="pa-0">
                    รวมราคา:
                    <b>฿{{ Number(shops.total).toLocaleString() }}</b>
                  </v-col>
                  <v-col cols="12" class="pa-0">
                    รูปแบบการส่ง: <b>{{ shops.deliveryName }}</b>
                  </v-col>
                  <v-col cols="12" class="pa-0">
                    สถานะ:
              <b v-if="shops.orderStatus == 0" class="orange--text">รอการชำระเงิน</b>
              <b v-if="shops.orderStatus == 1" class="green--text">ส่งแล้ว</b>
                  </v-col>
                  <v-col cols="12" class="pa-0">
                    รายการสินค้า :
                  </v-col>
                </small>
              </v-row>
              <v-card
                elevation="0"
                class="px-3 mt-2"
                v-for="orDetail in shops.orders_detail"
                :key="orDetail.id"
              >
                <!-- {{orDetail}} -->

                <v-row no-gutters>
                  <v-col cols="4">
                    <v-card>
                      <v-img :src="`${API}${orDetail.image}`" contain></v-img>
                    </v-card>
                  </v-col>
                  <v-col cols="8" class="pl-2">
                    <small>
                      <v-row no-gutters class="lineH">
                        <v-col cols="12" class="pa-0 ">
                          <b>{{ orDetail.name }}</b>
                        </v-col>
                        <v-col cols="12" class="pa-0 ">
                          ราคา:
                          <b>฿{{ Number(orDetail.price).toLocaleString() }}</b>
                        </v-col>
                        <v-col cols="12" class="pa-0 ">
                          จำนวน: <b>x{{ orDetail.amount }}</b>
                        </v-col>
                      </v-row>
                    </small>
                  </v-col>
                </v-row>
              </v-card>
            </v-card>
          </v-col>
        </v-row>
      </v-card>
    </v-dialog>
    <!-- end dialog -->
  </v-card>
</template>

<script>
import { HTTP } from "@/Connect/http";
import moment from "moment";
import Customer from "@/Models/Customer";

export default {
  name: "orders1",
  data() {
    return {
      API: process.env.VUE_APP_API,
      orders: "",
      shopsOrders: "",
      dialog: false,
    };
  },
  methods: {
    async initialize() {
      try {
        await HTTP.get(
          "http://localhost/adminAppLK/public/api/v1/orders/show/" +
            Customer.query().first().id
        ).then((res) => {
          if (res.data.data) {
            this.orders = res.data.data;
            console.log("++ ", this.orders);
          }
        });
      } catch (e) {
        console.log(e);
      }
    },
    OpenDialog(order) {
      this.shopsOrders = order;
      console.log(this.shopsOrders);
      this.dialog = true;
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
</style>
