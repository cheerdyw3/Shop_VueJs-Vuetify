<template>
   <v-card elevation="0" tile > 
     <v-list dense>
        <template v-for="item in items">
          <v-row
            v-if="item.heading"
            :key="item.heading"
            align="center"
          >
            <v-col cols="6">
              <v-subheader v-if="item.heading">
                {{ item.heading }}
              </v-subheader>
            </v-col>
            <v-col
              cols="6"
              class="text-center"
            >
              <a
                href="#!"
                class="body-2 black--text"
              >EDIT</a>
            </v-col>
          </v-row>
          
          <v-list-item 
            :key="item.text"
            link :to="item.link"
          >
            <v-list-item-action class="pa-0 ma-0">
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-item-action>
            <v-list-item-content class="ml-3">
              <v-list-item-title >
                {{ item.text }}
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </template>
      </v-list>
   </v-card>
</template>


<script> 
  export default {
    props: {
      source: String,
    },
   
    data: () => ({
      dialog: false,
      drawer: null,
      items: [
        { icon: 'mdi-cog', link:'/', text: 'ข้อมูลพื้นฐาน' }, 
        { icon: 'mdi-cog', link:'Unit', text: 'หน่วย' }, 
        { icon: 'mdi-cog', link:'Region', text: 'ภูมิภาค' }, 
        { icon: 'mdi-cog', link:'Delivery', text: 'การจัดส่ง' }, 
        { icon: 'mdi-cog', link:'SouvenirGroup', text: 'ประเภทสินค้าของฝาก' }, 
        { icon: 'mdi-cog', link:'Souvenir', text: 'รายการสินค้าของฝาก' }, 
        { icon: 'mdi-cog', link:'Member', text: 'ข้อมูลสมาชิก' }, 
      ],
    }),
  }
</script>