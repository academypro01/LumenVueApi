<template>
  <div class="container">
    <h3>Create New Post:</h3>
    <form>
      <div class="form-group">
        <label for="title">Post title:</label>
        <input v-model="title" type="text" name="title" placeholder="Enter Post Title" id="title" class="form-control">
      </div>
      <div class="form-group">
        <label for="description">Post Description</label>
        <textarea v-model="description" name="description" placeholder="Enter Post Description" id="description" cols="30" rows="10" class="form-control"></textarea>
      </div>

      <div class="form-group">
        <input type="button" value="Create Post" class="btn btn-primary mt-2 form-control" @click="createPost">
      </div>
    </form>
  </div>
</template>

<script>
export default {
  name: "CreatePostComponent",
  data() {
    return {
      title: '',
      description: ''
    }
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
    createPost() {
      let token = this.getToken();
      this.axios.post(`post?api_token=${token}`,
          {
            'title' : this.title,
            'description' : this.description
          })
      .then(() => {
        this.$router.push('/home');
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
}
</script>

<style scoped>

</style>