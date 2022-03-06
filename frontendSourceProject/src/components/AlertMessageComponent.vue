<template>
  <div>
    <div class="alert alert-info">
      <b>{{message}}</b>
    </div>
  </div>
</template>

<script>
export default {
  name: "AlertMessageComponent",
  props: ['message']
}
</script>

<style scoped>

</style>