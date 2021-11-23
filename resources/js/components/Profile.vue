<template>
  <div class="container mt-5 mb-5 profile">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header text-center"><h5>Profile</h5></div>
          <div class="row">
            <div class="col-md-12">
              <ul class="list-group list-group-flush">
                <li class="list-group-item py-4">
                  <span class="text-primary">Name: </span>{{ name }}
                </li>
                <li class="list-group-item py-4">
                  <span class="text-primary">Email: </span>{{ email }}
                </li>
              </ul>
            </div>
          </div>
          <div class="card-footer">
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "profile",
  data() {
    return {
      name: null,
      email: null,
      currentUser: null,
    };
  },
  created() {
    this.currentUser = localStorage.getItem("email");
    if (this.currentUser) {
      this.view();
    }
  },

  methods: {
    view() {
      axios
        .post("/api/profile", { email: this.currentUser })
        .then((response) => {
          if (response.data) {
            this.name = response.data.name;
            this.email = response.data.email;
          }
        })
        .catch((error) => console.log(error));
    },
  },
};
</script>