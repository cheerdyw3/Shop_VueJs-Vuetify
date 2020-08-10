<template>
  <div>
    
    <v-card elevation="0" class="pa-2 ma-0 pa-0 mt-15 text-center" v-if="this.getData.length == 0" >
      <v-row no-gutters>
        <v-col cols="12" class="mt-15">
          <h4>เลือกสินค้าโดนใจใส่รถเข็นไว้เลย</h4>
        </v-col>
        <v-col cols="12" class="mt-5">
          <v-btn class="ma-2" outlined color="amber" to="/">เลือกสินค้าตอนนี้</v-btn>
        </v-col>
      </v-row>
    </v-card>
    
    <v-card elevation="0" class="pa-0 ma-0" v-else>
      <v-card elevation="0" class="pa-2 ma-0 pa-0 mt-15">
        <h3>คำสั่งซื้อ</h3>
      </v-card>
      <v-row no-gutters>
        <v-col>
          <v-card
            elevation="0"
            class="mb-3"
            v-for="(value, i) in getData"
            :key="i.id"
          >
            <v-row no-gutters>
              <!-- <v-col cols="1" class="pa-0 ma-0">
              <v-checkbox
                color="#FFD814"
                class="pa-0 ma-0"
                v-model="selected"
                :value="value"
                @change="cal()"
              ></v-checkbox>
            </v-col> -->
              <v-col cols="1" class="pa-0 ma-0 mb-6">
                <v-icon class="grey--text text--dark-2">mdi-basket</v-icon>
              </v-col>
              <v-col cols="11" class="mt-1 mb-6">
                <b>{{ value.name }}</b>
              </v-col>

              <v-card
                class="justBasket"
                elevation="0"
                :to="`/shop/${value.id}`"
              >
                <small class="text-caption lh1">
                  + เพิ่มรายการ
                </small>
              </v-card>

              <v-col cols="12" class="mt-n5 pl-9">
                รายการสินค้า
              </v-col>
              <v-col cols="12">
                <v-card
                  elevation="1"
                  class="mb-0 px-9"
                  v-for="(vProduct, i) in value.Basket"
                  :key="i.id"
                >
                  <!-- {{vProduct.delivery}} -->
                  <v-row no-gutters>
                    <v-col cols="6" class="pa-0 ma-0 ">
                      <small>
                        <v-icon
                          class="red--text text--dark-2"
                          @click="deleteOrderDirectly(value.id, vProduct.id)"
                          >mdi-window-close</v-icon
                        >
                        <b>{{ vProduct.name }}</b>
                      </small>
                    </v-col>
                    <v-col cols="3" class="pa-0 ma-0">
                      <small class="text-caption lh1">
                        <VueNumberInput
                          readonly
                          v-model="vProduct.amount"
                          :change="cal2()"
                          :min="0"
                          :max="100"
                          :inputClass="style1"
                          :buttonIncClass="style2"
                          :buttonDecClass="style2"
                        >
                        </VueNumberInput>
                      </small>
                    </v-col>
                    <v-col cols="3" class="pa-0 ma-0 text-end">
                      <small class="text-caption lh1">
                        <b>{{ vProduct.price }} บาท</b>
                      </small>
                    </v-col>
                    <v-col class="12">
                      <small>การจัดส่ง</small>
                      <v-card elevation="0" class="pa-0 mb-1" color="#BEEAF6">
                        <v-select
                          class="test"
                          solo
                          label="การจัดส่ง ( รวมน้ำหนักแล้ว )"
                          :items="vProduct.delivery"
                          v-model="vProduct.deliveryId"
                          item-text="text"
                          item-value="id"
                          @change="cal2()"
                        ></v-select>
                        <small>
                          <p class="mb-0 mt-n5 pb-2 pl-2">
                            จะได้รับสินค้าภายใน 1 วัน (ภายใน 24 ฃั่วโมง)
                          </p>
                        </small>
                      </v-card>
                    </v-col>
                  </v-row>
                </v-card>
              </v-col>
            </v-row>
          </v-card>

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
                  @click="sendData()"
                  :disabled="showSend"
                  >ชำระเงิน</v-btn
                >
              </v-col>
            </v-row>
          </v-card>
        </v-col>
      </v-row>
      <v-row no-gutters>
        <v-dialog v-model="dialog" persistent max-width="290">
          <v-card>
            <v-card-title class="headline"
              >คุณแน่ใจว่าต้องลบหรือไม่?</v-card-title
            >
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
                    @click="deleteOrder()"
                    >ใช่</v-btn
                  >
                </v-col>
              </v-row>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-row>
      <v-row no-gutters>
        <v-dialog v-model="dialog2" persistent max-width="290">
          <v-card>
            <v-card-title class="headline"
              >คุณแน่ใจว่าต้องลบหรือไม่?</v-card-title
            >
            <v-card-actions class="pa-0">
              <v-row justify="center" class="pa-0 ma-0">
                <v-col cols="6" class="pa-0">
                  <v-btn
                    color="yellow darken-2"
                    tile
                    text
                    block
                    outlined
                    @click="dialog2 = false"
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
                    @click="deleteOrderDirectly()"
                    >ใช่</v-btn
                  >
                </v-col>
              </v-row>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-row>
    </v-card>
  </div>
</template>

<script>
// import { HTTP } from "@/Connect/http";
import VueNumberInput from "@smartweb/vue-number-input";
import Basket from "@/Models/Basket";
import Customer from "@/Models/Customer";
import Shops from "@/Models/Shops";

export default {
  name: "Home",
  data: () => ({
    title: "ภูมิภาค",
    API: process.env.VUE_APP_API,
    getData: [],
    selected: [],
    style1: "NIinput1",
    style2: "NIinput2",
    summary: {
      priceAll: 0,
      shippingAll: 0,
      totalAll: 0,
    },
    showSend: false,
    dialog: false,
    dialog2: false,
    idProduct: "",
    idShop: "",
    checkDelivery: 0,
  }),
  components: {
    VueNumberInput,
  },
  created() {
    this.initialize();
  },
  methods: {
    async initialize() {
      this.getData = Shops.query()
        .withAll()
        .get();
      if (this.getData.length < 1) {
        this.showSend = true;
      }
    },
    cal() {
      let data = this.selected;
      if (data.length < 1) {
        // this.showSend = false;
        this.summary.priceAll = 0;
        this.summary.shippingAll = 0;
        this.summary.totalAll = 0;
      } else {
        // this.showSend = true;
      }

      var priceAll = 0;
      var shippingAll = 0;
      for (let d = 0; d < data.length; d++) {
        for (let b = 0; b < data[d].Basket.length; b++) {
          let deliveryId = data[d].Basket[b].deliveryId;
          let price = parseInt(data[d].Basket[b].price);
          let amount = parseInt(data[d].Basket[b].amount);
          priceAll += price * amount;
          // console.log("price ",price ,"*","amount ",amount , "total=",price*amount)
          // console.log(priceAll)
          for (let dv = 0; dv < data[d].Basket[b].delivery.length; dv++) {
            let id = data[d].Basket[b].delivery[dv].id;
            let deliveryPrice = parseInt(data[d].Basket[b].delivery[dv].price);
            if (deliveryId === id) {
              shippingAll += deliveryPrice * amount;
              // console.log("deliveryPrice ",deliveryPrice ,"*","amount ",amount , "total=",deliveryPrice*amount)
              // console.log(shippingAll)
            }
          }
        }

        // console.log("++++++++++++++++")
      }
      this.summary.priceAll = priceAll;
      this.summary.shippingAll = shippingAll;
      this.summary.totalAll = priceAll + shippingAll;
    },
    cal2() {
      let data = this.getData;
      if (data.length < 1) {
        this.summary.priceAll = 0;
        this.summary.shippingAll = 0;
        this.summary.totalAll = 0;
      }

      var priceAll = 0;
      var shippingAll = 0;
      for (let d = 0; d < data.length; d++) {
        // console.log(data[d].id)

        for (let b = 0; b < data[d].Basket.length; b++) {
          let deliveryId = data[d].Basket[b].deliveryId;
          let price = parseInt(data[d].Basket[b].price);
          let amount = parseInt(data[d].Basket[b].amount);

          // console.log(data[d].Basket[b].deliveryId);
          // console.log(data[d].Basket[b].deliveryName);
          // console.log(data[d].Basket[b].deliveryPrice);

          //delete
          if (amount != 0) {
            priceAll += price * amount;
            // console.log("price ",price ,"*","amount ",amount , "total=",price*amount)
            // console.log(priceAll)
            for (let dv = 0; dv < data[d].Basket[b].delivery.length; dv++) {
              let id = data[d].Basket[b].delivery[dv].id;
              let deliveryPrice = parseInt(
                data[d].Basket[b].delivery[dv].price
              );
              if (deliveryId === id) {
                data[d].Basket[b].deliveryName =
                  data[d].Basket[b].delivery[dv].name;
                // console.log("+++",data[d].Basket[b].delivery[dv].name)
                // console.log("---",data[d].Basket[b].deliveryName)
                data[d].Basket[b].deliveryPrice =
                  data[d].Basket[b].delivery[dv].price;

                shippingAll += deliveryPrice * amount;
                // console.log("deliveryPrice ",deliveryPrice ,"*","amount ",amount , "total=",deliveryPrice*amount)
                // console.log(shippingAll)
              }
            }
          } else {
            data[d].Basket[b].amount = 1;
            this.idShop = data[d].id;
            this.idProduct = data[d].Basket[b].id;

            this.dialog = true;
          }
          // console.log("++++++++++++++++",data[d])
        }
      }
      this.summary.priceAll = priceAll;
      this.summary.shippingAll = shippingAll;
      this.summary.totalAll = priceAll + shippingAll;
    },
    deleteOrder() {
      Basket.delete(this.idProduct);
      let findShop = Shops.query()
        .whereId(this.idShop)
        .withAll()
        .first();

      if (findShop.Basket.length < 1) {
        Shops.delete(this.idShop);
      }

      this.dialog = false;
      this.initialize();
    },

    deleteOrderDirectly(idShop, idProduct) {
      if (idShop && idProduct) {
        this.dialog2 = true;
        this.idProduct = idProduct;
        this.idShop = idShop;
      } else {
        Basket.delete(this.idProduct);
        let findShop = Shops.query()
          .whereId(this.idShop)
          .withAll()
          .first();

        if (findShop.Basket.length < 1) {
          Shops.delete(this.idShop);
        }
        this.dialog2 = false;
        this.initialize();
      }
    },
    sendData() {
      console.log(this.getData)
      let checkLogin = Customer.query().first();
      if (checkLogin != null) {
        //update basket
        this.getData.forEach((d) => {
          d.Basket.forEach((b) => {
            Basket.update({
              where: b.id,
              data: {
                amount: b.amount,
                discount: b.discount,
                totalPrice: b.totalPrice,
                id: b.id,
                created_at: b.created_at,
                deliveryId: b.deliveryId,
                deliveryCode:b.deliveryCode,
                deliveryName: b.deliveryName,
                deliveryPrice: b.deliveryPrice,
                delivery: b.delivery,
                description: b.description,
                image: b.image,
                member_id: b.member_id,
                name: b.name,
                price: b.price,
                souvenir_group_id: b.souvenir_group_id,
                orderStatus: b.orderStatus,
                unit_id: b.unit_id,
                weight: b.weight,
              },
            });
          });
        });
        //go to confirm
        this.$router.push("/confirmOrders");
      } else {
        this.$router.push("/login");
      }
    },
  },
  computed: {
    selectAll: {
      get: function() {
        // this.cal();
        return this.getData
          ? this.selected.length == this.getData.length
          : false;
      },
      set: function(value) {
        var selected = [];
        if (value) {
          this.getData.forEach((data) => {
            selected.push(data);
          });
        }
        this.selected = selected;
        this.cal();
      },
    },
  },
  watch: {
    selected() {
      this.selected.length < 1
        ? (this.showSend = true)
        : (this.showSend = false);
    },
  },
};
</script>
<style>
.v-application small.lh1 {
  line-height: 0.4em;
}
.NIinput1 {
  text-align: center;
  height: 10px;
}
.NIinput2 {
  height: 25px;
  line-height: 0px;
}
.justBasket {
  position: absolute;
  right: 5px;
}
.test {
  font-size: 0.8em;
}
</style>
