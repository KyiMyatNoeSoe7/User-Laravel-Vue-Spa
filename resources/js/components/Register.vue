<template>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card mb-5">
          <div class="card-header text-center">Register</div>
          <div class="card-body">
            <form @submit.prevent="store">
              <div class="form-group">
                <label>Name:</label>
                <input
                  type="text"
                  class="form-control"
                  v-model="user.name"
                  placeholder="Enter your name"
                />
              </div>
              <div class="form-group">
                <label>Email:</label>
                <input
                  type="text"
                  class="form-control"
                  v-model="user.email"
                  placeholder="Enter your email"
                />
              </div>
              <div class="form-group">
                <label>Password:</label>
                <input
                  type="text"
                  class="form-control"
                  v-model="user.password"
                  placeholder="Enter your password"
                />
              </div>
              <div class="form-group">
                <label>Confirm Password:</label>
                <input
                  type="text"
                  class="form-control"
                  v-model="user.password_confirm"
                  placeholder="Enter your password"
                />
              </div>
              <button type="submit" class="btn btn-primary btn-block">
                Register
              </button>
            </form>
          </div>
          <div class="card-footer">
            <div>
              <span class="text-muted">Do you have an account? </span>
              <router-link :to="{ name: 'login', params: { id: user.id } }"
                >Login Here</router-link
              >
            </div>
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
      users: [],
      user: {
        name: "",
        email: "",
        password: "",
        password_confrim: "",
      },
    };
  },

  methods: {
    store() {
      if (this.password === this.password_confirmation) {
        axios.post("/api/register", this.user).then(() => {
          this.$router.push("/login");
        });
      } else {
        this.password = "";
        this.password_confrim = "";
        return alert("Passwords do not match");
      }
    },
  },
};
</script>
