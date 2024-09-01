<template>
    <q-form class="row q-col-gutter-md">
        <div class="col-12 col-md-6">
            <q-input :dense="!$q.screen.lt.sm" v-model="dados.cliente" color="dark" filled outlined label="Cliente:" clearable />
        </div>
        <div class="col-12 col-md-5">
            <q-input :dense="!$q.screen.lt.sm" v-model="dados.vendedor" color="dark" filled outlined label="Vendedor:" clearable />
        </div>
        <div class="col-12 col-md-5">
            <q-input :dense="!$q.screen.lt.sm" v-model="dados.descricao" color="dark" filled outlined label="Descrição:" type="textarea" clearable />
        </div>
        <div class="col-12 col-md-2">
            <q-input :dense="!$q.screen.lt.sm" v-model="dados.valor" color="dark" filled outlined label="Valor:" mask="#,##" reverse-fill-mask prefix="R$" clearable />
        </div>
        <div class="col-12 col-md-3">
            <q-input :dense="!$q.screen.lt.sm" v-model="dados.data_hora_criacao" color="dark" filled outlined label="Data/Hora Criação:" type="datetime-local" clearable />
        </div>
    </q-form>
    <div class="row q-mt-md q-gutter-sm justify-center">
        <q-btn :class="$q.screen.lt.sm ? 'full-width btn-lg' : ''" label="Salvar" icon="fas fa-save" color="positive" push @click="salvar" />
        <q-btn :class="$q.screen.lt.sm ? 'full-width btn-lg' : ''" label="Cancelar" icon="fas fa-ban" color="negative" @click="cancelar" push />
    </div>
</template>

<script>
import { router } from "@inertiajs/vue3"
export default {
    data(){
        return {
            dados:{
                id: "",
                cliente: "",
                vendedor: "",
                valor: "",
                descricao: "",
                data_hora_criacao: ""
            }
        }
    },
    async created(){
        if (![null, undefined, 0].includes(this.dados.codigo)) {
            this.$q.loading.show({ message: "Buscando dados..." });
            this.$store.dispatch("entidades/getEntidade", { empresa: this.empresa })
            .then(() => this.$q.loading.hide())
            .catch(() => this.$q.loading.hide());
        }
    },
    computed:{
        /* dados(){
            return this.$store.state.entidades.dadosCadastro
        } */
    },
    methods:{
        salvar(){
            this.$q.loading.show({ message: "Salvando orçamento..." });
            axios.post(`/orcamentos`, { dados: this.dados })
            .then(resposta => {
                let dadosResposta = resposta.data;
                this.$q.dialog({
                    title: "Confirmação",
                    message: "Orçamento cadastrado com sucesso",
                    html: true,
                    class: "bg-positive text-white",
                    persistent: true,
                    ok: {
                        push: true,
                        color: "white",
                        textColor: "positive"
                    },
                }).onOk(() => router.visit("/orcamentos/listagem"));
                this.limparCampos();
            })
            .catch(error => {
                console.log(error.response.data.errors);
                let msg = "";
                if (error.response.data.errors){
                    let erros = error.response.data.errors;
                    msg += "<ul class='q-mx-md'>";
                        for (let err in erros){
                            msg += `<li>${erros[err]}</li>`;
                        }
                    msg += "</ul>";
                }

                this.$q.dialog({
                    title: "Erro",
                    message: msg || "Erro ao cadastrar orçamento",
                    html: true,
                    class: "bg-negative text-white",
                    ok: {
                        push: true,
                        color: "white",
                        textColor: "negative"
                    },
                });
            })
            .then(() => this.$q.loading.hide());
        },
        cancelar(){
            this.limparCampos();
            router.visit("/orcamentos/listagem")
        },
        limparCampos(){
            for(let campo in this.dados){
                this.dados[campo] = "";
            }
        }
    }
}
</script>

<style scoped>
    .q-btn-item >>> .q-icon{
        font-size: inherit
    }
</style>