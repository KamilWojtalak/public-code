<template>
  <base-card>
    <base-button
      @click="setSelectedTab('stored-resources')"
      :mode="stoResButtonMode"
    >
      Stored Resources
    </base-button>
    <base-button
      @click="setSelectedTab('add-resource')"
      :mode="addResButtonMode"
    >
      Add Resources
    </base-button>
  </base-card>
  <keep-alive>
    <component :is="selectedTab"></component>
  </keep-alive>
</template>
<script>
import StoredResources from "./StoredResources.vue";
import AddResource from "./AddResource.vue";

/** Helpers section */
const IdFromTitle = (title) => {
  return (
    title.toLowerCase().trim().replaceAll(" ", "-") + new Date().toISOString()
  );
};

const createNewResourceObject = (id, formData) => {
  return {
    id,
    title: formData.title,
    description: formData.description,
    link: formData.link,
  };
};

export default {
  components: {
    StoredResources,
    AddResource,
  },
  data() {
    return {
      selectedTab: "stored-resources",
      storedResources: [
        {
          id: "official-guide",
          title: "Official Guide",
          description: "The officaial Vue.js documentation",
          link: "https://vuejs.org",
        },
        {
          id: "google",
          title: "Google",
          description: "Learn to google...",
          link: "https://google.com",
        },
      ],
    };
  },
  provide() {
    return {
      resources: this.storedResources,
      addResource: this.addResource,
      deleteResource: this.deleteResource,
    };
  },
  computed: {
    stoResButtonMode() {
      return this.selectedTab === "stored-resources" ? null : "flat";
    },
    addResButtonMode() {
      return this.selectedTab === "add-resource" ? null : "flat";
    },
  },
  methods: {
    setSelectedTab(tab) {
      this.selectedTab = tab;
    },
    addResource(formData) {
      const id = IdFromTitle(formData.title);
      const newResource = createNewResourceObject(id, formData);
      /** Add new resource */
      this.storedResources.unshift(newResource);
      /** Change tab */
      this.selectedTab = "stored-resources";
    },
    deleteResource(resId) {
        const resourceIndex = this.storedResources.findIndex((el) => el.id === resId);
        this.storedResources.splice(resourceIndex, 1);
    }
  },
};
</script>
<style></style>
