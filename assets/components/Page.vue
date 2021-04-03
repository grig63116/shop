<template>
  <div id="app" class="app d-flex flex-column">
    <Header></Header>
    <Flashes></Flashes>
    <main>
      <b-container>
        <slot></slot>
      </b-container>
    </main>
    <Footer class="mt-auto"></Footer>
  </div>
</template>