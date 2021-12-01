<template>
  <div class="container my-3">
    <div class="row mt-1">
      <div class="col-md-6">
        <h4 class="ml-2">User-List</h4>
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Role Id</th>
              <th>Password</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in users" :key="user.id">
              <td>{{ user.id }}</td>
              <td>{{ user.name }}</td>
              <td>{{ user.email }}</td>
              <td>{{ user.role_id }}</td>
              <td>{{ "********" }}</td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="col-md-6">
        <h4 class="ml-2">Post List</h4>
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Description</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="post in posts" :key="post.id">
              <td>{{ post.id }}</td>
              <td class="post-width">{{ post.name }}</td>
              <td class="post-width">{{ post.description }}</td>
              <td>
                <button
                  class="btn btn-danger btn-sm ml-2"
                  @click="destroy(post.id)"
                >
                  <i class="fa fa-trash-o"></i>
                  Delete
                </button>
                <router-link
                  :to="{ name: 'postDetail', params: { id: post.id } }"
                  class="btn btn-info btn-sm m-1"
                  type="submit"
                  ><i class="fa fa-eye mr-1"></i>Post Detail</router-link
                >
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>
<style>
.post-width {
  max-width: 135px;
}
</style>
<script>
export default {
  data() {
    return {
      users: [],
      posts: {},
      post: {
        id: "",
        name: "",
        description: "",
      },
    };
  },
  created() {
    this.getUser();
    this.view();
  },

  methods: {
    getUser() {
      axios.get("/api/user").then((response) => {
        this.users = response.data;
      });
    },
    destroy(id) {
      if (confirm("Are you sure to delete this post ?")) {
        axios.delete(`/api/post/${id}`).then((response) => {
          let i = this.posts.map((data) => data.id).indexOf(id);
          this.posts.splice(i, 1);
        });
      } else {
        alert("Your delete api is fail!!! ");
      }
    },
    view() {
      axios.get("/api/post").then((response) => {
        this.posts = response.data;
      });
    },
  },
};
</script>
