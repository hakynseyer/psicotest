<script lang="ts" setup>
// [ ESCENCIALES ]
import { ref, computed } from "vue";
import type { ComputedRef } from "vue";
import * as Interfaces from "@TS/interfaces";

// [ PROPS ]
interface Props {
  label?: string;
  error?: string;
  title?: string;
  placeholder?: string;
  modelValue?;
}

const props: Props = withDefaults(defineProps<Props>(), {
  label: "",
  error: "",
  placeholder: "",
  title:"task"
});

// [REF]
const currentTask = ref<string>("")
const currentTaskTitle=ref<string>("")
const tasks = ref<Array<Interfaces.TypeTask>>([])

// [ EMITS ]
const emit = defineEmits(["update:modelValue"]);

// [ COMPUTED ]
const theTasks: ComputedRef = computed<Array<Interfaces.TypeTask>>((): Array<Interfaces.TypeTask> => {
  if (props.modelValue.length) tasks.value = props.modelValue

  return tasks.value;
});

// [METODOS]
const addToTasks = () => {
  tasks.value.push({title:props.title, value:currentTask.value})

  currentTask.value = ""

  emit('update:modelValue', tasks.value)  
}

const removeToTasks = (task, index) => {
  tasks.value.splice(index, 1)

  /* tasks.value = tasks.value.filter(t => { */
  /*   return t.value !== task.value */
  /* }) */
  
  emit('update:modelValue', tasks.value)  
}

</script>

<template lang="pug">
.input
  label {{label}}

  .input__write(:id="'select_' + label")
    input.input__write__input(type="text", v-model="currentTask", :placeholder="placeholder")
    button.input__write__button(@click="addToTasks", type="button") Añadir
  .input__info
    .input__info__item(v-for="(task, index) in theTasks", :key="index")
      .input__info__item__label {{task.title}}
      .input__info__item__value {{task.value}}
      i.input__info__item__close.material-icons(@click="removeToTasks(task, index)") disabled_by_default

  span {{error}}
</template>

<style lang="sass" scoped>
@import "@Assets/sass/form.sass", "./task.sass"
</style>
