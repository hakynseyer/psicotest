<script lang="ts" setup>
// [ESCENCIALES]
import {ref, onMounted} from 'vue' 
import {EM} from '@Assets/ts/mitt'

// [COMPONENTES]
import Table from '@Components/table/table.vue'
import Form from './components/form.vue'

// [TS]
import {UsersClass} from './users'
import {TableClass} from './ts/table'

// [REF]
const Users = ref<UsersClass>(new UsersClass())
const TableUsers = ref<TableClass>(new TableClass())

// [HOOKS]
onMounted(async() => {
  await TableUsers.value.listUsers()
})

// [EVENTBUS]
EM.emit('APP_h1', "Usuarios")

EM.on("VIEW_USERS_titleForm", (title: string): void => {
  Users.value.titleForm = title;
});
EM.on("VIEW_USERS_updateTable", async (): Promise<void> => {
  await TableUsers.value.listUsers();
});
</script>

<template lang="pug">
.users
  .users__table
    Table(
      :header="TableUsers.headers",
      :data="TableUsers.users",
      :deleteIcon="true",
      @activeDelete="TableUsers.deleteUserSelected($event)",
      @itemSelected="TableUsers.saveUserSelected($event)",
      @searchData="TableUsers.searchUser($event)"
    )
  .users__actions
    h2 {{Users.titleForm}}
    Form
</template>

<style lang="sass" scoped>
@import "./users.sass"
</style>
