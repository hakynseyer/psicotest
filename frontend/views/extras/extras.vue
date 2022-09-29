<script lang="ts" setup>
// [ESCENCIALES]
import {ref, onMounted, onBeforeUnmount} from 'vue'
import {EM} from '@Assets/ts/mitt'

import * as Interfaces from "@TS/interfaces";

import "leaflet/dist/leaflet.css"
import L from 'leaflet'
/* delete L.Icon.Default.prototype._getIconUrl; */
/* import * as iconA from 'leaflet/dist/images/marker-icon-2x.png' */
/* import * as iconB from 'leaflet/dist/images/marker-icon.png' */
/* import * as iconC from 'leaflet/dist/images/marker-shadow.png' */

/* L.Icon.Default.mergeOptions({ */
/*    iconRetinaUrl: iconA, */
/*    iconUrl: iconB, */
/*    shadowUrl: iconC, */
/* }); */

// [COMPONENTES]
import Table from '@Components/table/table.vue'
import Form from './components/form.vue'

// [TS]
import {ExtrasClass} from './extras'
import {TableClass} from './ts/table'
import {TableModalClass} from './ts/tableModal'

import { cordinatesMexico } from "@TS/data/mexico";

interface Map_Cords {
  lat: number,
  lng: number
}

// [REF]
const Extras = ref<ExtrasClass>(new ExtrasClass())
const TableExtras = ref<TableClass>(new TableClass())
const TableModal = ref<TableModalClass>(new TableModalClass())

const mapLeaflet = ref<L>(null)
const addMarker = ref<boolean>(false)

// [HOOKS]
onMounted(async() => {
  await TableExtras.value.listExtras()
})

onBeforeUnmount(async () => {
  if (mapLeaflet.value) mapLeaflet.value.remove()

  EM.all.clear()
})

// [EVENTBUS]
EM.emit('APP_h1', 'Usuarios Extras')

EM.on("VIEW_EXTRAS_titleForm", (title: string): void => {
  Extras.value.titleForm = title;
});
EM.on("VIEW_EXTRAS_updateTable", async (): Promise<void> => {
  await TableExtras.value.listExtras();
});
EM.on("VIEW_EXTRAS_mapLeaflet", async (map: Interfaces.TypeExtrasMap): Promise<void> => {
  const {map_latitude, map_longitude, country, city} = map

  if (!map_longitude.length || !map_latitude.length) {
    const cords = cordinatesMexico[country];

    if (cords !== undefined) chargeMap(cords)
    else chargeMap({lat: 23.63, lng: -102.55})
  } else {
    chargeMap({lat: Number(map_latitude), lng: Number(map_longitude)})
    L.marker([Number(map_latitude), Number(map_longitude)]).addTo(mapLeaflet.value)
  }
});

// METODOS
const chargeMap = async (cords: Map_Cords) => {
  if (mapLeaflet.value) mapLeaflet.value.remove()

  const {lat, lng} = cords

  mapLeaflet.value = L.map('mapContainer').setView([lat, lng], 8)
  await setInterval(() => {
    mapLeaflet.value.invalidateSize()
  }, 2000)
  L.tileLayer("http://{s}.tile.osm.org/{z}/{x}/{y}.png", {
    attribution:
    '&copy; <a href="https://github.com/hakynseyer", target="_blank">Joaquin Reyes Sanchez</a> desarrollador',
  }).addTo(mapLeaflet.value)

  mapLeaflet.value.on('click', mapClick);
}

const mapClick = async (e) => {
  if (addMarker.value) {
    const cords = e.latlng

    const res = await TableModal.value.modifyMap(cords.lat, cords.lng)

    if (res) {
      addMarker.value = false
      L.marker([cords.lat, cords.lng]).addTo(mapLeaflet.value)
    }
  }
}
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
          button(@click="addMarker = !addMarker", type="button") {{TableModal.button}}
        .extras__table__modal__map--add-marker(v-show="addMarker") Haz click en cualquier zona del mapa para agregar un marcador
        .extras__table__modal__map(id="mapContainer")
  .extras__actions
    h2 {{Extras.titleForm}}
    Form
</template>

<style lang="sass" scoped>
@import './extras.sass'
</style>
