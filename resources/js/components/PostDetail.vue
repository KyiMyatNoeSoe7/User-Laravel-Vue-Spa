<template>
  <div class="container mt-5">
    <div class="card p-5">
      <div class="row">
        <div class="col-md-8">
          <h1>{{ post.name }}</h1>
          <div>{{ post.description }}</div>
          <div>
            <router-link
              :to="{ name: 'post' }"
              class="btn btn-outline-secondary btn-sm mt-3"
            >
              Go Back
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "PostDetail",
  data() {
    return {
      post: [],
    };
  },
  methods: {
    getPost() {
      axios
        .get(`/api/post/${this.$route.params.id}`)
        .then((response) => {
          this.post = response.data;
        })
        .catch((error) => console.log(error));
    },
  },
  created() {
    this.getPost();
  },
};
</script>