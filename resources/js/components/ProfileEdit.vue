<template>
  <div class="container mt-5 mb-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header text-center">Profile Edit</div>
          <div class="card-body">
            <form @submit.prevent="updateUser">
              <div class="form-group">
                <label>Name:</label>
                <input type="text" class="form-control" v-model="user.name" />
              </div>
              <div class="form-group">
                <label>Email:</label>
                <input type="text" class="form-control" v-model="user.email" />
              </div>
              <div class="form-group">
                <label>Password:</label>
                <input
                  type="text"
                  class="form-control"
                  v-model="user.password"
                />
              </div>
              <button class="btn btn-primary float-left" type="submit">
                Update
              </button>
              <router-link
                :to="{ name: 'alluser', params: { id: user.id } }"
                class="btn btn-outline-dark float-right"
                type="reset"
                >Cancel</router-link
              >
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      user: {
        name: "",
        email: "",
        password: "",
        password_confrim: "",
      },
    };
  },
  created() {
    this.edit();
  },

  methods: {
    view() {
      axios.get("/api/users").then((response) => {
        this.users = response.data;
      });
    },
    edit() {
      axios.get(`/api/user/${this.$route.params.id}`).then((response) => {
        this.user.id = response.data.id;
        this.user.name = response.data.name;
        this.user.email = response.data.email;
        this.user.password = response.data.password;
      });
    },
    updateUser() {
      axios
        .put(`/api/user/${this.$route.params.id}`, this.user)

        .then(() => {
          this.view();
          this.user.name = "";
          this.user.email = "";
          this.user.password = "";
          this.$router.push({
            name: "alluser",
          });
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
};
</script>
