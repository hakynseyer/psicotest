<script lang="ts" setup>
import { ref } from 'vue';
import { useStore } from '@Assets/ts/store';

// [TS]
import { DateClass } from './ts/date';

// [REF]
const TheDate = ref<DateClass>(new DateClass());

// PINIA
const pinia = useStore();

// PROPS
interface Props {
  title?: string;
  description?: string;
}

withDefaults(defineProps<Props>(), {
  title: 'Joaquin R. S.',
  description: 'Desarrollador de esta applicación',
});
</script>

<template lang="pug">
footer.footer
  .footer__contact
    span {{ title }}
    span {{ description }}
    span {{ TheDate.currentDate }}
  .footer__thanks
    .footer__thanks__row
      i.footer__thanks__row__icon.material-icons face
      span.footer__thanks__row__text {{ pinia.creador }}
    .footer__thanks__row
      i.footer__thanks__row__icon.material-icons mail
      span.footer__thanks__row__text {{ pinia.creadorEmail }}
</template>

<style lang="sass" scope>
@import './footer'
</style>
