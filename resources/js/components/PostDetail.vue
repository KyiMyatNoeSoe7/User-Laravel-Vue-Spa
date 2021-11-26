<template>
  <div class="container mt-5 mb-5 profile">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header text-center"><h5>Post Details</h5></div>
          <div class="row">
            <div class="col-md-12">
              <ul class="list-group list-group-flush">
                <li class="list-group-item py-4">
                  <span class="text-primary">Name: </span>{{ post.name }}
                </li>
                <li class="list-group-item py-4">
                  <span class="text-primary">Description: </span>{{ post.description }}
                </li>
              </ul>
            </div>
          </div>
          <div class="card-footer">
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