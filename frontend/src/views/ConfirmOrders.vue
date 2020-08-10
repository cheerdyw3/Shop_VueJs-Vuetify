<template>
  <v-card elevation="0" class="pa-0 ma-0">
    <v-card elevation="0" class="pa-2 ma-0 pa-0 mt-15">
      <h3>ทำการสั่งซื้อ</h3>
    </v-card>
    <v-row no-gutters>
      <v-col>
        <v-card elevation="0" class="pa-2 ma-0 pa-0">
          <v-row no-gutters>
            <v-col cols="1" class="mt-n1">
              <v-icon class="grey--text text--dark-2">mdi-map-marker</v-icon>
            </v-col>
            <v-col cols="11">
              <b>ที่อยู่สำหรับจัดส่ง</b>
            </v-col>
            <v-col cols="12">
              <v-alert dense outlined :type="checkAddress" class="ma-0">
                <v-card
                  elevation="0"
                  class="pa-0 ma-0 "
                  @click="dialogAccount = true"
                >
                  <v-row no-gutters>
                    <small class="text-caption lh1">
                      <v-col cols="12" class="mt-n1">
                        คุณ {{ getCustomer.name }} {{ getCustomer.surname }} |
                        {{ getCustomer.phone }}
                      </v-col>
                      <v-col cols="12" class="mt-n3">
                        ที่อยู่ {{ getCustomer.address }} ต.{{
                          getCustomer.district
                        }}
                        อ.{{ getCustomer.amphoe }} จ.{{ getCustomer.province }}
                        {{ getCustomer.zipcode }}
                      </v-col>
                    </small>
                    <v-row no-gutters class="justify-end">
                      <v-icon class="grey--text text--dark-2 "
                        >mdi-menu-right</v-icon
                      >
                    </v-row>
                  </v-row>
                </v-card>
              </v-alert>
            </v-col>
            <v-col cols="1" class="mt-2">
              <v-icon class="grey--text text--dark-2">mdi-view-list</v-icon>
            </v-col>
            <!-- ********************************************* -->
            <v-col cols="11" class="mt-2">
              <b>สรุปคำสั่งซื้อ</b>
            </v-col>
            <v-col cols="12">
              <v-card elevation="1" class="pa-2 ma-0">
                <v-row no-gutters>
                  <v-col>
                    <v-card
                      tile
                      elevation="3"
                      class="mb-3 pt-2 pa-2"
                      v-for="(value, i) in getData"
                      :key="i.id"
                    >
                      <v-row no-gutters>
                        <v-col cols="12" class="mt-1 mb-6">
                          <b>{{ value.name }}</b>
                        </v-col>

                        <v-col cols="12" class="mt-n5 pl-9">
                          <b> รายการสินค้า</b>
                        </v-col>
                        <v-col cols="12">
                          <v-card
                            elevation="0"
                            class="mb-0 px-9"
                            v-for="(vProduct, i) in value.Basket"
                            :key="i.id"
                          >
                            <v-row no-gutters>
                              <v-col cols="6" class="pa-0 ma-0 ">
                                <small
                                  ><b
                                    >{{ vProduct.name }} {{ vProduct.id }}</b
                                  ></small
                                >
                              </v-col>
                              <v-col cols="3" class="pa-0 ma-0">
                                <small class="text-caption lh1">
                                  <b>x{{ vProduct.amount }}</b>
                                </small>
                              </v-col>
                              <v-col cols="3" class="pa-0 ma-0 text-end">
                                <small class="text-caption lh1">
                                  <b>{{ vProduct.price }} บาท</b>
                                </small>
                              </v-col>
                            </v-row>
                          </v-card>
                          <v-col class="12">
                            <small>การจัดส่ง</small>
                            <v-card
                              elevation="0"
                              class="pa-0 mb-1"
                              color="#BEEAF6"
                            >
                              <v-select
                                disabled
                                class="test"
                                solo
                                label="การจัดส่ง ( รวมน้ำหนักแล้ว )"
                                :items="value.deliveryFN"
                                v-model="value.deliveryId"
                                item-text="text"
                                item-value="id"
                                @change="cal()"
                              ></v-select>
                              <small>
                                <p class="mb-0 mt-n5 pb-2 pl-2">
                                  จะได้รับสินค้าภายใน 1 วัน (ภายใน 24 ฃั่วโมง)
                                </p>
                              </small>
                            </v-card>
                          </v-col>
                        </v-col>
                      </v-row>
                    </v-card>
                    <!-- ************** -->
                    <v-card elevation="0" class="px-15 pa-2" color="#E3E4E5">
                      <v-row no-gutters>
                        <v-col cols="8" class="pa-0 ma-0">
                          <small><b>รวมราคาสินค้า</b></small>
                        </v-col>
                        <v-col cols="4" class="pa-0 ma-0">
                          <small
                            ><b>{{ summary.priceAll }} บาท</b></small
                          >
                        </v-col>

                        <v-col cols="8" class="pa-0 ma-0">
                          <small><b>ค่าจัดส่งรวม</b></small>
                        </v-col>
                        <v-col cols="4" class="pa-0 ma-0">
                          <small
                            ><b>{{ summary.shippingAll }} บาท</b></small
                          >
                        </v-col>

                        <v-col cols="8" class="pa-0 ma-0 mt-2">
                          <small><b>รวมราคาสินค้า</b></small>
                        </v-col>
                        <v-col cols="4" class="pa-0 ma-0 mt-2">
                          <small
                            ><b>{{ summary.totalAll }} บาท</b></small
                          >
                        </v-col>
                      </v-row>
                    </v-card>
                    <!-- ********************************* -->
                    <v-card elevation="0" class="py-2">
                      <v-row no-gutters>
                        <!-- <v-col cols="1" class="pa-0 ma-0">
              <v-checkbox
                color="#FFD814"
                class="pa-0 ma-0"
                v-model="selectAll"
              ></v-checkbox>
            </v-col>
            <v-col cols="5">
              <b>เลือกทั้งหมด</b>
            </v-col> -->
                        <v-col cols="1"> </v-col>
                        <v-col cols="5"> </v-col>
                        <v-col cols="6" class="text-end">
                          <v-btn
                            color="#FDC33D"
                            small
                            block
                            tile
                            @click="dialog = true"
                            >ยืนยัน</v-btn
                          >
                        </v-col>
                      </v-row>
                    </v-card>
                  </v-col>
                </v-row>
              </v-card>
            </v-col>
          </v-row>
        </v-card>
      </v-col>
    </v-row>

    <!-- start dialog -->
    <v-dialog
      v-model="dialogAccount"
      fullscreen
      hide-overlay
      transition="dialog-bottom-transition"
      :retain-focus="false"
    >
      <v-card>
        <v-toolbar dark color="primary">
          <v-btn icon dark @click="dialogAccount = false">
            <v-icon>mdi-close</v-icon>
          </v-btn>
          <v-toolbar-title>ข้อมูลส่วนตัว</v-toolbar-title>
        </v-toolbar>
        <v-row no-gutters>
          <v-col cols="12" class="py-0 pa-2">
            <v-card elevation="2" tile class="pa-3 ma-0 mt-2">
              <v-row no-gutters>
                <Account></Account>
              </v-row>
            </v-card>
          </v-col>
        </v-row>
      </v-card>
    </v-dialog>
    <!-- end dialog -->

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
import Customer from "@/Models/Customer";
import Basket from "@/Models/Basket";
import Shops from "@/Models/Shops";

import Account from "@/components/Account";
// import VueNumberInput from "@smartweb/vue-number-input";

export default {
  data() {
    return {
      dCustomer: "",
      getData: [],
      summary: {
        priceAll: 0,
        shippingAll: 0,
        totalAll: 0,
      },
      shopSummary: {
        price: 0,
        shipping: 0,
        total: 0,
      },
      userId: "",
      dialogAccount: false,
      dialog: false,
      typeAlert: "success",
    };
  },
  methods: {
    async initialize() {
      this.getData = Shops.query()
        .withAll()
        .get();

      this.cal();
      this.dCustomer = Customer.query().first().id;
    },

    cal() {
      if (this.getData.length < 1) {
        this.summary.priceAll = 0;
        this.summary.shippingAll = 0;
        this.summary.totalAll = 0;
      }
      var priceAll = 0;
      var shippingAll = 0;

      this.getData.forEach((shop) => {
        let deliveryPrice = 0;
        shop.deliveryFN.forEach((vDelivery) => {
          if (shop.deliveryId == vDelivery.id) {
            deliveryPrice = vDelivery.price;
          }
        });
        let shopPrice = 0;
        let shopShipping = 0;
        let shopTotol = 0;

        shop.Basket.forEach((vBasket) => {
          let price = parseInt(vBasket.price);
          let amount = parseInt(vBasket.amount);
          //delete
          if (amount != 0) {
            priceAll += price * amount;
            shippingAll += deliveryPrice * amount;

            shopPrice += price * amount;
            shopShipping += deliveryPrice * amount;
          } else {
            vBasket.amount = 1;
            this.idShop = shop.id;
            this.idProduct = vBasket.id;
            this.dialog = true;
          }
        });
        shopTotol = shopPrice + shopShipping;
        shop.price = shopPrice;
        shop.shipping = shopShipping;
        shop.total = shopTotol;
      });

      console.log("this.getData", this.getData);
      this.summary.priceAll = priceAll;
      this.summary.shippingAll = shippingAll;
      this.summary.totalAll = priceAll + shippingAll;
    },
    async sendData() {
      try {
        if (this.checkAddress != "error") {
          //create Order
          let arr = {
            priceAll: this.summary.priceAll,
            shippingAll: this.summary.shippingAll,
            totalAll: this.summary.totalAll,
            userId: this.dCustomer,
          };
          console.log(this.getCustomer);
          let nameAddress =
            "คุณ " +
            this.getCustomer.name +
            " " +
            this.getCustomer.surname +
            " | " +
            this.getCustomer.phone;
          let address =
            "ที่อยู่ " +
            this.getCustomer.address +
            " ต." +
            this.getCustomer.district +
            " อ." +
            this.getCustomer.amphoe +
            " จ." +
            this.getCustomer.province +
            " " +
            this.getCustomer.zipcode;
          console.log(nameAddress);
          console.log(address);
          console.log("Shops.query().first()", Shops.query().all());
          console.log("Basket.query().first()", Basket.query().all());
          await HTTP.post(
            "http://localhost/adminAppLK/public/api/v1/orders",
            arr
          ).then((res) => {
            if (res.data.data) {
              //create Order Detail
              var ordersId = res.data.data.id;
              Basket.query()
                .all()
                .forEach((value) => {
                  value.ordersId = ordersId;
                  HTTP.post(
                    "http://localhost/adminAppLK/public/api/v1/ordersDetail",
                    value
                  ).then((res) => {
                    if (res.data.data) {
                      // var ordersDetailId = res.data.data.id;
                      console.log(res.data.data);
                    }
                  });
                });

              Shops.query()
                .all()
                .forEach((value) => {
                  value.ordersId = ordersId;
                  value.deliveryAddress = address;
                  value.deliveryNameAddress = nameAddress;
                  HTTP.post(
                    "http://localhost/adminAppLK/public/api/v1/shopsOrders",
                    value
                  ).then((res) => {
                    if (res.data.data) {
                      console.log(res.data.data);
                    }
                  });
                });
            }
          });

          Shops.deleteAll();
          Basket.deleteAll();
          this.$router.push("/OderDetails").catch(() => {});
        }
      } catch (err) {
        console.error(err);
      }
    },
  },
  computed: {
    getCustomer() {
      return Customer.query().first();
    },
    checkAddress() {
      let check = Customer.query().first();
      if (
        check.name &&
        check.surname &&
        check.phone &&
        check.address &&
        check.amphoe &&
        check.email &&
        check.province
      ) {
        return "success";
      } else {
        return "error";
      }
    },
  },
  created() {
    this.initialize();
  },
  components: {
    Account,
  },
};
</script>

<style>
.v-application small.lh1 {
  line-height: 0.4em;
}
.test {
  font-size: 0.8em;
}
.checkAddress {
  border-width: 4px;
}
</style>
