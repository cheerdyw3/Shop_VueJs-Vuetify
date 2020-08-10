<template>
  <v-card elevation="0" class="pa-0 ma-0">
    <v-card elevation="0" class="pa-2 ma-0 pa-0 mt-15">
      <h3>ติดตามสถานะการสั่งซื้อ</h3>
    </v-card>
    <v-row no-gutters>
      <v-col cols="12" class="py-0">
        <v-img :src="require('./../assets/post.png')" height="200" contain>
        </v-img>
      </v-col>
    </v-row>
    <v-row no-gutters class="textSize mt-5 mb-2">
      <v-col cols="1" class="pb-0"> </v-col>
      <v-col cols="11" class="pb-0 font-weight-bold grey--text text--dark-2">
        <h3>Thailand Post - EMS</h3>
        <h3>หมายเลขติดตามพัสดุ : EL1234567890 TH</h3>
      </v-col>
    </v-row>
    <v-progress-linear
      class="mb-3"
      color="grey lighten-2"
      rounded
      value="100"
      height="2"
    ></v-progress-linear>
    <v-row no-gutters>
      <v-col cols="12" class="pa-0">
        <v-timeline Toggle align-top small dense class="pt-0">
          <v-timeline-item
            color="grey"
            small
            fill-dot
            class="mb-4"
            v-for="(item, i3) in items3"
            :key="i3"
          >
            <v-row no-gutters class="textSize">
              <v-col
                cols="12"
                class="pa-0 font-weight-bold grey--text text--dark-2"
              >
                <h4>(TH) รับฝาก (THAIPOST : EL1234567890 TH})</h4>
                <h3>1-05-2020 11:00</h3>
              </v-col>
            </v-row>
          </v-timeline-item>
        </v-timeline>
      </v-col>
    </v-row>
  </v-card>
</template>

<script>
export default {
  data() {
    return {
      items3: [0, 1, 2,4],
    };
  },
};
</script>

<style>
.textSize {
  font-size: 11px;
}

</style>
