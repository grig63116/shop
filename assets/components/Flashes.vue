<template>
  <div v-if="$appConfig.flashes.length" class="flash--messages">
    <Messages :messages="$appConfig.flashes.success" variant="success"></Messages>
    <Messages :messages="$appConfig.flashes.error" variant="danger"></Messages>
    <Messages :messages="$appConfig.flashes.warning" variant="warning"></Messages>
    <Messages :messages="$appConfig.flashes.info" variant="info"></Messages>
  </div>
</template>