<script lang="ts" setup>
// [ESCENCIALES]
import {ref, onMounted} from 'vue'
import {EM} from '@Assets/ts/mitt'

// [COMPONENTES]
import Table from '@Components/table/table.vue'
import Form from './components/form.vue'

// [TS]
import {ExtrasClass} from './extras'
import {TableClass} from './ts/table'

// [REF]
const Extras = ref<ExtrasClass>(new ExtrasClass())
const TableExtras = ref<TableClass>(new TableClass())

// [HOOKS]
onMounted(async() => {
  await TableExtras.value.listExtras()
})

// [EVENTBUS]
EM.emit('APP_h1', 'Usuarios Extras')

EM.on("VIEW_EXTRAS_titleForm", (title: string): void => {
  Extras.value.titleForm = title;
});
EM.on("VIEW_EXTRAS_updateTable", async (): Promise<void> => {
  await TableExtras.value.listExtras();
});
</script>

<template lang="pug">
.extras
  .extras__table
    Table(
      :header="TableExtras.headers",
      :data="TableExtras.extras",
      :deleteIcon="true",
      @activeDelete="TableExtras.deleteExtraSelected($event)",
      @itemSelected="TableExtras.saveExtraSelected($event)",
      @searchData="TableExtras.searchExtra($event)"
    )
  .extras__actions
    h2 {{Extras.titleForm}}
    Form
</template>

<style lang="sass" scoped>
@import './extras.sass'
</style>
