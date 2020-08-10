<template> 
      <v-col cols="6" class="pa-3"> 
        <v-card class="text-center justify-center  align-center  pa-2" >
            รูปที่ {{slide}} {{dataName}} <br> 
            <input type="file" name="file" v-on:change="fileChangeA($event.target.files,item,dataName)" >
            <v-img v-if="form.image" :src="`${API}/${form.image}`" class="mx-auto ma-3"  max-width="200"></v-img>  
            <v-img v-if="img" :src="`${API}/${img}`" class="mx-auto ma-3"  max-width="200"></v-img>  
        </v-card>  
      </v-col>  
</template>
 
<script>
// @ is an alias to /src  
import axios from "axios";
export default {
  name: "Home",  
  data: () => ({ 
            API: 'http://missmed.co.th/s1',   
            form: {    
                'image': null, 
            },  
        }),  
        props :{
         item: Number,
         slide: Number, 
         dataName: String,
         img: String,
        },
        methods: {  
            fileChangeA(fileList,i,n) {
                let files = new FormData()
                files.append("image", fileList[0], fileList[0].name);
                axios({ method: "POST", "url": this.API+"/api/v1/upload", "data": files }).then(result => {   
                    this.img = ''  
                    this.form.image = result.data.data.image 
                    let _data = {
                        image: this.form.image,
                        name: n,
                        id: i
                    }
                    this.$emit('dataRe',_data)
                }, error => {
                    console.error(error);
                });
                 
            },  
             
        }
};
</script>
