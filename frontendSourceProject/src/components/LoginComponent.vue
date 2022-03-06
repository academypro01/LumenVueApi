<template>
  <div class="m-2 p-3">
    <alert-message-component v-if="alertFlag" :message="alertMessage"></alert-message-component>
    <h2>Login Form:</h2>
    <form>
      <div class="form-group">
        <label for="email">Email:</label>
        <input v-model="email" type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input v-model="password" type="password" name="password" id="password" class="form-control" placeholder="Enter your password">
      </div>
      <div class="form-group">
        <input type="button" value="Login" @click="signinUser" class="form-control btn btn-success mt-2">
      </div>
    </form>
  </div>
</template>

<script>
import AlertMessageComponent from "@/components/AlertMessageComponent";
export default {
  name: "LoginComponent",
  data() {
    return {
      email: '',
      password: '',
      alertFlag: false,
      alertMessage: '',
    }
  },
  components: {
    AlertMessageComponent,
    alertMessageComponent : AlertMessageComponent
  },
  methods: {
    signinUser() {
      this.axios.post('login',
          {
            'email': this.email,
            'password' : this.password
          },
          {
            'Accept':'application/json',
            'Content-Type':'application/json'
          })
      .then((response)=>{
        this.setCookie('token', response.data.data.token);
        this.setCookie('name', response.data.data.name);
        this.setCookie('email', response.data.data.email);
        this.$router.push('/home');
      })
      .catch((error)=>{
        this.alertFlag = true;
        this.alertMessage = "Username or Password is incorrect.";
        console.log(error);
      })
    },
    setCookie(cname, cvalue, exdays = 1) {
      const d = new Date();
      d.setTime(d.getTime() + (exdays*24*60*60*1000));
      let expires = "expires="+ d.toUTCString();
      document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }
  }
}
</script>

<style scoped>

</style>