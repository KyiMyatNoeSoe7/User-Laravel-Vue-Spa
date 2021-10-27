<template>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-4">
        <div class="card mb-5">
          <div class="card-header text-center">Login</div>
          <div class="card-body">
            <form @submit.prevent="loginEnter">
              <div class="form-group">
                <label>Email:</label>
                <input
                  type="text"
                  v-model="user.email"
                  class="form-control"
                  placeholder="Enter your email"
                />
              </div>
              <div class="form-group">
                <label>Password:</label>
                <input
                  type="text"
                  v-model="user.password"
                  class="form-control"
                  placeholder="Enter your password"
                />
              </div>
              <button type="submit" class="btn btn-primary btn-block">
                Login
              </button>
            </form>
          </div>
          <div class="card-footer">
            <div>
              <span class="text-muted">Don't have an account? </span>
              <router-link :to="{ name: 'register'}">Register</router-link>
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
      user: {
        email: "",
        password: "",
      },
    };
  },

  methods: {
    loginEnter() {
      axios.post("/api/login", this.user).then(() => {
        this.$router.push("/alluser");
      });
      localStorage.setItem("email", this.user.email);
    },
  },
};
</script>
