<template>
  <div class="container">
    <nav
      class="navbar navbar-expand-lg navbar-light border-bottom"
      style="background-color: white"
    >
      <a class="navbar-brand font-weight-bold" href="#">User-Post-Spa</a>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav nav-tabs">
          <li class="nav-item">
            <router-link
              class="nav-link font-weight-bold"
              :to="{ name: 'home' }"
              >Home
            </router-link>
          </li>
          <li class="nav-item">
            <router-link
              class="nav-link font-weight-bold"
              :to="{ name: 'about' }"
              >About
            </router-link>
          </li>
          <li class="nav-item">
            <router-link
              class="nav-link font-weight-bold"
              :to="{ name: 'login' }"
              v-if="role_id == null"
              >Login
            </router-link>
          </li>
          <li class="nav-item">
            <router-link
              class="nav-link font-weight-bold"
              :to="{ name: 'register' }"
              v-if="role_id == null"
              >Register
            </router-link>
          </li>
        </ul>

        <ul class="navbar-nav nav-tabs" v-if="role_id != null && auth == true">
          <li class="nav-item">
            <router-link
              class="nav-link font-weight-bold"
              :to="{ name: 'post' }"
              >Post
            </router-link>
          </li>
        </ul>
        {{ "role".role_id }}
        <ul class="navbar-nav nav-tabs" v-if="role_id == 1 && auth == true">
          <li class="nav-item">
            <router-link
              class="nav-link font-weight-bold"
              :to="{ name: 'admin' }"
              >Admin
            </router-link>
          </li>
          <li class="nav-item">
            <router-link
              class="nav-link font-weight-bold"
              :to="{ name: 'contactList' }"
              >Contact List
            </router-link>
          </li>
        </ul>

        <ul class="navbar-nav nav-tabs ml-5 ml-auto justify-content-end">
          <li class="nav-item">
            <router-link
              class="nav-link font-weight-bold"
              :to="{ name: 'contactUs' }"
              >Contact Us
            </router-link>
          </li>
        </ul>

        <ul
          class="navbar-nav nav-tabs justify-content-end"
          v-if="role_id != null && auth == true"
        >
          <li class="nav-item">
            <router-link
              class="nav-link font-weight-bold"
              :to="{ name: 'profile' }"
              >Profile
            </router-link>
          </li>
          <li class="nav-item ml-1">
            <form @submit.prevent="logout">
              <button
                type="submit"
                class="btn btn-sm btn-outline-secondary mt-1"
              >
                <i class="fa fa-power-off"></i> Logout
              </button>
            </form>
          </li>
        </ul>
      </div>
    </nav>

    <router-view> </router-view>

    <div class="footer" style="background-color: white">
      <div class="text-center py-2">
        © 2021 Copyright:
        <a href="#" class="">superadmin@gmail.com</a>
      </div>
    </div>
  </div>
</template>
<style>
.footer {
  position: fixed;
  bottom: 0;
  width: 83%;
}
</style>


<script>
export default {
  data() {
    return {
      name: null,
      auth: false,
      role_id: null,
      currentUser: null,
    };
  },
  created() {
    this.currentUser = localStorage.getItem("email");
    this.view();
  },
  methods: {
    view() {
      axios.post("/api/users", { email: this.currentUser }).then((response) => {
        this.name = response.data.name;
        this.role_id = response.data.role_id;
        this.auth = true;
        localStorage.setItem("auth", this.auth);
      });
    },
    logout() {
      axios.post("/api/logout").then(() => {
        this.auth = false;
        localStorage.clear();
        this.$router.push("/login");
      });
    },
  },
};
</script>
