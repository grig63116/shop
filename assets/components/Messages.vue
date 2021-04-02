<template>
  <div :class="`flash--messages-${variant}`">
    <b-alert v-for="(message,i) in messages"
             :key="`message-${variant}-${i}`"
             show
             :variant="variant">
      {{ message }}
    </b-alert>
  </div>
</template>

<script>
export default {
  props: {
    messages: Array,
    variant: String
  }
}
</script>