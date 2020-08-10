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
        <v-toolbar-title>{{title}}</v-toolbar-title>
        <v-divider
          class="mx-4"
          inset
          vertical
        ></v-divider>
        <v-spacer></v-spacer>
        <v-dialog  v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
          <v-toolbar dark dense color="primary">
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
            <v-btn small
              color="primary"
              dark
              class="mb-2"
              v-bind="attrs"
              v-on="on"
            >เพิ่ม{{title}}</v-btn>
          </template>
          <v-card elevation="0" tile> 

            <v-card-text>
              <v-container>
                <v-row no-gutters>
                  <v-col cols="12" sm="6" md="12">
                    <v-text-field v-model="editedItem.title_th" label="ชื่อ Thai"></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="12">
                    <v-text-field v-model="editedItem.title_en" label="ชื่อ En"></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="12">
                    <v-text-field v-model="editedItem.sort_id" label="ลำดับ"></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="12">
                    <v-text-field v-model="editedItem.show" label="แสดงเมนูบาร์"></v-text-field>
                  </v-col> 
                </v-row>
              </v-container>
            </v-card-text>
 
          </v-card>
        </v-dialog>
      </v-toolbar>
    </template>
    <template v-slot:item.actions="{ item }">
      <v-icon
        small
        class="mr-2"
        @click="editItem(item)"
      >
        mdi-pencil
      </v-icon>
      <v-icon
        small
        @click="deleteItem(item,item.id)"
      >
        mdi-delete
      </v-icon>
    </template>
    <template v-slot:no-data>
      <v-btn x-small color="primary" @click="initialize">Reset</v-btn>
    </template>
  </v-data-table>
  </v-card>
</template>

<script>
import { HTTP } from "@/Connect/httpClient";
  export default {
    data: () => ({
      title: 'สินค้า',
      dialog: false,
      headers: [
        { text: 'ลำดับ', align: 'center', value: 'sort_id',width: '80'   }, 
        { text: 'ชื่อ Thai', align: 'start', sortable: false, value: 'title_th', }, 
        { text: 'แสดงเมนูบาร์', align: 'center',value: 'show',  width: '120' }, 
        { text: 'การจัดการ', align: 'center', value: 'actions', sortable: false, width: '120' },
      ],
      desserts: [],
      editedIndex: -1,
      id: '',
      editedItem: {
        title_th: '',
        title_en: '',
        sort_id: '',
        show: '', 
      },
      defaultItem: {
        title_th: '',
        title_en: '',
        sort_id: '',
        show: '', 
      },
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New Article' : 'Edit Article'
      },
    },

    watch: {
      dialog (val) {
        val || this.close()
      },
    },

    created () {
      this.initialize()
    },

    methods: {
      async initialize() {   
            try { 
                HTTP.get('product').then((res) => {   this.desserts = res.data.data   }) 
            } catch (error) {
                console.error(error)
            }
        },    

      editItem (item) { 
        this.editedIndex = this.desserts.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.id = item.id
        this.dialog = true
      },

      deleteItem (item,id) {
        const index = this.desserts.indexOf(item)
        confirm('Are you sure you want to delete this item?') && this.desserts.splice(index, 1)
        HTTP.get('product/'+id+'/destroy').then((res) => { console.log(res.data.data)  }) 
      },

      close () {
        this.dialog = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      save () {
        if (this.editedIndex > -1) { 
          HTTP.post('product/'+this.id+'/edit',{data:this.editedItem}).then((res) => {   this.agentData = res.data.data   }) 
          this.initialize()
        } else { 
          HTTP.post('product',{data:this.editedItem}).then((res) => {   this.agentData = res.data.data   }) 
          this.initialize()
        }
        this.close()
      },
    },
  }
</script>
