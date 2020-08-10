<template>
    <v-card class="pa-5" elevation="0"> 
    <v-row>
      <v-col cols="3"> 
        <v-card  elevation="0">
            <v-text-field outlined
            label="Youtube Video ID"
            v-model="video"
          ></v-text-field> 
          <v-btn   color="primary" @click="Save()">บันทึกข้อมูล</v-btn>
        </v-card>  
      </v-col>
       <v-col>
         <v-card elevation="0">
           <youtube :video-id="video"></youtube> 
        </v-card>   
      </v-col>
    </v-row>
  </v-card>
</template>
  
<script>
// @ is an alias to /src    
export default {
  name: "Video",
  props:{
    video: String,
  } ,
 methods:{
     Save(){ 
       let _data = {
         video: this.video
       }
        this.$emit('saveConfig',_data)
     }
 } 
};
</script>
