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
              v-if="!auth"
              >Login
            </router-link>
          </li>
          <li class="nav-item">
            <router-link
              class="nav-link font-weight-bold"
              :to="{ name: 'register' }"
              v-if="!auth"
              >Register
            </router-link>
          </li>
        </ul>

        <ul class="navbar-nav nav-tabs" v-if="auth">
          <li class="nav-item">
            <router-link
              class="nav-link font-weight-bold"
              :to="{ name: 'post' }"
              >Post
            </router-link>
          </li>
        </ul>
        {{ "role".role_id }}
        <ul class="navbar-nav nav-tabs" v-if="role_id == 1">
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
              :to="{ name: 'contactus' }"
              >Contact Us
            </router-link>
          </li>
        </ul>

        <ul class="navbar-nav nav-tabs justify-content-end" v-if="auth">
          <li class="nav-item">
            <router-link
              class="nav-link font-weight-bold"
              :to="{ name: 'profile' }"
              >Profile
            </router-link>
          </li>
          <li class="nav-item">
            <form @submit.prevent="logout">
              <button
                class="btn btn-sm btn-secondary mt-2"
                type="submit"
                v-if="auth"
              >
                Logout
              </button>
            </form>
          </li>
        </ul>
      </div>
    </nav>

    <router-view> </router-view>

    <footer class="page-footer font-small" style="background-color: white">
      <div class="container text-center">
        <div class="row">
          <div class="col">
            <h6 class="font-weight-bold text-uppercase mt-3 mb-1">
              User-Post-Vue
            </h6>
            <ul style="font-size: 15px" class="list-unstyled">
              <li>
                <router-link class="nav-link" :to="{ name: 'about' }"
                  >About us
                </router-link>
              </li>
              <li>
                <router-link class="nav-link" :to="{ name: 'contactus' }"
                  >Contact Us
                </router-link>
              </li>
            </ul>
          </div>

          <div class="col">
            <h6 class="font-weight-bold text-uppercase mt-3 mb-1">CONTACT</h6>
            <ul class="list-unstyled" style="font-size: 15px">
              <li>
                <p>No.111,Botahtaung <span>Township,Yangon</span></p>
              </li>
              <li>
                <p>superadmin@gmail.com</p>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <hr />
      <div class="footer-copyright text-center py-2">
        © 2021 Copyright:
        <a href="#" class="">superadmin@gmail.com</a>
      </div>
    </footer>
  </div>
</template>

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
  methods: {
    view() {
      axios.post("/api/users", { email: this.currentUser }).then((response) => {
        this.name = response.data.name;
        this.role_id = response.data.role_id;
        this.auth = true;
      });
    },
    logout() {
      axios.post("/api/logout").then(() => {
        this.$router.push("/about");
        this.auth = false;
        localStorage.clear();
      });
    },
  },
  created() {
    this.currentUser = localStorage.getItem("email");
    this.view();
  },
};
</script>
