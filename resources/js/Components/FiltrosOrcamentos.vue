<template>
    <q-dialog ref="filtrosOrcamentos">
        <q-card class="bg-grey-4" style="width: 800px; max-width: 80vw">
            <q-card-section class="row bg-cor-padrao2 text-white">
                <div class="text-h6 q-py-sm q-mx-md">Filtrar</div>
                <q-space />
                <q-btn icon="close" flat dense v-close-popup />
            </q-card-section>
            <q-card-section class="q-my-sm q-mx-sm">
                <div class="row q-mb-md q-mt-xs q-col-gutter-md">
                    <div class="col-12 col-md-6">
                        <q-input :dense="!$q.screen.lt.sm" v-model="filtros.dataCriacao.dataInicial" color="green-7" filled outlined label="Data de Criação (Inicial):" type="date" clearable />
                    </div>
                    <div class="col-12 col-md-6">
                        <q-input :dense="!$q.screen.lt.sm" v-model="filtros.dataCriacao.dataFinal" color="green-7" filled outlined label="Data de Criação (Final):" type="date" clearable />
                    </div>
                    <div class="col-12 col-md-6">
                        <q-input :dense="!$q.screen.lt.sm" v-model="filtros.cliente" color="green-7" filled outlined label="Cliente:" clearable hint="Você pode digitar parte do nome para pesquisar" />
                    </div>
                    <div class="col-12 col-md-6">
                        <q-input :dense="!$q.screen.lt.sm" v-model="filtros.vendedor" color="green-7" filled outlined label="Vendedor:" clearable placeholder="" hint="Você pode digitar parte do nome para pesquisar" />
                    </div>
                </div>
            </q-card-section>
            <q-card-actions class="bg-cor-padrao2 justify-end">
                <q-btn label="Filtrar" icon="fas fa-filter" color="positive" push @click="filtrar" v-close-popup />
                <q-btn label="Limpar" icon="fas fa-eraser" color="warning" text-color="dark" push @click="limparFiltros" v-close-popup />
                <q-btn label="Fechar" icon="fas fa-window-close" flat push text-color="white" v-close-popup />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script>
export default {
    data(){
        return {
            
        }
    },
    computed:{
        filtros(){
            return this.$store.state.filtros
        }
    },
    methods:{
        filtrar(){
            this.$emit("atualizarDados");
        },
        limparFiltros(){
            this.$store.commit("limparFiltros");
            this.$emit("atualizarDados");
        }
    }
}
</script>

<style scoped>
    .q-card >>> .q-card__section--vert{
        padding: 0 5px
    }
    .q-btn-item >>> .q-icon{
        font-size: inherit
    }
</style>