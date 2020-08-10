<template>
  <v-card elevation="0" class="pa-0 ma-0">
    <v-card elevation="2" class="pa-0 ma-0 mt-15">
      <v-img :src="`${API}${shop.image}`" contain></v-img>
      <div class="pa-2">
        <h3>{{ shop.shop }}</h3>
        <p class="pa-0 ma-0">
          {{ shop.address }} {{ shop.district }} {{ shop.amphoe }}
          {{ shop.province }} {{ shop.zipcode }}
        </p>
      </div>
    </v-card>
    <v-card elevation="0" class="pa-2 ma-0 pa-0 mt-2">
      <h3>รายการสินค้า</h3>
    </v-card>
    <v-card
      elevation="2"
      class="mb-2 pa-2"
      v-for="(s, i) in shop.souvenir"
      :key="i.id"
    >
      <v-row no-gutters>
        <v-col cols="5">
          <v-card>
            <v-img :src="`${API}${s.image}`" contain></v-img>
          </v-card>
        </v-col>
        <!-- +++++++++++++++++++++++++++++++เพิ่มลงตะกร้า -->
        <div
          class="justBasket"
          v-if="s.amount != 0 "
          @click="saveData(s, shop.id, shop.shop , shop.delivery)"
        >
          <small class="text-caption lh1">
            + เพิ่มลงตะกร้า
            <v-icon class="yellow--text text--dark-2">mdi-basket</v-icon>
          </small>
        </div>
        <!-- +++++++++++++++++++++++++++++++เพิ่มลงตะกร้า -->

        <v-col cols="7" class="pl-2">
          <b>{{ s.name }}</b
          ><br />
          <small class="text-caption lh1">
            {{ s.description }} <br />
            น้ำหนัก {{ s.weight }} กรัม <br />
            ราคา {{ s.price }} <br />
            <v-col cols="7" class="pa-1">
              <VueNumberInput
                readonly
                v-model="s.amount"
                :min="0"
                :max="100"
                :inputClass="style1"
                :buttonIncClass="style2"
                :buttonDecClass="style2"
              ></VueNumberInput>
            </v-col>
          </small>
        </v-col>

        <!-- +++++++++++++++++++++++++ -->
        <!-- <v-card elevation="0" class="px-2 ma-0">
          <h4>ตัวเลือกการจัดส่ง</h4>
        </v-card>

        <v-col cols="12" class="mb-1">
          <v-card elevation="0" class="pa-0 mb-1" color="#BEEAF6">
            <v-select
              class="test"
              solo
              chips
              label="การจัดส่ง ( รวมน้ำหนักแล้ว )"
              :items="s.delivery"
              v-model="s.deliveryId"
              item-text="text"
              item-value="id"
            ></v-select>
            <small>
              <p class="mb-0 mt-n5 pb-2 pl-2">
                จะได้รับสินค้าภายใน 1 วัน (ภายใน 24 ฃั่วโมง)
              </p>
            </small>
          </v-card>
        </v-col> -->
        <!-- +++++++++++++++++++++++++ -->
      </v-row>
    </v-card>
    <v-overlay :value="overlay">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
  </v-card>
</template>

<script>
// @ is an alias to /src
import { HTTP } from "@/Connect/http";
import VueNumberInput from "@smartweb/vue-number-input";
import ProductList from "@/Models/ProductList";
import Basket from "@/Models/Basket";
import Shops from "@/Models/Shops";

export default {
  name: "Home",
  data: () => ({
    title: "ภูมิภาค",
    shop: [],
    API: process.env.VUE_APP_API,
    style1: "NIinput1",
    style2: "NIinput2",
    Show1: true,
    overlay: false
  }),
  components: {
    VueNumberInput,
  },
  created() {
    this.overlay = true;
    this.initialize();
  },
  methods: {
    async initialize() {
      try {
        HTTP.get("member/show/" + this.$route.params.id).then((res) => {
          let shop = res.data.data.souvenir;
          for (let s = 0; s < shop.length; s++) {
            //let data = [];
            shop[s].amount = 1;
            shop[s].deliveryId = "";
            shop[s].deliveryName = "";
            shop[s].deliveryPrice = "";
            // for (let d = 0; d < shop[s].delivery.length; d++) {
            //   // console.log("shop[s].delivery[d]", shop[s].delivery[d]);
            //   let data2 = {
            //     id: shop[s].delivery[d].detail.id,
            //     name: shop[s].delivery[d].detail.name,
            //     text: shop[s].delivery[d].detail.name,
            //     price: 0,
            //   };
            //   data.push(data2);
            //   let arr = [];
            //   let arr2 = [];
            //   for (let w = 0; w < shop[s].delivery[d].weight.length; w++) {
            //     let weight = parseInt(shop[s].weight);
            //     let rate = parseInt(shop[s].delivery[d].weight[w].grams);
            //     let num = shop[s].delivery[d].weight.length;
            //     if (weight <= rate) {
            //       if (arr.length === 0) {
            //         arr.push(shop[s].delivery[d].weight[w].price);
            //       }
            //     } else {
            //       arr2.unshift(shop[s].delivery[d].weight[w].price);
            //     }

            //     if (num === w + 1) {
            //       if (arr.length < 1) {
            //         data2.text += " " + arr2[0] * 1 + " บาท";
            //         // +shop[s].delivery[d].weight[w].delivery_id;
            //         data2.price = arr2[0] * 1;
            //         //  console.log("arr2")
            //       } else {
            //         // console.log("arr")
            //         data2.text += " " + arr[0] * 1 + " บาท";
            //         // + shop[s].delivery[d].weight[w].delivery_id;
            //         data2.price = arr[0] * 1;
            //       }
            //     }
            //   }
            //   // console.log(data2)
            // }
            // shop[s].delivery = data;
          }
          res.data.data.souvenir = shop;

          // console.log("res.data.data ++ ",res.data.data)


          ProductList.deleteAll();
          ProductList.insert({
            data: {
              id: res.data.data.id,
              address: res.data.data.address,
              amphoe: res.data.data.amphoe,
              created_at: res.data.data.created_at,
              district: res.data.data.district,
              email: res.data.data.email,
              image: res.data.data.image,
              name: res.data.data.name,
              password: res.data.data.password,
              phone: res.data.data.phone,
              province: res.data.data.province,
              region_id: res.data.data.region_id,
              shop: res.data.data.shop,
              souvenir: res.data.data.souvenir,
              zipcode: res.data.data.zipcode,
              delivery: res.data.data.delivery,
            },
          });
          this.overlay = false;
          this.shop = ProductList.query().first();
          console.log("this.shop ", this.shop);
        });
      } catch (error) {
        console.error(error);
      }
    },
    saveData(data, shopId, shopName,delivery) {
      // console.log(data);

      Shops.insert({
        data: {
          id: shopId,
          name: shopName,
          delivery:delivery
        },
      });

      Basket.insert({
        data: {
          amount: data.amount,
          discount: data.discount,
          totalPrice: data.totalPrice,
          id: data.id,
          created_at: data.created_at,
          deliveryId: data.deliveryId,
          deliveryName: data.deliveryName,
          deliveryPrice: data.deliveryPrice,
          delivery: data.delivery,
          description: data.description,
          image: data.image,
          member_id: data.member_id,
          name: data.name,
          price: data.price,
          souvenir_group_id: data.souvenir_group_id,
          unit_id: data.unit_id,
          weight: data.weight,
        },
      });
      // console.log("Shops",Shops.all());
      // console.log("Basket",Basket.all());
    },
  },
};
</script>
<style>
.NIinput1 {
  text-align: center;
  height: 10px;
}
.NIinput2 {
  height: 25px;
  line-height: 0px;
  color: red;
}
.v-application small.lh1 {
  line-height: 0.4em;
}
.justBasket {
  position: absolute;
  right: 5px;
}
.test {
  font-size: 0.8em;
}
</style>
