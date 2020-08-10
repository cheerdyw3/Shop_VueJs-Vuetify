<template>
  <div>
    <v-row class="justify-center">
      <v-col cols="6">
        <v-card elevation="2" tile>
          <v-container>
            <v-form ref="form" lazy-validation>
              <v-row no-gutters>
                <v-col class="px-3" cols="2" sm="4" md="2">
                  <v-text-field
                    :rules="Rules.input"
                    outlined
                    label="น้ำหนัก"
                    :disabled="showForm"
                    v-model="editedItem.grams"
                  ></v-text-field>
                </v-col>
                <v-col class="px-3" cols="2" sm="4" md="2">
                  <v-text-field
                  :rules="Rules.input"
                    outlined
                    label="ราคา"
                    :disabled="showForm"
                    v-model="editedItem.price"
                  ></v-text-field>
                </v-col>
                <v-col class="px-5" cols="1" sm="2" md="2">
                  <v-btn
                    class="mt-6"
                    color="error"
                    small
                    v-if="showSend && editedItem.delivery_id != ''"
                    @click="initialize()"
                  >
                    ยกเลิก
                  </v-btn>
                  <v-btn
                    class="mt-6"
                    color="error"
                    small
                    v-if="!showSend && editedItem.delivery_id != ''"
                    @click="initialize()"
                  >
                    ยกเลิก
                  </v-btn>
                </v-col>
                <v-col class="ml-n15" cols="1" sm="2" md="2">
                  <v-btn
                    color="success"
                    large
                    v-if="!showSend && editedItem.delivery_id == ''"
                    @click="save('add')"
                  >
                    เพิ่ม
                  </v-btn>
                  <v-btn
                    class="mt-6"
                    color="warning"
                    small
                    v-if="!showSend && editedItem.delivery_id != ''"
                    @click="changeData()"
                    :disabled="editedItem.price == ''"
                  >
                    แก้ไข
                  </v-btn>
                  <v-btn
                    class="mt-6"
                    v-if="showSend"
                    color="success"
                    small
                    @click="save('edit')"
                  >
                    บันทึก
                  </v-btn>
                </v-col>
              </v-row>
            </v-form>
          </v-container>
        </v-card>
      </v-col>
    </v-row>

    <v-row class="justify-center">
      <v-col cols="6">
        <v-card elevation="0" tile>
          <v-data-table
            :headers="headers"
            :items="desserts"
            sort-by="sort_id"
            class="elevation-1"
          >
            <template v-slot:top>
              <v-toolbar flat color="white">
                <v-toolbar-title>{{ title }}</v-toolbar-title>
                <v-divider class="mx-4" inset vertical></v-divider>
                <v-spacer></v-spacer>
              </v-toolbar>
            </template>
            <template v-slot:item.actions="{ item }">
              <v-icon small @click="getData(item)">
                mdi-pencil
              </v-icon>
              <v-icon small @click="deleteItem(item)">
                mdi-delete
              </v-icon>
            </template>
            <template v-slot:item.show="{ item }">
              <span v-if="item.show == '1'">
                แสดง
              </span>
              <span v-else>ไม่แสดง</span>
            </template>
            <template v-slot:no-data>
              <v-btn x-small color="primary" @click="initialize">Reset</v-btn>
            </template>
          </v-data-table>
        </v-card>
      </v-col>
    </v-row>
  </div>
</template>

<script>
// @ is an alias to /src
import { HTTP } from "@/Connect/httpClient";

export default {
  data() {
    return {
      title: "ราคาและน้ำหนัก",
      headers: [
        { text: "ID", align: "center", value: "id", width: "80" },
        { text: "น้ำหนัก", align: "start", sortable: false, value: "grams" },
        { text: "ราคา", align: "start", sortable: false, value: "price" },
        {
          text: "การจัดการ",
          align: "center",
          value: "actions",
          sortable: false,
          width: "120",
        },
      ],
      desserts: [],
      editedIndex: -1,
      editedItem: {
        delivery_id: "",
        grams: "",
        price: "",
        idGrams: "",
      },
      defaultItem: {
        delivery_id: "",
        grams: "",
        price: "",
        idGrams: "",
      },
      showForm: false,
      showSend: false,
      Rules: {
        input: [(v) => !!v || "กรุณากรอก"],
      },
    };
  },
  props: {
    dataDelivery: Object,
  },
  methods: {
    getData(item) {
      this.showForm = true;
      this.showSend = false;
      this.editedItem.delivery_id = item.delivery_id;
      this.editedItem.price = item.price;
      this.editedItem.grams = item.grams;
      this.editedItem.idGrams = item.id;
      // console.log("++ ",this.editedItem);
    },
    save(type) {
      if(this.$refs.form.validate()){
        this.editedItem.delivery_id = this.dataDelivery.id;
        if (type == "add") {
          HTTP.post("deliverys/weight", this.editedItem).then((res) => {
            console.log(res);
            this.initialize();
          });
        } else {
          HTTP.post(
            "deliverys/weight/" + this.editedItem.idGrams,
            this.editedItem
          ).then((res) => {
            console.log(res);
            this.initialize();
          });
        }
      }
    },
    changeData() {
      this.showSend = true;
      this.showForm = false;
    },
    initialize() {
      try {
        HTTP.get("deliverys/" + this.dataDelivery.id + "/weight").then(
          (res) => {
            console.log(res);
            this.desserts = res.data.data;
          }
        );
      } catch (error) {
        console.error(error);
      }
      this.showForm = false;
      this.showSend = false;
      this.editedItem.delivery_id = "";
      this.editedItem.price = "";
      this.editedItem.grams = "";
      this.editedItem.idGrams = "";
    },
    deleteItem(item) {
      let isConfirm = confirm("Are you sure you want to delete this item?");
      if (isConfirm) {
        HTTP.delete("deliverys/weight/" + item.id).then((res) => {
          console.log(res.data.data);
          this.initialize();
        });
      }
    },
  },
  watch: {
    dataDelivery() {
      this.initialize();
    },
  },
  created() {
    this.initialize();
  },
};
</script>
