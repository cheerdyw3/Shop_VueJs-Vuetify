<template>
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
          <v-dialog
            v-model="dialog"
            fullscreen
            hide-overlay
            transition="dialog-bottom-transition"
          >
            <v-toolbar App dark dense color="primary">
              <v-btn small icon dark @click="dialog = false">
                <v-icon>mdi-close</v-icon>
              </v-btn>
              <v-toolbar-title>{{ formTitle }}</v-toolbar-title>
              <v-spacer></v-spacer>
              <v-toolbar-items>
                <v-btn small dark text @click="save">Save</v-btn>
              </v-toolbar-items>
            </v-toolbar>
            <template v-slot:activator="{ on, attrs }">
              <v-btn
                small
                color="primary"
                dark
                class="mb-2"
                v-bind="attrs"
                v-on="on"
                >เพิ่ม{{ title }}</v-btn
              >
            </template>
            <v-card elevation="0" tile>
              <v-card-text>
                <v-container>
                  <v-row no-gutters>
                    <v-col class="px-3" cols="12" sm="6" md="12">
                      <v-select
                        outlined
                        label="member_id"
                        v-model="editedItem.member_id"
                        :items="listMember"
                        item-text="shop"
                        item-value="id"
                      ></v-select>
                    </v-col>
                    <v-col class="px-3" cols="6" sm="6" md="6">
                      <v-text-field
                        outlined
                        v-model="editedItem.name"
                        label="Name"
                      ></v-text-field>
                    </v-col>
                    <v-col class="px-3" cols="6" sm="6" md="6">
                      <v-text-field
                        outlined
                        v-model="editedItem.description"
                        label="description"
                      ></v-text-field>
                    </v-col>
                    <v-col class="px-3" cols="6" sm="6" md="6">
                      <v-text-field
                        outlined
                        v-model="editedItem.price"
                        label="price"
                      ></v-text-field>
                    </v-col>
                    <v-col class="px-3" cols="6" sm="6" md="6">
                      <v-text-field
                        outlined
                        v-model="editedItem.weight"
                        label="weight"
                      ></v-text-field>
                    </v-col>
                    <v-col class="px-3" cols="6" sm="6" md="6">
                      <v-select
                        outlined
                        label="unit_id"
                        v-model="editedItem.unit_id"
                        :items="listUnit"
                        item-text="name"
                        item-value="id"
                      ></v-select>
                    </v-col>
                    
                    <v-col class="px-3" cols="6" sm="6" md="6">
                      <v-select
                        outlined
                        multiple
                        chips
                        label="delivery"
                        v-model="editedItem.delivery"
                        :items="listDelivery"
                        item-text="name"
                        item-value="id"
                      ></v-select>
                    </v-col>

                    <v-col class="px-3" cols="6" sm="6" md="6">
                      <v-select
                        outlined
                        label="souvenir_group_id"
                        v-model="editedItem.souvenir_group_id"
                        :items="listSouvenir_group"
                        item-text="name"
                        item-value="id"
                      ></v-select>
                    </v-col>
                    <v-col class="px-3" cols="12">
                      <ImageC
                        :img="editedItem.image"
                        @dataRe="dataRe($event)"
                      />
                    </v-col>
                  </v-row>
                </v-container>
              </v-card-text>
            </v-card>
          </v-dialog>
        </v-toolbar>
      </template>
      <template v-slot:item.actions="{ item }">
        <v-icon small class="mr-2" @click="editItem(item)">
          mdi-pencil
        </v-icon>
        <v-icon small @click="deleteItem(item, item.id)">
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
</template>

<script>
import { HTTP } from "@/Connect/httpClient";
import ImageC from "@/components/ImageC";
export default {
  data: () => ({
    title: "รายการสินค้าของฝาก",
    dialog: false,
    headers: [
      { text: "ID", align: "center", value: "id", width: "80" },
      { text: "ชื่อ", align: "start", sortable: false, value: "name" },
      // { text: 'ลำดับ', align: 'center',value: 'sort',  width: '120' },
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
    id: "",
    editedItem: {
      name: "",
      description: "",
      price: "",
      weight: "",
      unit_id: "",
      delivery: "",
      souvenir_group_id: "",
      member_id: "",
      image: "",
    },
    defaultItem: {
      name: "",
      description: "",
      price: "",
      weight: "",
      unit_id: "",
      delivery: "",
      souvenir_group_id: "",
      member_id: "",
      image: "",
    },
    listUnit: [],
    listDelivery: [],
    listSouvenir_group: [],
    listMember: [],
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1
        ? "เพิ่ม" + this.title
        : "แก้ไข" + this.title;
    },
  },
  components: {
    ImageC,
  },

  watch: {
    dialog(val) {
      val || this.close();
    },
  },

  created() {
    this.getAllUnit();
    this.getAllDelivery();
    this.getAllSouvenir_group();
    this.getMember();
    this.initialize();
  },

  methods: {
    async initialize() {
      try {
        HTTP.get("souvenir").then((res) => {
          this.desserts = res.data.data;
          for (let i = 0; i < this.desserts.length; i++) {
            let data = [];
            for (let j = 0; j < this.desserts[i].delivery.length; j++) {
              for (let k = 0; k < this.listDelivery.length; k++) {
                if (this.desserts[i].delivery[j].delivery_id == this.listDelivery[k].id) {
                  data.push(this.listDelivery[k].id);
                }
              }
              
            }
            this.desserts[i].delivery = data;
          }
        });
      } catch (error) {
        console.error(error);
      }
    },

    editItem(item) {
      this.editedIndex = this.desserts.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.id = item.id;
      this.dialog = true;
    },

    deleteItem(item, id) {
      const index = this.desserts.indexOf(item);
      confirm("Are you sure you want to delete this item?") &&
        this.desserts.splice(index, 1);
      HTTP.delete("souvenir/" + id).then((res) => {
        console.log(res.data.data);
      });
    },

    close() {
      this.dialog = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },

    save() {
      if (this.editedIndex > -1) {
        let obj = this.editedItem;
        HTTP.post("souvenir/" + this.id, obj).then((res) => {
          console.log(res);
          this.initialize();
        });
      } else {
        let obj = this.editedItem;
        console.log("obj", this.editedItem);
        HTTP.post("souvenir", obj).then((res) => {
          console.log(res);
          this.initialize();
        });
      }
      this.close();
    },
    async getAllUnit() {
      try {
        HTTP.get("unit").then((res) => {
          this.listUnit = res.data.data;
        });
      } catch (error) {
        console.error(error);
      }
    },
    async getAllDelivery() {
      try {
        HTTP.get("delivery").then((res) => {
          this.listDelivery = res.data.data;
          // console.log("delivery",this.listDelivery)
        });
      } catch (error) {
        console.error(error);
      }
    },
    async getAllSouvenir_group() {
      try {
        HTTP.get("souvenirgroup").then((res) => {
          this.listSouvenir_group = res.data.data;
        });
      } catch (error) {
        console.error(error);
      }
    },
    async getMember() {
      try {
        HTTP.get("member").then((res) => {
          this.listMember = res.data.data;
        });
      } catch (error) {
        console.error(error);
      }
    },
    dataRe(data) {
      this.editedItem.image = data;
    },
  },
};
</script>
