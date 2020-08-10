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
                  <v-col class="px-3" cols="10" sm="6" md="10">
                    <v-text-field outlined v-model="editedItem.name" label="ชื่อ Thai"></v-text-field>
                  </v-col> 
                   <v-col class="px-3" cols="2" sm="2" md="2">
                    <v-text-field outlined v-model="editedItem.sort" label="ลำดับ"></v-text-field>
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
      title: 'ภูมิภาค',
      dialog: false,
      headers: [
        { text: 'ID', align: 'center', value: 'id',width: '80'   }, 
        { text: 'ชื่อ', align: 'start', sortable: false, value: 'name', },  
        { text: 'ลำดับ', align: 'center',value: 'sort',  width: '120' }, 
        { text: 'การจัดการ', align: 'center', value: 'actions', sortable: false, width: '120' },
      ],
      desserts: [],
      editedIndex: -1,
      id: '',
      editedItem: {
        name: '', 
        sort: '', 
        image: '', 
      },
      defaultItem: {
        name: '', 
        sort: '', 
        image: '', 
      }, 
    }),
components: {
    ImageC, 
  },
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

    created () {
      this.initialize()
    },

    methods: {
      async initialize() {   
            try { 
                HTTP.get('region').then((res) => {   this.desserts = res.data.data   }) 
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
        HTTP.delete('region/'+id).then((res) => { console.log(res.data.data)  }) 
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
          HTTP.post('region/'+this.id,obj).then((res) => {   
            console.log(res)
            this.initialize()
           }) 
         
        } else { 
          let obj = this.editedItem
          HTTP.post('region',obj).then((res) => {   
            console.log(res)
            this.initialize()   
          }) 
          
        }
        this.close()
      }, 
      dataRe(data){
        this.editedItem.image = data  
      }, 
    },
  }
</script>
