<template>
  <v-card>
    
     
        <v-tabs   
      flat 
          v-model="currentItem" 
           color="blue"
        >
          <v-tab href="#tab-slide"  >
           การจัดการข้อมูลรูปภาพ Slide
          </v-tab>  
          <v-tab href="#tab-video"  >
           การจัดการข้อมูล Video
          </v-tab>   
           <v-tab href="#tab-aboutus"  >
           การจัดการข้อมูล เกี่ยวกับเรา
          </v-tab>   
          <v-tab href="#tab-all"  >
           การจัดการข้อมูลทั่วไป
          </v-tab>   
        </v-tabs>
       

    <v-tabs-items v-model="currentItem">
      <v-tab-item value="tab-slide" >
       <v-row class="ma-2">
          <SlideC :item="1" :slide="1" :img="img[0].image"  :dataName="PC" @dataRe="dataRe($event)" />
          <SlideC :item="2" :slide="1"  :img="img[1].image" :dataName="Mobile" @dataRe="dataRe($event)" />
          <SlideC :item="3" :slide="2"  :img="img[2].image" :dataName="PC" @dataRe="dataRe($event)" />
          <SlideC :item="4" :slide="2"  :img="img[3].image" :dataName="Mobile" @dataRe="dataRe($event)" />
          <SlideC :item="5" :slide="3"  :img="img[4].image" :dataName="PC" @dataRe="dataRe($event)" />
          <SlideC :item="6" :slide="3"  :img="img[5].image" :dataName="Mobile" @dataRe="dataRe($event)" />
          <SlideC :item="7" :slide="4"  :img="img[6].image" :dataName="PC" @dataRe="dataRe($event)" />
          <SlideC :item="8" :slide="4"  :img="img[7].image" :dataName="Mobile" @dataRe="dataRe($event)" />
          <SlideC :item="9" :slide="5"  :img="img[8].image" :dataName="PC" @dataRe="dataRe($event)" />
          <SlideC :item="10" :slide="5" :img="img[9].image" :dataName="Mobile" @dataRe="dataRe($event)" />
       </v-row>
      </v-tab-item>
      <v-tab-item value="tab-video" >
        <VideoC :video="config.video" @saveConfig="saveConfig($event)" />
      </v-tab-item>
      <v-tab-item value="tab-aboutus" >
        <AboutusC :aboutus="config.aboutus" @saveConfig="saveConfig($event)" />
      </v-tab-item>
      <v-tab-item value="tab-all" >
        <AllC :all="config" @saveConfig="saveConfig($event)" />
      </v-tab-item>
    </v-tabs-items>
  </v-card>
</template>
 

<script>
import SlideC from '@/components/SlideC'  
import VideoC from '@/components/VideoC'  
import AboutusC from '@/components/AboutusC' 
import AllC from '@/components/AllC'
import Admin from '@/Models/Admin'  

import { HTTP } from "@/Connect/http"; 
  export default {
    data: () => ({
      PC:'PC',
      Mobile: 'Mobile',
      img: [],
      currentItem: 'tab-Web',
      config:'',
    }),
 components: {
      SlideC,  VideoC, AboutusC, AllC,
    },
    computed: {    
            Admins() {  return Admin.query().first(); },    
        },
    methods: {
       dataRe(data){
         HTTP.post('slide/'+data.id,{data:data},
         {
        headers: {
            'Content-Type': 'application/json',
            "Authorization": this.Admins.api_token
            }
        })
         .then((res) => {   console.log(res)   }) 
         console.log(data)
       }, 
      async loadImage() {   
        try { 
            HTTP.get('slide',{
    headers: {
        'Content-Type': 'application/json',
         "Authorization": this.Admins.api_token
    }
}).then((res) => {   this.img = res.data.success  }) 
        } catch (error) {
            console.error(error)
        }
      },     
       async loadConfig() {   
        try { 
            HTTP.get('config/1',{
    headers: {
        'Content-Type': 'application/json',
         "Authorization": this.Admins.api_token
    }
}).then((res) => {   this.config = res.data.success  }) 
        } catch (error) {
            console.error(error)
        }
      },     
      saveConfig(data){  
          HTTP.post('config/1',{data:data},
          {
          headers: {
              'Content-Type': 'application/json',
              "Authorization": this.Admins.api_token
              }
          }).then((res) => {   
            console.log(res)   
            this.loadConfig()  
          })   
     }
    },
    created() {        
      this.loadImage()  
      this.loadConfig()  
    },
  }
</script>
