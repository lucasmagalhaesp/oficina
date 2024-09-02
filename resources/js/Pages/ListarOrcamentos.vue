<template>
    <div class="row">
        <div class="col-12">
            <TituloPagina titulo="Listagem de Orçamentos" />
        </div>
    </div>
    <div class="row q-ma-md">
        <div class="col-12 text-right q-gutter-sm">
            <q-btn color="blue-grey-4" push label="Novo orçamento" icon="fas fa-plus" @click="novoOrcamento" :class="$q.screen.lt.sm ? 'full-width' : ''" />
            <q-btn color="blue-grey-2" text-color="dark" push label="Filtros" icon="fas fa-filter" @click="$refs.filtrosOrc.$refs.filtrosOrcamentos.show()" :class="$q.screen.lt.sm ? 'full-width' : ''" />
        </div>
    </div>
    <div class="row q-ma-md">
        <div class="col-12">
            <TabelaOrcamentos :atualizar-dados="atualizarDados" />
        </div>
    </div>
    <Filtros ref="filtrosOrc" @atualizar-dados="atualizarDados = !atualizarDados" />
</template>

<script>
import { router } from "@inertiajs/vue3"
import TabelaOrcamentos from '../Components/TabelaOrcamentos.vue'
import Filtros from "../Components/FiltrosOrcamentos.vue"
import TituloPagina from "../Layouts/TituloPagina.vue"
export default {
    components:{
        TabelaOrcamentos,
        Filtros,
        TituloPagina
    },
    data(){
        return{
            atualizarDados: false
        }
    },
    methods:{
        novoOrcamento(){
            router.visit("/orcamentos/criar");
        }
    }
}
</script>

<style scoped>
    .q-btn-item >>> .q-icon{
        font-size: inherit
    }
</style>