<template>
  <div class="container">
    <div v-for="post in posts" :key="post" class="card text-white bg-dark mb-3" style="max-width: 100%;">
      <div class="card-header">Post Author: {{post.user.name}} </div>
      <div class="card-body">
        <input type="hidden" name="post_id" :value="post.id">
        <router-link :to="'/show/'+post.id">
          <h5 class="card-title">{{post.title}}</h5>
        </router-link>
      </div>
    </div>
    <hr>
    <button type="button" class="btn btn-info m-2" @click="previousPage">Previous</button>
    <button type="button" class="btn btn-info m-2" @click="nextPage">Next</button>
  </div>
</template>

<script>
export default {
  name: "PostsListComponent",
  data() {
    return {
      posts : [],
      cPage : 1,
      totalPage : 1
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
    getPosts() {
       let token = this.getToken();
       this.axios.get(`post?api_token=${token}&page=${this.cPage}`)
      .then((response) => {
        this.posts = (response.data.data);
        this.totalPage = response.data.meta.last_page;
      })
      .catch((error) => {
        console.log(error);
      })
    },
    previousPage() {
       let prev = (this.cPage <=1 ) ? 1 : this.cPage-1;
       this.cPage = prev;
       this.getPosts();
    },
    nextPage() {
      let nxt = (this.cPage >= this.totalPage ) ? this.totalPage : this.cPage+1;
      this.cPage = nxt;
      this.getPosts();
    }
  },
  created() {
    this.getPosts();
  }
}
</script>

<style scoped>

</style>