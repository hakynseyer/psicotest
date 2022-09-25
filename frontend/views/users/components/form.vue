<script lang="ts" setup>
// [ESCENCIALES]
import {ref, onMounted} from 'vue'
import {EM} from '@Assets/ts/mitt'
import * as Interfaces from '@TS/interfaces'

// [COMPONENTES]
import Input from '@Components/input/input.vue'
import Select from '@Components/select/select.vue'

// [TS]
import {FormClass} from './form'

// [REF]
const form = ref<FormClass>(new FormClass())

// [HOOKS]
onMounted(async() => {
  await form.value.getRankList()
})

// [EVENTBUS]
EM.on("VIEW_USERS_FORM_userSelected", (user: Interfaces.TypeUser): void => {
  form.value.userSelected = user

  form.value.name = user.name
  form.value.surname_first = user.surname_first
  form.value.surname_second = user.surname_second
  form.value.password = user.password
  form.value.notes = user.notes
  form.value.rank = user.rank
})

EM.on("VIEW_USERS_FORM_deleteUser", (user: Interfaces.TypeUser): void => {
  form.value.deleteUser(user)
})
</script>

<template lang="pug">
.form
  .form__controls
    .form__controls--new(@click="form.clearData()", v-show="form.userSelected")
      i.material-icons add
      span Nuevo Usuario

  Input(label="Nombre", :error="form.nameError", v-model="form.name")

  Input(label="Apellido Paterno", :error="form.surname_firstError", v-model="form.surname_first")
  
  Input(label="Apellido Materno", :error="form.surname_secondError", v-model="form.surname_second")
  
  Input(label="Contraseña", typeInput="password", :error="form.passwordError", v-model="form.password")

  Input(label="Notas", typeInput="textarea", :error="form.notesError", v-model="form.notes")

  Select(
    :options="form.rankList",
    :initOption="{ label: 'Rango', value: 0 }",
    label="Rango",
    :error="form.rankError",
    v-model="form.rank"
  )

  button.form__sendButton(
    type="button",
    @click="form.sendForm()",
    :disabled="form.enableSend"
  ) {{form.titleSend}}
</template>

<style lang="sass" scoped>
@import "@Assets/sass/form.sass"
</style>
