<template>
  <div>
    <v-card
      elevation="0"
      class="pa-2 ma-0 pa-0 mt-15 text-center"
      v-if="this.getData.length == 0"
    >
      <v-row no-gutters>
        <v-col cols="12" class="mt-15">
          <h4>เลือกสินค้าโดนใจใส่รถเข็นไว้เลย</h4>
        </v-col>
        <v-col cols="12" class="mt-5">
          <v-btn class="ma-2" outlined color="amber" to="/"
            >เลือกสินค้าตอนนี้</v-btn
          >
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
            tile
            elevation="3"
            class="mb-2 pa-2"
            v-for="(value, i) in getData"
            :key="i.id"
          >
            <v-row no-gutters>
              <v-col cols="1" class="pa-0 ma-0 mb-6">
                <v-icon class="grey--text text--dark-2">mdi-basket</v-icon>
              </v-col>
              <v-col cols="11" class="mt-1 mb-6">
                <b>{{ value.name }}++</b>
              </v-col>

              <v-card
                class="justBasket"
                elevation="0"
                :to="`/shop/${value.id}`"
              >
                <small class="text-caption lh1">
                  <b>
                    + เพิ่มรายการ
                  </b>
                </small>
              </v-card>

              <v-col cols="12" class="mt-n5 pl-9">
                <small><b>รายการสินค้า</b></small>
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
                        <!-- :change="cal()" -->
                        <VueNumberInput
                          readonly
                          v-model="vProduct.amount"
                          :change="cal()"
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
                  </v-row>
                </v-card>
                <!-- +++++++++++++++++++++++++++++++++ การจัดส่ง +++++++++++++++++++++++++++++++++-->
                <v-col class="12">
                  <small>การจัดส่ง</small>
                  <v-card elevation="0" class="pa-0 mb-1" color="#BEEAF6">
                    
                    <!-- @change="cal()" -->
                    <v-select
                      class="test"
                      solo
                      label="การจัดส่ง ( รวมน้ำหนักแล้ว )"
                      :items="value.deliveryFN"
                      v-model="value.deliveryId"
                      item-text="name"
                      item-value="id"
                      @change="cal()"
                    ></v-select>
                      <small v-if="value.deliveryName" >
                      <p class="mb-0 mt-n5 pb-2 pl-2">
                        <b> {{value.deliveryName}} {{value.deliveryPrice}} บาท</b>
                      </p>
                    </small>
                    <small>
                      <p class="mb-0 pb-2 pl-2">
                        จะได้รับสินค้าภายใน 1 วัน (ภายใน 24 ฃั่วโมง)
                      </p>
                    </small>
                  </v-card>
                </v-col>
                <!-- +++++++++++++++++++++++++++++++++ การจัดส่ง +++++++++++++++++++++++++++++++++-->
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
              <v-col cols="1"> </v-col>
              <v-col cols="5"> </v-col>
              <v-col cols="6" class="text-end">
                <v-btn
                  color="#FDC33D"
                  small
                  block
                  tile
                  @click="sendData()"
                  :disabled="checkDeliveryId"
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
    getData: '',
    style1: "NIinput1",
    style2: "NIinput2",
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
    showSend: false,
    dialog: false,
    dialog2: false,
    idProduct: "",
    idShop: "",
    checkDelivery: 0,
    test1:''
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

      this.getData.forEach((shop) => {
        let isWeightProduct = 0;
        shop.Basket.forEach((vBasket) => {
          isWeightProduct +=
            parseInt(vBasket.weight) * parseInt(vBasket.amount);
        });
        let data = [];

        shop.delivery.forEach((vDelivery) => {
          let data2 = {
            id: vDelivery.detail.id,
            name: vDelivery.detail.name,
            text: vDelivery.detail.name,
            price: 0,
          };

          let num = vDelivery.weight.length;
          let arr = [];
          let arr2 = [];

          vDelivery.weight.forEach((vWeight, i) => {
            if (isWeightProduct <= parseInt(vWeight.grams)) {
              if (arr.length === 0) {
                arr.push(vWeight.price);
              }
            } else {
              arr2.unshift(vWeight.price);
            }

            if (num === i + 1) {
              if (arr.length < 1) {
                data2.text += " " + arr2[0] * 1 + " บาท";
                data2.price = arr2[0] * 1;
              } else {
                data2.text += " " + arr[0] * 1 + " บาท";
                data2.price = arr[0] * 1;
              }
            }
          });
          data.push(data2);
        });
        shop.deliveryFN = data;
        // this.cal();
      });

      if (this.getData.length < 1) {
        this.showSend = true;
      }

      // console.log(this.getData);
    },
    async cal() {

      if (this.getData.length < 1) {
        this.summary.priceAll = 0;
        this.summary.shippingAll = 0;
        this.summary.totalAll = 0;
      }


      var priceAll = 0;
      var shippingAll = 0;

      // console.log("calllllllllllllllllll", this.getData);
      let dataGet = this.getData;
      dataGet.forEach((shop,index) => {


        let deliveryPrice = 0;
        let isWeightProduct = 0;
        shop.Basket.forEach((vBasket) => {
          isWeightProduct +=
            parseInt(vBasket.weight) * parseInt(vBasket.amount);
        });
        let data = [];
        shop.delivery.forEach((vDelivery) => {
          let data2 = {
            id: vDelivery.detail.id,
            name: vDelivery.detail.name,
            text: vDelivery.detail.name,
            price: 0,
          };

          let num = vDelivery.weight.length;
          let arr = [];
          let arr2 = [];

          vDelivery.weight.forEach((vWeight, i) => {
            if (isWeightProduct <= parseInt(vWeight.grams)) {
              if (arr.length === 0) {
                arr.push(vWeight.price);
              }
            } else {
              arr2.unshift(vWeight.price);
            }

            if (num === i + 1) {
              if (arr.length < 1) {
                data2.text += " " + arr2[0] * 1 + " บาท";
                data2.price = arr2[0] * 1;
              } else {
                data2.text += " " + arr[0] * 1 + " บาท";
                data2.price = arr[0] * 1;
              }
            }
          });
          data.push(data2);
          
        });
          // shop.deliveryFN = data;


        shop.deliveryFN.forEach((vDeliveryFN,i) => {
            console.log("vDeliveryFN",vDeliveryFN)
            console.log("data[i]",data[i])
            vDeliveryFN = data[i];
            console.log("vDeliveryFN++++++++++++",vDeliveryFN)
            this.getData[index].deliveryFN[i] = data[i];
        });

console.log("shop.deliveryFN",shop.deliveryFN)
        data.forEach((vDelivery) => {
          if (shop.deliveryId == vDelivery.id) {
            deliveryPrice = vDelivery.price;
            shop.deliveryPrice = vDelivery.price;
            shop.deliveryName = vDelivery.name;
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
      // console.log("this.getData",this.getData)
      this.summary.priceAll = priceAll;
      this.summary.shippingAll = shippingAll;
      this.summary.totalAll = priceAll + shippingAll;

        this.getData = dataGet;
      console.log("cccccccccccccccccccccccccccccccccccccccc+ ",dataGet)
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
      // console.log("0888008this.getData",this.getData);
      let checkLogin = Customer.query().first();
      if (checkLogin != null) {
        this.getData.forEach((d) => {
          // console.log(d);
          Shops.update({
            where: d.id,
            data: {
              name: d.name,
              delivery: d.delivery,
              deliveryFN: d.deliveryFN,
              deliveryPrice: d.deliveryPrice,
              deliveryId: d.deliveryId,
              deliveryName: d.deliveryName,
              price: d.price,
              shipping: d.shipping,
              total: d.total,
            },
          });
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
                deliveryCode: b.deliveryCode,
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

        // console.log("Shops.query() ",Shops.query()
        // .withAll()
        // .get())

        //go to confirm
        this.$router.push("/confirmOrders");
      } else {
        this.$router.push("/login");
      }
    },
  },
  watch: {
    "getData.Basket.amount"(){
      console.log(".....................")

    },
  },
  computed: {

    checkDeliveryId() {
      let n = 0;
      this.getData.forEach((shop) => {
        if (shop.deliveryId == "") {
          n++;
        }
      });
      if (n == 0) {
        return false;
      } else {
        return true;
      }
    }
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
