<template>
  <div>
    <v-form>
        <v-text-field
        label="title"
        name="title"
        required
        ></v-text-field>
        <div v-html="errors.title" class='red--text' />
        <br>
        <slot/>
    </v-form>
  </div>
</template>

<script>
export default {
  props: [
    'topic',
    'errors'
  ],
}
</script>
