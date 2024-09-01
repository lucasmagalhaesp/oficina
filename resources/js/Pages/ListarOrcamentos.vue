<template>
    <div class="row q-ma-md">
        <div class="col-12 text-right q-gutter-sm">
            <q-btn color="primary" push label="Novo orçamento" icon="fas fa-plus" @click="novoOrcamento" />
            <q-btn color="info" push label="Filtros" icon="fas fa-filter" @click="$refs.filtrosOrc.$refs.filtrosOrcamentos.show()" />
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
export default {
    components:{
        TabelaOrcamentos,
        Filtros
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