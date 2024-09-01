<template>
    <div class="row">
        <div class="col-12">
            <q-table
                ref="orcamentos"
                :style="[!$q.screen.lt.sm ? 'max-height:450px' : 'background-color: #f5f5f5', orcamentos.length == 0 && !$q.screen.lt.sm ? 'height: 350px' : '' ]"
                class="table-documentos q-mb-lg"
                :card-class="$q.screen.lt.sm ? '' : 'bg-blue-grey-1'"
                table-header-class="bg-blue-grey-2"
                :rows="orcamentos"
                :columns="colunas"
                :rows-per-page-options="[$q.screen.lt.sm ? 5 : 20]"
                :hide-header="$q.screen.lt.sm"
                separator="cell"
                wrap-cells
                dense
                :loading="carregando"
                v-model:pagination="paginacao"
                @request="getDados"
                no-data-label="Nenhum registro encontrado"
            >
                <template v-slot:loading>
                    <q-inner-loading showing color="primary" />
                </template>

                <template v-slot:body="props" v-if="!$q.screen.lt.sm">
                    <q-tr :props="props">
                        <q-td key="edtExc" :props="props">
                            <q-btn-group>
                                <q-btn color="primary" title="Editar" @click="editar(props.row.id)"><i class="fas fa-edit"></i></q-btn>
                                <q-btn color="negative" title="Excluir" @click="excluir(props.row.id)"><i class="fas fa-trash-alt"></i></q-btn>
                            </q-btn-group>
                        </q-td>
                        <q-td key="id" :props="props">{{ props.row.id }}</q-td>
                        <q-td key="cliente" :props="props">{{ props.row.cliente }}</q-td>
                        <q-td key="vendedor" :props="props">{{ props.row.vendedor }}</q-td>
                        <q-td key="descricao" :props="props">{{ props.row.descricao }}</q-td>
                        <q-td key="valor" :props="props">{{ formataValor(props.row.valor) }}</q-td>
                        <q-td key="data_hora_criacao" :props="props">{{ formataData(props.row.data_hora_criacao) }}</q-td>
                    </q-tr>
                </template>

                <!-- <template v-slot:body="props" v-else>
                    <q-card class="col-12 bg-blue-grey-1" :class="$q.screen.lt.sm ? '' : 'q-mt-md'">
                        <q-card-section class="bg-blue-grey-2 text-dark">
                            <div class="text-h6 text-bold">Código: {{ props.row.codigo }}</div>
                        </q-card-section>
                        <q-card-section class="q-mb-md dados-mobile">
                            <div class="row">
                                <div class="col-6">
                                    <strong>Nome:</strong> 
                                </div>
                                <div class="col-6">
                                    {{ props.row.nome }}
                                </div>
                            </div>
                            <q-separator />
                            <div class="row">
                                <div class="col-6">
                                    <strong>Tipo de Entidade:</strong> 
                                </div>
                                <div class="col-6">
                                    {{ getDescEntidade(props.row.entidade_tipo) }}
                                </div>
                            </div>
                            <q-separator />
                            <div class="row">
                                <div class="col-6">
                                    <strong>Físico/Jurídico:</strong> 
                                </div>
                                <div class="col-6">
                                    {{ props.row.fisicojuridico == "J" ? "Jurídico" : "Físico" }}
                                </div>
                            </div>
                            <q-separator />
                            <div class="row">
                                <div class="col-6">
                                    <strong>Nome Fantasia:</strong> 
                                </div>
                                <div class="col-6">
                                    {{ props.row.nomefantasia }}
                                </div>
                            </div>
                            <q-separator />
                            <div class="row">
                                <div class="col-6">
                                    <strong>Data de Nasc.:</strong> 
                                </div>
                                <div class="col-6">
                                    {{ formataData(props.row.dt_nasc) }}
                                </div>
                            </div>
                            <q-separator />
                            <div class="row">
                                <div class="col-6">
                                    <strong>CPF/CNPJ:</strong> 
                                </div>
                                <div class="col-6">
                                    {{ formataDocs(props.row.cgc_cpf) }}
                                </div>
                            </div>
                            <q-separator />
                            <div class="row">
                                <div class="col-6">
                                    <strong>RG:</strong> 
                                </div>
                                <div class="col-6">
                                    {{ props.row.insc_rg }}
                                </div>
                            </div>
                            <q-separator />
                            <div class="row">
                                <div class="col-6">
                                    <strong>Endereço:</strong> 
                                </div>
                                <div class="col-6">
                                    {{ formatarEndereco(props.row) }}
                                </div>
                            </div>
                            <q-separator />
                            <div class="row">
                                <div class="col-6">
                                    <strong>Telefone:</strong> 
                                </div>
                                <div class="col-6">
                                    {{ [undefined, null, ""].includes(props.row.tel1) ? "" :formataTel(props.row.tel1) }}
                                </div>
                            </div>
                            <q-separator />
                            <div class="row q-mt-md q-col-gutter-sm">
                                <div class="col-12">
                                    <q-btn color="primary" class="full-width" icon="fas fa-edit" label="Editar" @click="editar(props.row.codigo)" push></q-btn>
                                </div>
                                <div class="col-12">
                                    <q-btn color="negative" class="full-width" icon="fas fa-trash" label="Excluir" @click="excluir(props.row.codigo)" push></q-btn>
                                </div>
                            </div>
                        </q-card-section>
                    </q-card>
                </template> -->
            </q-table>
        </div>
    </div>
</template>

<script>
import { usePage, router } from "@inertiajs/vue3"
import { formataDataTimeBR, formataMoedaReal } from "../Composables/formatacoes.js"
import { date } from "quasar"
export default {
    props: ["atualizarDados"],
    data(){
        return {
            formataData: null,
            formataValor: null,
            dateQ: null,
            paginacao: {
                page: 1,
                rowsPerPage: this.$q.screen.lt.sm ? 5 : 20,
                rowsNumber: 0
            },
            carregando: false,
            orcamentos: []
        }
    },
    async created(){
        this.formataData = formataDataTimeBR;
        this.formataValor = formataMoedaReal;
        this.dateQ = date.formatDate;
        this.getDados({ pagination: this.paginacao });
    },
    computed:{
        filtros(){
            return this.$store.state.filtros
        },
        colunas(){
            return [
                { name: "edtExc", label: "" },
                { name: "id", align: "center", label: "Código", field: "id" },
                { name: "cliente", align: "center", label: "Cliente", field: "cliente" },
                { name: "vendedor", align: "center", label: "Vendedor", field: "vendedor" },
                { name: "descricao", align: "center", label: "Descrição", field: "descricao" },
                { name: "valor", align: "center", label: "Valor", field: "valor" },
                { name: "data_hora_criacao", align: "center", label: "Data/Hora da criação", field: "data_hora_criacao" },
            ]
        },
    },
    methods:{
        getDados(dadosPg){
            this.carregando = true;
            axios.post(`/orcamentos/getDadosFiltrados`, { filtros: this.filtros })
            .then(resposta => {
                this.orcamentos = resposta.data;
            })
            .catch(error => {
                this.$q.dialog({
                    title: "Erro",
                    message: "Erro ao buscar os dados dos orçamentos",
                    html: true,
                    class: "bg-negative text-white",
                    ok: {
                        push: true,
                        color: "white",
                        textColor: "negative"
                    },
                });
            })
            .then(() => this.carregando = false);
        },
        /* getTotalEntidades(dadosPg){
            const { page, rowsPerPage } = dadosPg.pagination;
            this.$store.dispatch("entidades/getTotalEntidades", { empresa: this.empresa })
            .then(totalEntidades => {
                this.paginacao.rowsNumber = totalEntidades;
                this.paginacao.page = page;
                this.paginacao.rowsPerPage = rowsPerPage;
            })
            .catch()
            .then();
        }, */
        editar(id){
            this.$store.commit("entidades/editarCadastro", id);
            router.get("entidades/cadastrar");
        },
        async excluir(id){
            this.$q.dialog({
                title: "Confirmação",
                message: "Confirma a exclusão desse orçamento?",
                html: true,
                class: "bg-negative text-white",
                ok: {
                    push: true,
                    color: "white",
                    textColor: "negative",
                    label: "SIM"
                },
                cancel: {
                    push: true,
                    color: "white",
                    textColor: "dark",
                    label: "NÃO"
                }
            })
            .onOk(() => {
                this.$q.loading.show({ message: "Excluindo orçamento" });
                this.$store.dispatch("entidades/excluir", { empresa: this.empresa, codigo: id })
                .then(() => this.$q.loading.hide())
                .then(() => this.getDados({ pagination: this.paginacao }));
            });
        },
        showFiltros(){
            this.$refs.filtrosEnt.$refs.filtrosEntidades.show();
        }
    },
    watch:{
        atualizarDados(){
            this.getDados({ pagination: this.paginacao })
        }
    }
}
</script>
<style scoped>
    .dados-mobile div{
        margin: 5px 0;
        font-size: 1em;
    }

    .q-card__section--vert{
        padding: 5px 16px;
    }

</style>