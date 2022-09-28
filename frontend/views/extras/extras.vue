<script lang="ts" setup>
// [ESCENCIALES]
import {ref, onMounted, onBeforeUnmount} from 'vue'
import {EM} from '@Assets/ts/mitt'

import "leaflet/dist/leaflet.css"
import L from 'leaflet'

// [COMPONENTES]
import Table from '@Components/table/table.vue'
import Form from './components/form.vue'

// [TS]
import {ExtrasClass} from './extras'
import {TableClass} from './ts/table'
import {TableModalClass} from './ts/tableModal'

// [REF]
const Extras = ref<ExtrasClass>(new ExtrasClass())
const TableExtras = ref<TableClass>(new TableClass())
const TableModal = ref<TableModalClass>(new TableModalClass())

const mapLeaflet = ref<L>(null)

// [HOOKS]
onMounted(async() => {
  await TableExtras.value.listExtras()

  // Cargando el mapa Leaflet
  mapLeaflet.value = L.map('mapContainer').setView([23.63, -102.55], 5)
  await setInterval(() => {
    mapLeaflet.value.invalidateSize()
  }, 2000)
  L.tileLayer("http://{s}.tile.osm.org/{z}/{x}/{y}.png", {
      attribution:
        '&copy; <a href="https://github.com/hakynseyer", target="_blank">Joaquin Reyes Sanchez</a> desarrollador',
    }).addTo(mapLeaflet.value)
})

onBeforeUnmount(() => {
  if (mapLeaflet.value) mapLeaflet.value.remove()
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
      modalSlot="location_on",
      @activeDelete="TableExtras.deleteExtraSelected($event)",
      @activeModal="TableModal.setExtra($event)",
      @itemSelected="TableExtras.saveExtraSelected($event)",
      @searchData="TableExtras.searchExtra($event)"
    )
      .extras__table__modal
        h3 Ubicación del Usuario
        .extras__table__modal__user
          .extras__table__modal__user__row
            i.material-icons face
            span {{TableModal.extra.userName}}
          .extras__table__modal__user__row
            i.material-icons location_city
            span {{TableModal.extra.country}}
          .extras__table__modal__user__row
            i.material-icons location_on
            span {{TableModal.extra.city}}
        .extras__table__modal__controls
          button(type="button") actualizar
        .extras__table__modal__map(id="mapContainer")
  .extras__actions
    h2 {{Extras.titleForm}}
    Form
</template>

<style lang="sass" scoped>
@import './extras.sass'
</style>
