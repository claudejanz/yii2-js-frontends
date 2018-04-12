<template>
  <div>
    <v-form>
      <v-text-field
      label="title"
      name="title"
      v-model="topic.title"
      required
      ></v-text-field>
      <div v-if='errors' v-html="errors.title" class='red--text' />
      <br>
      <slot>
        Content here
      </slot>
    </v-form>
  </div>
</template>

<script>
export default {
  props: ['topic', 'errors']
};
</script>
