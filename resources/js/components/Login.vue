<template>
  <div class="container mt-5 mb-5">
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
                <div class="input-group">
                  <input
                    :type="[showPassword ? 'text' : 'password']"
                    class="form-control"
                    v-model="user.password"
                    placeholder="Enter your password"
                  />
                  <div class="input-group-append">
                    <span
                      class="input-group-text"
                      @click="showPassword = !showPassword"
                      ><i
                        class="fa"
                        :class="[showPassword ? 'fa-eye' : 'fa-eye-slash']"
                        aria-hidden="true"
                      ></i
                    ></span>
                  </div>
                </div>
              </div>
              <button type="submit" class="btn btn-primary btn-block">
                Login
              </button>
            </form>
          </div>
          <div class="card-footer">
            <div>
              <span class="text-muted">Don't have an account? </span>
              <router-link :to="{ name: 'register' }">Register</router-link>
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
      showPassword: false,
    };
  },

  methods: {
    loginEnter() {
      axios.post("/api/login", this.user).then(() => {
        this.$router.push({ name: "home" });
      });
      localStorage.setItem("email", this.user.email);
    },
  },
};
</script>
