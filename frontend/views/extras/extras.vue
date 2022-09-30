<script lang="ts" setup>
// [ESCENCIALES]
import {ref, onMounted, onBeforeUnmount} from 'vue'
import {EM} from '@Assets/ts/mitt'

import * as Interfaces from "@TS/interfaces";

/* import "leaflet/dist/leaflet.css" */ // ESTE SE CARGARÁ DESDE EL ARCHIVO main.html
import L from 'leaflet'

// TODO: No logro hacer que se renderice un marcador personalizado
const customMarker = L.icon({
    iconUrl: require('@Assets/images/marker-icon.png'),
    /* shadowUrl: require('@Assets/images/marker-shadow.png'), */
    iconAnchor: null,
    popupAnchor: null,
    shadowUrl: null,
    shadowSize: null,
    shadowAnchor: null,
    iconSize: new L.Point(60, 75),
    className: 'leaflet-div-icon'
    /* iconSize:     [38, 95], // size of the icon */
    /* shadowSize:   [50, 64], // size of the shadow */
    /* iconAnchor:   [22, 94], // point of the icon which will correspond to marker's location */
    /* shadowAnchor: [4, 62],  // the same for the shadow */
    /* popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor */
})

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

  mapLeaflet.value = L.map('mapContainer').setView([lat, lng], 10)
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

      mapLeaflet.value.eachLayer(layer => {
        if (layer['_latlng'] !== undefined) layer.remove() 
      })

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
