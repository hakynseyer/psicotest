<script lang="ts" setup>
// [ ESCENCIALES ]
import { ref, computed } from "vue";
import type { ComputedRef } from "vue";
import * as Interfaces from "@TS/interfaces";

// [ PROPS ]
interface Props {
  label?: string;
  error?: string;
  options?: Array<Interfaces.TypeRadioOptions<any>> 
  modelValue?;
}

const props: Props = withDefaults(defineProps<Props>(), {
  label: "",
  error: "",
});

// [ EMITS ]
const emit = defineEmits(["update:modelValue"]);

// [METODOS]
const radioSelected = item => {
  if (item.value !== props.modelValue)
    emit('update:modelValue', item.value)  
}
</script>

<template lang="pug">
.input
  label {{label}}

  .input__radio
    .input__radio__item(
      @click="radioSelected(item)"
      v-for="(item, index) in options")
      .input__radio__item__square(:class="{'input__radio__item__square--selected': modelValue === item.value}")
      .input__radio__item__label {{item.label}}
  
  span {{error}}
</template>

<style lang="sass" scoped>
@import "@Assets/sass/form.sass", "./radio.sass"
</style>
