<template>  
    <v-card class="text-center justify-center  align-center  pa-5 ma-0 mb-5" max-width="400">
        รูปภาพ <br>  
        <v-card v-if="img" elevation="0">
            <v-img :src="`${API}/${img}`" class="mx-auto ma-3" contain  max-width="200"></v-img>   
            <v-btn small @click="Delete(img)">Delete</v-btn>
        </v-card> 
        <input v-else type="file" name="file" v-on:change="fileChangeA($event.target.files)" > 
    </v-card>  
     
</template>
 
<script>
// @ is an alias to /src  
import axios from "axios";
import { HTTP } from "@/Connect/httpClient";
export default {
  name: "Home",  
  data: () => ({ 
            API: 'http://10.0.0.46:8081/',   
            form: {    
                'image': null, 
            },  
        }),  
        props :{ 
         img: String,
        },
        methods: {  
            fileChangeA(fileList) {
                let files = new FormData()
                files.append("image", fileList[0], fileList[0].name);
                axios({ method: "POST", "url": this.API+"/api/v1/upload", "data": files }).then(result => {    
                    this.img = result.data.data.image 
                    let _data = this.img
                    this.$emit('dataRe',_data)
                }, error => {
                    console.error(error);
                });
                 
            },  
            Delete(file){ 
                HTTP.post('image/delete',{"file":file}).then((res) => {   
                    console.log(res.data.data)
                    this.img = ''
                }) 
            } 
        }
};
</script>
