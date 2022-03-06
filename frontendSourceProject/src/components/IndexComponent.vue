<template>
  <div class="mt-4">
    <h1 class="text-center">Laravel-Vue Api Test!</h1>
    <div id="nav" class="flex text-center">
      <a class="m-4" style="cursor: pointer"  @click="register">Register</a>
      <a class="m-4 " style="cursor: pointer" @click="login">Login</a>
    </div>
    <hr>
    <div v-if="flag">
      <component :is="selectedComponent"></component>
    </div>
  </div>
</template>

<script>

import RegisterComponent from "@/components/RegisterComponent";
import LoginComponent from "@/components/LoginComponent";

export default {
  name: "IndexComponent",
  data() {
    return {
      flag: false,
      selectedComponent: '',
      token : ''
    }
  },
  methods: {
    register() {
      this.flag = true;
      this.selectedComponent = RegisterComponent
    },
    login() {
      this.flag = true;
      this.selectedComponent = LoginComponent
    }
  }

}
</script>

<style scoped>

</style>