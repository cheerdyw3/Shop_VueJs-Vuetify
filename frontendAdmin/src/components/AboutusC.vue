<template>
    <v-card class="pa-5" elevation="0" min-height="600"> 
    <v-row>
      <vue-editor id="editor2"  v-model="aboutus" />
    </v-row>
    <v-row class="mt-5">
      <v-btn   color="primary" @click="Save()">บันทึกข้อมูล</v-btn>
    </v-row>
  </v-card>
</template>



<script>
// @ is an alias to /src   
import { VueEditor } from "vue2-editor";
export default {
  name: "AboutusC",     
 props:{
    aboutus: String,
  } ,
  components: {
    VueEditor
  },
  methods:{
     Save(){ 
       let _data = {
         aboutus: this.aboutus
       }
        this.$emit('saveConfig',_data)
     }
 } 
};
</script>
<style> 
#editor2 {
  height: 500px; 
}
</style>
