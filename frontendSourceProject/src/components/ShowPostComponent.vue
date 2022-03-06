<template>
<div class="container">
  <h2>Update Post</h2>
  <div class="form-group">
    <label for="title">Post Title:</label>
    <input type="text" name="title" v-model="title" id="title" class="form-control">
  </div>
  <div class="form-group">
    <label for="description">Post Description:</label>
    <textarea name="description" v-model="description" id="description" cols="30" rows="10" class="form-control"></textarea>
  </div>
  <hr>
  <button type="button" class="btn btn-warning m-2" @click="canclePost">Cancle</button>
  <button type="button" class="btn btn-info m-2" @click="updatePost">Update</button>
  <button type="button" class="btn btn-danger m-2" @click="deletePost">Delete</button>
  <div v-if="alertFlag">
    <hr>
    <alert-message-component :message="alertMessage"></alert-message-component>
  </div>
</div>
</template>

<script>
import AlertMessageComponent from "@/components/AlertMessageComponent";
export default {
  name: "ShowPostComponent",
  data() {
    return {
      id: this.$route.params.id,
      post: [],
      title: '',
      description: '',
      alertFlag: false,
      alertMessage: '',
      token: ''
    }
  },
  components: {
    alertMessageComponent: AlertMessageComponent
  },
  methods: {
    getToken(cname = 'token') {
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
      return token;
    },
    getPost() {
      this.token = this.getToken();
      this.axios.get(`post/${this.id}/?api_token=${this.token}`)
          .then((response) => {
            this.post = (response.data.data);
            this.title = this.post.title;
            this.description = this.post.description;
          })
          .catch((error) => {
            console.log(error);
          })
    },
    canclePost() {
      this.$router.push('/home');
    },
    updatePost() {
      const config = {
        headers: {
        Accept: 'application/json'
        }
      }
      this.axios.put(`post/${this.id}/?api_token=${this.token}`,
          {
            'title': this.title,
            'description': this.description
          },
          config
      )
      .then((response) => {
        let status = response.data.data.status;
        console.log(status);
        if(status == 'ok') {
          this.alertFlag = true;
          this.alertMessage = "Post Updated Successfully";
        }
      })
      .catch(() => {
        this.alertFlag = true;
        this.alertMessage = "You can't update this post";
      })
    },
    deletePost() {
      const config = {
        headers: {Authorization: `Bearer ${this.token}`,
          Accept: 'application/json'
        }
      }
      this.axios.delete(`post/${this.id}/?api_token=${this.token}`,
          config
      )
          .then((response) => {
            let check = response.data.data;
            if(check.status == 'ok') {
              this.$router.push('/home');
            }else{
              this.alertFlag = true;
              this.alertMessage = check.error
            }
          })
          .catch((error) => {
            console.log(error);
          })
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
  created() {
    this.getPost();
  }
}
</script>

<style scoped>

</style>