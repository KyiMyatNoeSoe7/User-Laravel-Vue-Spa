<template>
  <div class="container my-5">
    <h3>Post List</h3>
    <div class="row justify-content-between ml-1 mt-3 mb-5">
      <button class="btn btn-primary" @click="create">Add Post</button>
      <div class="">
        <input
          class="border border-primary"
          type="file"
          @change="handleFileUpload($event)"
        />
        <button class="btn btn-primary nl-5" @click="submitFile">Upload</button>
      </div>
      <div class="">
        <button class="btn btn-primary" @click="csvExport(csvData)">
          Export to CSV
        </button>
      </div>
      <div class="mr-3">
        <form @submit.prevent="searchPost">
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
    </div>

    <div class="row">
      <div class="col-md-4">
        <div class="card">
          <div class="card-header">
            {{ doEdit ? "Edit" : "Create" }}
          </div>
          <div class="card-body">
            <form @submit.prevent="doEdit ? update() : store()">
              <div class="form-group">
                <label>Name</label>
                <input v-model="post.name" type="text" class="form-control" />
              </div>
              <div class="form-group">
                <label>Description</label>
                <textarea
                  v-model="post.description"
                  class="form-control"
                ></textarea>
              </div>
              <button type="submit" class="btn btn-primary">
                {{ doEdit ? "Update" : "Create" }}
              </button>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-8">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Description</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="post in posts" :key="post.id">
              <td>{{ post.id }}</td>
              <td>{{ post.name }}</td>
              <td>{{ post.description }}</td>
              <td>
                <button class="btn btn-success btn-sm" @click="edit(post)">
                  Edit
                </button>
                <button
                  class="btn btn-danger btn-sm ml-2"
                  @click="destroy(post.id)"
                >
                  Delete
                </button>
                <router-link
                  :to="{ name: 'postDetail', params: { id: post.id } }"
                  class="btn btn-success btn-sm ml-2"
                  type="submit"
                  >Post Detail</router-link
                >
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
      doEdit: false,
      search: "",
      file: "",
      posts: {},
      post: {
        id: "",
        name: "",
        description: "",
      },
    };
  },
  created() {
    this.view();
  },
  computed: {
    csvData() {
      console.log(this.posts);
      return this.posts.map((post) => ({
        id: post.id,
        name: post.name,
        description: post.description,
      }));
    },
  },

  methods: {
    view() {
      axios.get("/api/post").then((response) => {
        this.posts = response.data;
      });
    },
    create() {
      this.doEdit = false;
      this.post.id = "";
      this.post.name = "";
      this.post.description = "";
    },
    store() {
      const data = new FormData();
      data.append("name", this.post.name);
      data.append("description", this.post.description);
      axios.post("/api/post", data).then((response) => {
        this.view();
        this.post.id = "";
        this.post.name = "";
        this.post.description = "";
      });
    },
    edit(post) {
      this.doEdit = true;
      this.post.id = post.id;
      this.post.name = post.name;
      this.post.description = post.description;
    },
    update() {
      axios.put("/api/post/" + this.post.id, this.post).then((response) => {
        this.view();
        this.post.id = "";
        this.post.name = "";
        this.post.description = "";
        this.doEdit = false;
      });
    },
    destroy(id) {
      if (confirm("Are you sure to delete this post ?")) {
        axios.delete(`/api/post/${id}`).then((response) => {
          let i = this.posts.map((data) => data.id).indexOf(id);
          this.posts.splice(i, 1);
        });
      } else {
        alert("Your delete api is fail!!! ");
      }
    },
    searchPost() {
      console.log("showPost");
      axios
        .post("/api/showPost", {
          keyword: this.search,
        })
        .then((response) => {
          this.posts = response.data.data;
        });
    },
    csvExport(arrData) {
      let csvContent = "data:text/csv;charset=utf-8,";
      csvContent += [
        Object.keys(arrData[0]).join(","),
        ...arrData.map((post) => Object.values(post).join(",")),
      ].join("\n");

      const data = encodeURI(csvContent);
      const link = document.createElement("a");
      link.setAttribute("href", data);
      link.setAttribute("download", "post-export.csv");
      link.click();
    },
    handleFileUpload(event) {
      this.file = event.target.files[0];
    },
    submitFile() {
      var formData = new FormData();
      console.log("file:", this.file);
      formData.append("file", this.file);
      axios
        .post("/api/uploadCSVFile", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((response) => {
          console.log(response);
        });
    },
  },
};
</script>