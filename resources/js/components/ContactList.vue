<template>
  <div class="container mt-3">
    <h3 class="text-bold">Contact List</h3>
    <div class="row mt-1">
      <div class="col mb-5">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Email</th>
              <th>Message</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="contact in contacts" :key="contact.id">
              <td>{{ contact.id }}</td>
              <td>{{ contact.email }}</td>
              <td>{{ contact.message }}</td>
              <td>
                <button
                  class="btn btn-danger btn-sm ml-2"
                  @click="destroy(contact.id)"
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
</template>

<script>
export default {
  data() {
    return {
      contacts: [],
    };
  },
  created() {
    this.getContact();
  },

  methods: {
    getContact() {
      axios.get("/api/contact").then((response) => {
        this.contacts = response.data;
      });
    },
    destroy(id) {
      if (confirm("Are you sure to delete this contact ?")) {
        axios.delete(`/api/contact/${id}`).then((response) => {
          let i = this.contacts.map((data) => data.id).indexOf(id);
          this.contacts.splice(i, 1);
        });
      }
    },
  },
};
</script>
