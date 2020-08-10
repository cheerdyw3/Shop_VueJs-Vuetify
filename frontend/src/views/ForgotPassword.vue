<template>
  <v-card elevation="0" class="pa-0 ma-0">
    <v-card elevation="0" class="pa-2 ma-0 pa-0 mt-15">
      <h3>ตั้งรหัสผ่านใหม่</h3>
    </v-card>
    <v-card elevation="0" class="px-5 ma-0">
      <v-row no-gutters>
        <v-col cols="12" class="pa-0 ma-0">
          <v-text-field
            label="หมายเลขโทรศัพท์/ Email"
            prepend-inner-icon="mdi-account"
          ></v-text-field>
        </v-col>

        <v-col cols="12">
          <v-btn block color="success">ลงทะเบียน</v-btn>
        </v-col>


      </v-row>
    </v-card>
  </v-card>
</template>

<script>
export default {};
</script>

<style></style>
