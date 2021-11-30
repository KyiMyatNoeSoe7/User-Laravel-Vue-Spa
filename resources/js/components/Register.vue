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
              <div class="form-group">
                <label>Confirm Password:</label>
                <div class="input-group">
                  <input
                    :type="[showPassword ? 'text' : 'password']"
                    class="form-control"
                    v-model="user.password_confirm"
                    placeholder="Enter your password"
                    @click.right.prevent
                    @keydown="keydown"
                    @copy.prevent
                    @paste.prevent
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
        role_id: 2,
      },
      showPassword: false,
    };
  },

  methods: {
    store() {
      if (this.password !== this.password_confirmation) {
        this.password = "";
        this.password_confrim = "";
        return alert("Passwords do not match");
      }
      axios
        .post("/api/register", this.user)
        .then(() => {
          this.$router.push("/login");
        })
        .catch((error) => console.log(error));
    },
    keydown: function (e) {
      console.log(e);
    },
  },
};
</script>
