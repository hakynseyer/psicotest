<script lang="ts" setup>
// [ ESCENCIALES ]
import { ref, onMounted, onBeforeUnmount } from "vue";
import { EM } from "@Assets/ts/mitt";

// [ COMPONENTS ]
import Table from "@Components/table/table.vue";
import Form from "./components/form.vue";

// [ TS ]
import { RanksClass } from "./ranks";
import { TableClass } from "./ts/table";

// [ REF ]
const Ranks = ref<RanksClass>(new RanksClass());
const TableRanks = ref<TableClass>(new TableClass());

// [ HOOKS ]
onMounted(async () => {
  await TableRanks.value.listRanks();
});

onBeforeUnmount(async () => {
  EM.all.clear()
})

// [ EVENTBUS ]
EM.emit("APP_h1", "Rangos");
EM.on("VIEW_RANKS_titleForm", (title: string): void => {
  Ranks.value.titleForm = title;
});
EM.on("VIEW_RANKS_updateTable", async (): Promise<void> => {
  await TableRanks.value.listRanks();
});
</script>

<template lang="pug">
.ranks
  .ranks__table
    Table(
      :header="TableRanks.headers",
      :data="TableRanks.ranks",
      :deleteIcon="true",
      @activeDelete="TableRanks.deleteRankSelected($event)",
      @itemSelected="TableRanks.saveRankSelected($event)",
      @searchData="TableRanks.searchRank($event)"
    )
  .ranks__actions
    h2 {{ Ranks.titleForm }}
    Form
</template>

<style lang="sass" scoped>
@import "./ranks.sass"
</style>
