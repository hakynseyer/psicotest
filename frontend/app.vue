<script lang="ts" setup>
// [ ESCENCIALES ]
import { ref } from "vue";
import { EM } from "@Assets/ts/mitt";

// [ COMPONENTES ]
import Header from '@Components/header/header.vue';
import Footer from '@Components/footer/footer.vue';
import Alert from "@Components/alert/alert.vue";

// [ REF ]
const h1 = ref<string>("Examen Técnico");

// [ EVENTBUS ]
EM.on("APP_h1", (title: string): void => {
  h1.value = title;
});

</script>

<template lang="pug">
Header(title='Psicotest')
Alert
.content
  h1 {{ h1 }}
  router-view
Footer
</template>

<style lang="sass">
@import "@Assets/sass/init.sass";
</style>
