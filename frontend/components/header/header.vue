<script lang="ts" setup>
import { ref } from 'vue';
import { useStore } from '@Assets/ts/store';

// [TS]
import { UrlClass } from './ts/url';

// [REF]
const Url = ref<UrlClass>(new UrlClass());

// PINIA
const pinia = useStore();

// PROPS
interface Props {
  title?: string;
}

withDefaults(defineProps<Props>(), {
  title: 'Arlequin',
});
</script>

<template lang="pug">
header.header
  .header__logo
    h2(@click='Url.sendToHome()') {{ title }}
  nav.header__menu
    ul
      li(v-for='(url, index) in Url.urls', :key='index')
        router-link(:to='url.path') {{ url.name }}
  .header__user
    .header__user__info
      i.material-icons account_circle
      .header__user__info__data
        span {{ pinia.creador }}
        span {{ pinia.creadorEmail }}
</template>

<style lang="sass" scope>
@import './header';
</style>
