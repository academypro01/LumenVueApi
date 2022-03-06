<template>
  <div class="container">
    <h3 class="text-center">Welcome to your panel, majid.</h3>
    <hr>
    <button type="button" class="btn btn-danger ml-2" @click="logoutUser">logout</button>
    <router-link to="/create" type="button" class="btn btn-primary m-2">Create</router-link>
    <hr>
    <component :is="selectedComponent"></component>
  </div>
</template>

<script>
import PostsListComponent from "@/components/PostsListComponent";
export default {
  name: "HomeComponent",
  data() {
    return {
      selectedComponent: PostsListComponent,
      token : ''
    }
  },
  components: [
    PostsListComponent,
  ],
  methods: {
    setCookie(cname, cvalue, exdays = 1) {
      const d = new Date();
      d.setTime(d.getTime() + (exdays*24*60*60*1000));
      let expires = "expires="+ d.toUTCString();
      document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    },
    getCookie(cname = 'token') {
      let name = cname + "=";
      let ca = document.cookie.split(';');
      for(let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
          c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
          return c.substring(name.length, c.length);
        }
      }
      return "";
    },
    checkToken() {
      let token = this.getCookie();
      if(token != "") {
        return true;
      }else{
        return false;
      }
    },
    logoutUser() {
      this.setCookie('token', null, -1);
      this.setCookie('email', null, -1);
      this.setCookie('name', null, -1);
      document.cookie.split(";").forEach(function(c) { document.cookie = c.replace(/^ +/, "").replace(/=.*/, "=;expires=" + new Date().toUTCString() + ";path=/"); });
      this.$router.push('/');
    }
  },
  beforeRouteEnter(to, from, next) {
     function getCookie(cname = 'token') {
      let name = cname + "=";
      let ca = document.cookie.split(';');
      for(let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
          c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
          return c.substring(name.length, c.length);
        }
      }
      return "";
    }
    function checkToken() {
      let token = getCookie();
      if(token != "") {
        return true;
      }else{
        return false;
      }
    }

    let check = checkToken();

    if(check) {
      next();
    }else{
      next(false);
    }
  },
  mounted() {
    let cname = 'token';
    let name = cname + "=";
    let token = '';
    let ca = document.cookie.split(';');
    for(let i = 0; i < ca.length; i++) {
      let c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        token = c.substring(name.length, c.length);
      }
    }
    this.token = token;
  },
}
</script>

<style scoped>

</style>