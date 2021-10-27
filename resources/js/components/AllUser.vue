<template>
  <div class="container mt-5">
    <div class="row">
      <div class="col mb-5">
        <div class="card">
          <div class="card-body text-center">
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody v-if="users.length > 0">
                  <tr v-for="user in users" :key="user.id">
                    <td>{{ user.id }}</td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.password }}</td>
                    <td>
                      <router-link
                        :to="{ name: 'edit', params: { id: user.id } }"
                        class="btn btn-success ml-3"
                        type="submit"
                        >Edit</router-link
                      >
                      <button
                        class="btn btn-danger"
                        @click="deleteUser(user.id)"
                      >
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
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      users: [],
    };
  },
  created() {
    this.getUser();
  },

  methods: {
    getUser() {
      axios.get("/api/user").then((response) => {
        this.users = response.data;
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
  },
};
</script>
