<script lang="ts" setup>
// [ESCENCIALES]
import {ref, onMounted, onBeforeUnmount} from 'vue'
import {EM} from '@Assets/ts/mitt'
import * as Interfaces from '@TS/interfaces'

// [COMPONENTES]
import Input from '@Components/input/input.vue'
import Select from '@Components/select/select.vue'
import Radio from '@Components/radio/radio.vue'
import Task from '@Components/task/task.vue'

// [TS]
import {FormClass} from './form'

// [REF]
const Form = ref<FormClass>(new FormClass())

// [HOOKS]
onMounted(async() => {
  await Form.value.getUserList()

  Form.value.getCountryList()
})

onBeforeUnmount(async () => {
  EM.all.clear()
})

// [EVENTBUS]
EM.on("VIEW_EXTRAS_FORM_extrasSelected", (extras: Interfaces.TypeExtras): void => {
  Form.value.extrasSelected = extras

  Form.value.gender = extras.gender
  Form.value.country = extras.country
  Form.value.city = extras.city
  Form.value.address = extras.address
  Form.value.phone = JSON.parse(JSON.parse(JSON.stringify(extras.phone))) as Array<Interfaces.TypeTask>
  Form.value.user = extras.user
})

EM.on("VIEW_EXTRAS_FORM_deleteExtras", (extras: Interfaces.TypeExtras): void => {
  Form.value.deleteExtras(extras)
})
</script>

<template lang="pug">
.form
  .form__controls
    .form__controls--new(@click="Form.clearData()", v-show="Form.extrasSelected")
      i.material-icons add
      span Nuevo Extras

  Select(
    :options="Form.userList",
    :initOption="{ label: 'Usuario', value: 0 }",
    label="Usuario",
    :error="Form.userError",
    v-model="Form.user"
  )

  Radio(
    label="Genero",
    :error="Form.genderError",
    :options="Form.radioOptions",
    v-model="Form.gender"
  )

  Select(
    :options="Form.countryList",
    :initOption="{ label: 'Estado', value: '' }",
    label="Estado",
    :error="Form.countryError",
    v-model="Form.country"
  )

  Select(
    :options="Form.cityList",
    :initOption="{ label: 'Municipio', value: '' }",
    label="Municipio",
    :error="Form.cityError",
    v-model="Form.city"
  )

  Input(label="Dirección", typeInput="textarea", :error="Form.addressError", v-model="Form.address")

  button(type="button" @click="Form.clearData()") Borrar

  Task(
    label="Telefonos",
    placeholder="555...",
    title="Celular",
    :error="Form.phoneError",
    v-model="Form.phone"
  )

  button.form__sendButton(
    type="button",
    @click="Form.sendForm()",
    :disabled="Form.enableSend"
  ) {{Form.titleSend}}
</template>

<style lang="sass" scoped>
@import '@Assets/sass/form.sass'
</style>
