<template>
  <ul>
    <learning-resource
      v-for="item in resources"
      :key="item.id"
      :id="item.id"
      :title="item.title"
      :description="item.description"
      :link="item.link"
    ></learning-resource>
  </ul>
</template>
<script>
import LearningResource from "./LearningResource.vue";

export default {
  components: {
    LearningResource,
  },
  inject: ["resources"],
};
</script>
<style>
ul {
  list-style: none;
  margin: 0;
  padding: 0;
  margin: auto;
  max-width: 40rem;
}
</style>
