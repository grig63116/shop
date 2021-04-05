<template>
  <div id="app" class="app d-flex flex-column">
    <Header></Header>
    <Flashes></Flashes>
    <main>
      <b-container class="py-3">
        <slot></slot>
      </b-container>
    </main>
    <Footer class="mt-auto"></Footer>
  </div>
</template>
<script>
export default {
  mounted () {
    console.log(this);
  }
}
</script>