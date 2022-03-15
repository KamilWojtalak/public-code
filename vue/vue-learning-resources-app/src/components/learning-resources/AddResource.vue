<template>
  <base-dialog v-if="inputIsInvalid" title="Invalid Input" @close="confirmError">
    <template #default>
      <p>Unfortunately, at least one input value is invalid</p>
      <p>
        Please check all inputs and make sure you enter at least a few charactes
        into each input field.
      </p>
    </template>
    <template #actions>
      <base-button @click="confirmError">Okay</base-button>
    </template>
  </base-dialog>
  <base-card>
    <form action="" @submit.prevent="submitForm">
      <div class="form-control">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" value="test title" />
      </div>
      <div class="form-control">
        <label for="description">Description</label>
        <textarea name="description" id="description" cols="30" rows="3">
test description</textarea
        >
      </div>
      <div class="form-control">
        <label for="link">Link</label>
        <input type="text" name="link" id="link" value="test link" />
      </div>
      <div>
        <base-button type="submit">Add Resource</base-button>
      </div>
    </form>
  </base-card>
</template>
<script>
const formDataToObject = (form) => {
  return Object.fromEntries([...new FormData(form)]);
};

export default {
  data() {
    return {
      inputIsInvalid: false,
    };
  },
  inject: ["addResource"],
  methods: {
    submitForm(e) {
      const formData = formDataToObject(e.currentTarget);

      if (
        !formData.title.trim() ||
        !formData.description.trim() ||
        !formData.link.trim()
      ) {
        this.inputIsInvalid = true;
        return;
      }

      this.addResource(formData);
    },
    confirmError() {
      this.inputIsInvalid = false;
    },
  },
};
</script>
<style scoped>
label {
  font-weight: bold;
  display: block;
  margin-bottom: 0.5rem;
}

input,
textarea {
  display: block;
  width: 100%;
  font: inherit;
  padding: 0.15rem;
  border: 1px solid #ccc;
}

input:focus,
textarea:focus {
  outline: none;
  border-color: #3a0061;
  background-color: #f7ebff;
}

.form-control {
  margin: 1rem 0;
}
</style>
