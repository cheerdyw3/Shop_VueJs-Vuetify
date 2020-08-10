<template> 
    <v-card elevation="0" class="pa-0 ma-0">

      <v-content class="pa-0 ma-0 mt-12 pt-5">
      <v-card elevation="0" class="ma-0 pa-0 mb-2">
        <v-row no-gutters class="text-center mx-2">
          <v-col class="pa-0 mx-0" >
             <v-card elevation="1">
               <v-parallax height="40" src="@/assets/bg-1.jpg">
               <span  class="black--text" >ภาคเหนือ</span> 
              </v-parallax> 
             </v-card>
          </v-col>
          <v-col class="pa-0 mx-1 mx-0">
            <v-card elevation="1">
               <v-parallax height="40" src="@/assets/bg-2.jpg">
               <span  class="black--text" >ภาคอีสาน</span> 
              </v-parallax> 
             </v-card> 
          </v-col>
          <v-col class="pa-0 mr-1 mx-0">
            <v-card elevation="1">
               <v-parallax height="40" src="@/assets/bg-3.jpg">
               <span  class="black--text" >ภาคกลาง</span> 
              </v-parallax> 
             </v-card> 
          </v-col>
          <v-col class="pa-0 mx-0">
            <v-card elevation="1">
               <v-parallax height="40" src="@/assets/bg-4.jpg">
               <span  class="black--text" >ภาคใต้</span> 
              </v-parallax> 
             </v-card> 
          </v-col>
        </v-row>
      </v-card>
      <v-card elevation="0" class="pa-1 ma-0 mx-1 pb-2">
        <v-text-field filled solo dense hide-details label="ค้นหา" append-icon="mdi-magnify"></v-text-field>
      </v-card>
    </v-content>
    
      <v-card elevation="0" v-for="(item,i) in regions" :key="i" class="mb-2">
        <v-row no-gutters>
        <v-col cols="12"> 
         <v-img :src="`${API}${item.image}`" contain></v-img>
        </v-col>
      </v-row>   
      <v-card elevation="0">
        <v-row no-gutters>
          <v-col cols="6" class="pa-1" v-for="(m,i) in item.member" :key="i">
            <v-card :to="`/shop/${m.id}`">
               <v-img :src="`${API}${m.image}`" contain  ></v-img>
               <p class="pa-0 ma-0 pa-1">{{m.shop}}</p>
            </v-card>
          </v-col>
        </v-row>
      </v-card>
      </v-card> 
    </v-card> 
</template>

<script>
// @ is an alias to /src  
import { HTTP } from "@/Connect/http";
export default {
  name: "Home",
  data: () => ({
      title: 'ภูมิภาค',
      regions: [],
      API: process.env.VUE_APP_API,
  }),
  components: {
    
  },
  created () {
      this.initialize()
    },
  methods: {
     async initialize() {   
          try { 
              HTTP.get('region/show').then((res) => {   this.regions = res.data.data   }) 
          } catch (error) {
              console.error(error)
          }
      },    
  }
};
</script>
