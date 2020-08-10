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
                  <v-col class="px-3" cols="6" sm="6" md="6" >
                    <v-text-field outlined v-model="editedItem.name" label="Name"></v-text-field>  
                  </v-col> 
                   <v-col class="px-3" cols="6" sm="6" md="6" >
                    <v-text-field outlined v-model="editedItem.shop" label="Shop Name"></v-text-field>  
                  </v-col>  
                  <v-col class="px-3" cols="6" sm="6" md="6" >
                    <v-text-field outlined v-model="editedItem.phone" label="Phone"></v-text-field>  
                  </v-col>  
                  <v-col class="px-3" cols="6" sm="6" md="6" >
                    <v-text-field outlined v-model="editedItem.email" label="Email"></v-text-field>  
                  </v-col>  
                  <v-col class="px-3" cols="6" sm="6" md="6" >
                    <v-text-field outlined v-model="editedItem.password" label="Password"></v-text-field>  
                  </v-col> 
                  <v-col class="px-3" cols="6" sm="6" md="6" >
                    <v-text-field outlined v-model="editedItem.address" label="Address"></v-text-field>  
                  </v-col>  
                  <v-col class="px-3" cols="6" sm="6" md="6" >
                    <v-text-field outlined v-model="editedItem.district" label="District"></v-text-field>  
                  </v-col>  
                  <v-col class="px-3" cols="6" sm="6" md="6" >
                    <v-text-field outlined v-model="editedItem.amphoe" label="Amphoe"></v-text-field>  
                  </v-col>  
                  <v-col class="px-3" cols="6" sm="6" md="6" >
                    <v-text-field outlined v-model="editedItem.province" label="Province"></v-text-field>  
                  </v-col>  
                  <v-col class="px-3" cols="6" sm="6" md="6" >
                    <v-text-field outlined v-model="editedItem.zipcode" label="Zipcode"></v-text-field>  
                  </v-col>
                   <v-col class="px-3" cols="6" sm="6" md="6" >
                    <v-select
                      outlined
                      label="Region"
                      v-model="editedItem.region_id"
                      :items="listRegions"
                      item-text="name"
                      item-value="id"
                    ></v-select>  
                  </v-col>  
                  <v-col class="px-3" cols="12" >
                     <ImageC :img="editedItem.image" @dataRe="dataRe($event)" />
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
    <template v-slot:item.show="{ item }">
      <span v-if="item.show =='1'">
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
import ImageC from '@/components/ImageC'  

  export default {
    data: () => ({
      title: 'ข้อมูลสมาชิก',
      dialog: false,
      headers: [
        { text: 'ID', align: 'center', value: 'id',width: '80'   }, 
        { text: 'ชื่อ', align: 'start', sortable: false, value: 'name', }, 
        { text: 'ชื่อร้าน', align: 'start', sortable: false, value: 'shop', }, 
        { text: 'เบอร์โทร', align: 'start', sortable: false, value: 'phone', }, 
        { text: 'อีเมล', align: 'start', sortable: false, value: 'email', },  
        { text: 'วันที่', align: 'center',value: 'created_at',  width: '120' }, 
        { text: 'การจัดการ', align: 'center', value: 'actions', sortable: false, width: '120' },
      ],
      desserts: [],
      editedIndex: -1,
      id: '',
      editedItem: {
        name: '',
        shop: '',
        phone: '',
        email: '',
        password: '',
        address: '',
        district: '',
        amphoe: '',
        province: '',
        zipcode: '',
        region_id: '',
        image:''
      },
      defaultItem: {
        name: '',
        shop: '',
        phone: '',
        email: '',
        password: '',
        address: '',
        district: '',
        amphoe: '',
        province: '',
        zipcode: '',
        region_id: '',
        image:''
      }, 
      listRegions: [],
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'เพิ่ม'+this.title : 'แก้ไข'+this.title
      },
    },

    watch: {
      dialog (val) {
        val || this.close()
      },
    },
    components: {
        ImageC, 
    },
    created () {
      this.initialize()
      this.getAllRegion()
    },

    methods: {
      async initialize() {   
            try { 
                HTTP.get('member').then((res) => {   
                  this.desserts = res.data.data  
                  }) 
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
        HTTP.delete('member/'+id).then((res) => { console.log(res.data.data)  }) 
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
           let obj = this.editedItem
          HTTP.post('member/'+this.id,obj).then((res) => {  
            console.log(res)
            this.initialize()
          })  
        } else { 
          let obj = this.editedItem
          HTTP.post('member',obj).then((res) => {   
            console.log(res.data.data)
            this.initialize()
          }) 
          
        }
        this.close()
      },
      dataRe(data){
        this.editedItem.image = data  
      }, 
      async getAllRegion(){
        try { 
          HTTP.get('region').then((res) => {   
            this.listRegions = res.data.data   
          }) 
        } catch (error) {
          console.error(error)
        }
      }
    },
  }
</script>
