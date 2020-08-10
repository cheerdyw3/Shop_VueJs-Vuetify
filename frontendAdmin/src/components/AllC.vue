<template>
  <v-card class="pa-5" elevation="0" min-height="600">
    <v-row no-gutters>
      <v-col cols="6"  class="px-2" sm="6">
        <v-text-field v-model="all.phone" label="เบอร์โทร" outlined></v-text-field>
      </v-col>
      <v-col cols="6"  class="px-2" sm="6">
        <v-text-field v-model="all.email" label="อีเมล์" outlined></v-text-field>
      </v-col>
      <v-col cols="6"  class="px-2" sm="6">
        <v-text-field v-model="all.facebook" label="Facebook Link" outlined></v-text-field>
      </v-col>
      <v-col cols="6"  class="px-2" sm="6">
        <v-text-field v-model="all.ig" label="IG Link" outlined></v-text-field>
      </v-col>
      
      <v-col class="px-2">
        <v-btn   color="primary" @click="Save()">บันทึกข้อมูล</v-btn>
      </v-col>
    </v-row>
  </v-card>
</template>



<script>
  // @ is an alias to /src    
  export default {
    name: "AboutusC",
    data: () => ({
       
    }),
    props:{
      all: Array,
    },
    methods:{
     Save(){ 
       let _data = {
         phone: this.all.phone,
         email: this.all.email,
         facebook: this.all.facebook,
         ig: this.all.ig,
       }
        this.$emit('saveConfig',_data)
     }
 } 

  };
</script>