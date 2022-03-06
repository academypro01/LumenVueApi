<template>
  <div class="m-2 p-3">
    <alert-message-component v-if="alertFlag" :message="alertMessage"></alert-message-component>
    <h2>Register Form:</h2>
    <form>
      <div class="form-group">
        <label for="name">Name:</label>
        <input v-model="signupData.name" type="text" name="name" id="name" class="form-control" placeholder="Enter your name" required>
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input v-model="signupData.email" type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input v-model="signupData.password" type="password" name="password" id="password" class="form-control" placeholder="Enter your password">
      </div>
      <div class="form-group">
        <input type="button" value="Register" class="form-control btn btn-success mt-2" @click="userSignup">
      </div>
    </form>
  </div>
</template>

<script>
// import axios from "vue-axios";
import AlertMessageComponent from "@/components/AlertMessageComponent";
export default {
  name: "RegisterComponent",
  data() {
    return {
      signupData: {
        name : '',
        email: '',
        password: ''
      },
      alertFlag : false,
      alertMessage : ''
    }
  },
  components: {
    alertMessageComponent : AlertMessageComponent
  },
  methods: {
    userSignup() {
      this.axios.post('register', {
        'name' : this.signupData.name,
        'email' : this.signupData.email,
        'password': this.signupData.password
      },
          {
        'Accept': 'application/json',
        'Content-Type' : 'application/json'
      })
      .then((response) => {
        console.log(response);
        this.alertFlag = true;
        this.alertMessage = "you are registered successfully";
      })
      .catch((error) => {
        console.log(error);
        this.alertFlag = true;
        this.alertMessage = "Error, please try again later";
      })
    }
  }
}
</script>

<style scoped>

</style>