<template>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card mb-5">
          <div class="card-header text-center">Contact Us</div>
          <div class="card-body">
            <form @submit.prevent="contactEnter">
              <div class="form-group">
                <label>Email</label>
                <input
                  v-model="email"
                  type="text"
                  class="form-control"
                  placeholder="Your Email"
                />
              </div>
              <div class="form-group">
                <label>Message</label>
                <textarea
                  v-model="message"
                  class="form-control"
                  placeholder="Message"
                ></textarea>
              </div>
              <button type="submit" class="btn btn-primary ml-5">
                Send Mail
              </button>
              <router-link
                :to="{ name: 'post' }"
                class="btn btn-outline-secondary ml-3"
                >Cancel</router-link
              >
            </form>
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
      email: "",
      message: "",
    };
  },
  methods: {
    contactEnter() {
      axios
        .post("/api/store", { email: this.email, message: this.message })
        .then((response) => {
          email = this.email;
        });
      axios
        .post("/api/mail", { email: this.email, message: this.message })
        .then((response) => {
          email = this.email;
          message = this.message;
          console.log("Success");
        });
    },
  },
};
</script>


