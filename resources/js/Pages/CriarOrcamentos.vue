<template>
    <div class="row">
        <div class="col-12">
            <TituloPagina :titulo="[null, undefined, 0, ''].includes($store.state.dadosCadastro.id) ? 'Novo Orçamento' : 'Atualizar Orçamento'" />
        </div>
    </div>
    <div class="row q-ma-md justify-center">
        <div class="col-12 col-md-6">
            <FormOrcamentos />
        </div>
    </div>
</template>

<script>
import FormOrcamentos from "../Components/FormOrcamentos.vue"
import TituloPagina from "../Layouts/TituloPagina.vue"
export default {
    components:{
        FormOrcamentos,
        TituloPagina
    }
}
</script>

<style>

</style>