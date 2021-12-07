<template>
  <div class="container my-5">
    <h3>Post List</h3>
    <div class="row justify-content-between ml-1 mt-3 mb-5">
      <button class="btn btn-primary" @click="create">Add Post</button>
      <div>
        <input
          class="border border-primary"
          type="file"
          @change="handleFileUpload($event)"
        />
        <button class="btn btn-primary nl-5" @click="submitFile">Upload</button>
      </div>
      <div>
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
          <div
            class="card-header"
            :class="[doEdit == true ? 'change' : 'no-change']"
          >
            {{ doEdit ? "Edit" : "Create" }}
          </div>
          <div class="card-body">
            <form @submit.prevent="doEdit ? update() : store()">
              <div class="form-group">
                <label>Name</label>
                <input
                  v-model="post.name"
                  type="text"
                  class="form-control"
                  required
                />
                <small>{{ error }} </small>
              </div>

              <div class="form-group">
                <label>Description</label>
                <textarea
                  v-model="post.description"
                  class="form-control"
                  required
                ></textarea>
                <small>{{ error }} </small>
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
              <td class="post-width">{{ post.name }}</td>
              <td class="post-width">{{ post.description }}</td>
              <td>
                <button class="btn btn-success btn-sm" @click="edit(post)">
                  <i class="fa fa-edit mr-1"></i>Edit
                </button>
                <button
                  class="btn btn-danger btn-sm ml-2"
                  @click="destroy(post.id)"
                >
                  <i class="fa fa-trash-o"></i>
                  Delete
                </button>

                <button
                  type="button"
                  class="btn btn-info btn-sm m-1"
                  @click="detail(post)"
                  data-toggle="modal"
                  data-target="#exampleModalCenter"
                >
                  <i class="fa fa-eye mr-1"></i>Post Detail
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div
      class="modal fade"
      id="exampleModalCenter"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalCenterTitle"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Post Details</h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <ul class="list-group list-group-flush">
              <li class="list-group-item py-4">
                <span class="text-primary">Name: </span>{{ post.name }}
              </li>
              <li class="list-group-item py-4">
                <span class="text-primary">Description: </span
                >{{ post.description }}
              </li>
            </ul>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary btn-sm"
              data-dismiss="modal"
            >
              <i class="fa fa-arrow-circle-left mr-1"></i>Close
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style>
.post-width {
  max-width: 135px;
}
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
      doEdit: false,
      search: "",
      file: "",
      error: "",
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
    detail(post) {
      this.post.name = post.name;
      this.post.description = post.description;
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
          this.search = "";
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
