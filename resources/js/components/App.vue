<template>
  <div class="container">
    <nav
      class="navbar navbar-expand-lg navbar-light border-bottom"
      style="background-color: white"
    >
      <a class="navbar-brand font-weight-bold" href="#">User-Post-Spa</a>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav">
          <li class="nav-item">
            <router-link
              class="nav-link font-weight-bold"
              :to="{ name: 'home' }"
              :class="[this.$route.name == 'home' ? 'active' : 'no-active']"
              >Home
            </router-link>
          </li>
          <li class="nav-item">
            <router-link
              class="nav-link font-weight-bold"
              :to="{ name: 'about' }"
              :class="[this.$route.name == 'about' ? 'active' : 'no-active']"
              >About
            </router-link>
          </li>
          <li class="nav-item">
            <router-link
              class="nav-link font-weight-bold"
              :to="{ name: 'login' }"
              v-if="role_id == null"
              :class="[this.$route.name == 'login' ? 'active' : 'no-active']"
              >Login
            </router-link>
          </li>
          <li class="nav-item">
            <router-link
              class="nav-link font-weight-bold"
              :to="{ name: 'register' }"
              v-if="role_id == null"
              :class="[this.$route.name == 'register' ? 'active' : 'no-active']"
              >Register
            </router-link>
          </li>
        </ul>

        <ul class="navbar-nav" v-if="role_id != null && auth == true">
          <li class="nav-item">
            <router-link
              class="nav-link font-weight-bold"
              :to="{ name: 'post' }"
              :class="[this.$route.name == 'post' ? 'active' : 'no-active']"
              >Post
            </router-link>
          </li>
        </ul>
        {{ "role".role_id }}
        <ul class="navbar-nav" v-if="role_id == 1 && auth == true">
          <li class="nav-item">
            <router-link
              class="nav-link font-weight-bold"
              :to="{ name: 'admin' }"
              :class="[this.$route.name == 'admin' ? 'active' : 'no-active']"
              >Admin
            </router-link>
          </li>
          <li class="nav-item">
            <router-link
              class="nav-link font-weight-bold"
              :to="{ name: 'contactList' }"
              :class="[
                this.$route.name == 'contactList' ? 'active' : 'no-active',
              ]"
              >Contact List
            </router-link>
          </li>
        </ul>

        <ul class="navbar-nav ml-auto">
          <li class="contact nav-item">
            <router-link
              class="nav-link font-weight-bold"
              :to="{ name: 'contactUs' }"
              :class="[
                this.$route.name == 'contactUs' ? 'active' : 'no-active',
              ]"
              >Contact Us
            </router-link>
          </li>
        </ul>

        <ul class="navbar-nav ml-auto">
          <li class="nav-item dropdown" v-if="role_id != null && auth == true">
            <a
              class="nav-link dropdown-toggle font-weight-bold"
              href="#"
              id="navbarDropdown"
              role="button"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              {{ name }}
            </a>
            <div
              class="dropdown-menu dropdown-menu-right"
              aria-labelledby="navbarDropdown"
            >
              <router-link
                class="nav-link ml-5 font-weight-bold"
                :to="{ name: 'profile' }"
                >Profile
              </router-link>
              <div class="dropdown-divider"></div>
              <form @submit.prevent="logout">
                <button type="submit" class="btn btn-block">
                  <i class="fa fa-power-off"></i> Logout
                </button>
              </form>
            </div>
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
.contact {
  margin-left: 420px;
}
.active {
  cursor: pointer;
  border: solid #f5f5f5 2px;
  border-radius: 5px;
}
.no-active {
  color: rgb(66, 64, 66);
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
        localStorage.setItem("name", this.name);
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
