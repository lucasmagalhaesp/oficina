<template>
    <q-banner dense class="bg-blue-grey-1 q-mb-md titulo-pagina">
        <h1 class="text-bold">{{ titulo }}</h1>
    </q-banner>
</template>
<script>
import { defineComponent } from 'vue'

export default defineComponent({
    props: ["titulo"]
})
</script>

<style scoped>
    .q-banner{
        border-bottom: solid 1px #52B240
    }
    .titulo-pagina{
        padding: 3px 0
    }
    .titulo-pagina >>> h1{
        font-size: 20px;
        line-height: 0;
        text-align: center;
    }
</style>