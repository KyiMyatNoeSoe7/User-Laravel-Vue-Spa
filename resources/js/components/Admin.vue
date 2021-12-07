<template>
  <div class="container mb-5 mt-3">
    <h4 class="ml-2">User-List</h4>
    <div class="row justify-content-between">
      <div class="ml-3">
        <button class="btn btn-primary" @click="csvExport(csvData)">
          Export to CSV
        </button>
      </div>
      <div class="ml-5">
        <form @submit.prevent="searchUser">
          <div class="input-group">
            <input
              type="text"
              v-model="search"
              placeholder="Search"
              class="form-control"
            />
            <div class="input-group-append">
              <button type="submit" class="btn btn-primary">
                <i class="fa fa-search"></i>
              </button>
            </div>
          </div>
        </form>
      </div>
      <button class="btn btn-primary mr-3" @click="create">Create User</button>
      <div class="col-md-8">
        <div class="card mt-3">
          <div class="card-body text-center">
            <div class="table-responsive">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role Id</th>
                    <th>Password</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody v-if="users.length > 0">
                  <tr v-for="user in users" :key="user.id">
                    <td>{{ user.id }}</td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.role_id }}</td>
                    <td>{{ "********" }}</td>
                    <td>
                      <button
                        class="btn btn-success btn-sm"
                        @click="edit(user)"
                      >
                        <i class="fa fa-edit mr-1"></i>Edit
                      </button>
                      <button
                        class="btn btn-danger btn-sm ml-2"
                        @click="deleteUser(user.id)"
                      >
                        <i class="fa fa-trash-o"></i>
                        Delete
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-4 mb-5">
        <div class="card mt-3">
          <div class="card-header"
          :class="[doEdit == true ? 'change' : 'no-change']"
          >
            {{ doEdit ? "Edit" : "Create" }}
          </div>
          <div class="card-body">
            <form @submit.prevent="doEdit ? update() : store()">
              <div class="form-group">
                <label>Name:</label>
                <input
                  type="text"
                  class="form-control"
                  v-model="user.name"
                  placeholder="Enter name"
                  required
                />
                <small>{{ error_name }} </small>
              </div>
              <div class="form-group">
                <label>Email:</label>
                <input
                  type="email"
                  class="form-control"
                  v-model="user.email"
                  placeholder="Enter email"
                  required
                />
                <small>{{ error_email }} </small>
              </div>
              <div class="form-group">
                <label>Role-Id:</label>
                <select
                  v-model="user.role_id"
                  class="form-select form-control"
                  required
                >
                  <option disabled value="">Please select role-id..</option>
                  <option>1</option>
                  <option>2</option>
                </select>
                <small>{{ error }} </small>
              </div>
              <div class="form-group">
                <label>Password:</label>
                <div class="input-group">
                  <input
                    :type="[showPassword ? 'text' : 'password']"
                    class="form-control"
                    v-model="user.password"
                    placeholder="Enter password"
                    required
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
                  <small>{{ error_password }} </small>
                </div>
              </div>
              <div class="form-group">
                <label>Confirm Password:</label>
                <div class="input-group">
                  <input
                    :type="[showPassword ? 'text' : 'password']"
                    class="form-control"
                    v-model="user.password_confirm"
                    placeholder="Enter password"
                    @click.right.prevent
                    @keydown="keydown"
                    @copy.prevent
                    @paste.prevent
                    required
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
                Create
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style>
  .change {
    background-color: #4aa0e6;
    color: white;
  }
  .no-change {
    background-color: #ebedef;
  }
</style>

<script>
export default {
  data() {
    return {
      users: [],
      doEdit: false,
      search: "",
      user: {
        name: "",
        email: "",
        password: "",
        password_confrim: "",
        role_id: "",
      },
      showPassword: false,
      error_email: "",
      error_password: "",
      error_name: "",
      error: "",
    };
  },
  created() {
    this.getUser();
  },
  computed: {
    csvData() {
      return this.users.map((user) => ({
        id: user.id,
        name: user.name,
        email: user.email,
        password: user.password,
        role_id: user.role_id,
      }));
    },
  },

  methods: {
    getUser() {
      axios.get("/api/user").then((response) => {
        this.users = response.data;
      });
    },

    create() {
      this.doEdit = false;
      this.user.name = "";
      this.user.email = "";
      this.user.password = "";
      this.user.password_confrim = "";
      this.user.role_id = "";
    },
    store() {
      const data = new FormData();
      data.append("name", this.user.name);
      data.append("email", this.user.email);
      data.append("password", this.user.password);
      data.append("password_confrim", this.user.password_confrim);
      data.append("role_id", this.user.role_id);
      if (this.user.password !== this.user.password_confirm) {
        this.password = "";
        this.password_confrim = "";
        return alert("Passwords do not match");
      }
      axios
        .post("/api/register", data)
        .then((response) => {
          this.getUser();
          this.user.name = "";
          this.user.email = "";
          this.user.password = "";
          this.user.role_id = "";
          this.user.password_confrim = "";
        })
        .catch((error) => {
          console.error(error);
          this.error_password = error.response.data.error.password;
          this.error_email = error.response.data.error.email;
          this.error_name = error.response.data.error.name;
        });
    },
    keydown: function (e) {},

    edit(user) {
      this.doEdit = true;
      this.user.name = user.name;
      this.user.email = user.email;
      this.user.password_confrim = user.password_confrim;
      this.user.password = user.password;
      this.user.role_id = user.role_id;
    },
    update() {
      axios.put("/api/user/" + this.user.id, this.user).then((response) => {
        this.getUser();
        this.user.name = "";
        this.user.email = "";
        this.user.password = "";
        this.user.password_confrim = "";
        this.user.role_id = "";
        this.doEdit = false;
      });
    },

    deleteUser(id) {
      if (confirm("Are you sure to delete this user ?")) {
        axios.delete(`/api/user/${id}`).then((response) => {
          let i = this.users.map((data) => data.id).indexOf(id);
          this.users.splice(i, 1);
        });
      }
    },
    searchUser() {
      axios
        .post("/api/showUser", {
          keyword: this.search,
        })
        .then((response) => {
          this.users = response.data.data;
          this.search = "";
        });
    },
    csvExport(arrData) {
      let csvContent = "data:text/csv;charset=utf-8,";
      csvContent += [
        Object.keys(arrData[0]).join(","),
        ...arrData.map((user) => Object.values(user).join(",")),
      ].join("\n");

      const data = encodeURI(csvContent);
      const link = document.createElement("a");
      link.setAttribute("href", data);
      link.setAttribute("download", "post-export.csv");
      link.click();
    },
  },
};
</script>
