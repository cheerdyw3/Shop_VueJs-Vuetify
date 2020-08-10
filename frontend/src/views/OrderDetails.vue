<template>
  <v-card elevation="0" class="pa-0 ma-0">
    <v-card elevation="0" class="pa-2 ma-0 pa-0 mt-15">
      <h3>ออเดอร์ของคุณ</h3>
    </v-card>
    <v-row no-gutters>
      <v-col cols="12" class="py-0">
        <v-img :src="require('./../assets/post.png')" height="200" contain>
        </v-img>
      </v-col>
    </v-row>
    <v-row no-gutters>
      <v-col>
        <v-card elevation="0" class="pa-2 ma-0 pa-0" >
          <v-row no-gutters class="text-center mt-5 ">
            <v-col cols="12">
              <h5>การสั่งซื้อของคุณเสร็จสมบูรณ์ กรุณาชำระภายใน 4 ชั่วโมง</h5>
            </v-col>
            <v-col cols="12" class="mt-2 font-weight-bold grey--text text--dark-2">
              <small>
                <h5>หรือมีข้อสงสัย กรุณาติดต่อกลับ 088-4018847</h5>
              </small>
            </v-col>
          </v-row>
        </v-card>
      </v-col>
    </v-row>
  </v-card>
</template>

<script>
export default {};
</script>

<style></style>
