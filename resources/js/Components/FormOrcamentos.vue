<template>
    <q-form class="row q-col-gutter-md">
        <div class="col-12 col-md-4">
            <q-input :dense="!$q.screen.lt.sm" v-model="dados.data_hora_criacao" color="green-7" filled outlined label="Data/Hora Criação:" type="datetime-local" clearable />
        </div>
        <div class="col-12 col-md-8">
            <q-input ref="cliente" :dense="!$q.screen.lt.sm" v-model="dados.cliente" color="green-7" filled outlined label="Cliente:" clearable />
        </div>
        <div class="col-12 col-md-8">
            <q-input :dense="!$q.screen.lt.sm" v-model="dados.vendedor" color="green-7" filled outlined label="Vendedor:" clearable />
        </div>
        <div class="col-12 col-md-4">
            <q-input :dense="!$q.screen.lt.sm" v-model="dados.valor" color="green-7" filled outlined label="Valor:" mask="#,##" reverse-fill-mask prefix="R$" clearable />
        </div>
        <div class="col-12 col-md-12">
            <q-input :dense="!$q.screen.lt.sm" v-model="dados.descricao" color="green-7" filled outlined label="Descrição:" type="textarea" clearable />
        </div>
    </q-form>
    <div class="row q-mt-md q-gutter-sm justify-center">
        <q-btn :class="$q.screen.lt.sm ? 'full-width btn-lg' : ''" label="Salvar" icon="fas fa-save" color="positive" push @click="salvar" />
        <q-btn :class="$q.screen.lt.sm ? 'full-width btn-lg' : ''" label="Cancelar" icon="fas fa-ban" color="negative" @click="cancelar" push />
    </div>
</template>

<script>
import { date } from "quasar"
import { router } from "@inertiajs/vue3"
export default {
    async created(){
        const timeStamp = Date.now();
        this.dados.data_hora_criacao = date.formatDate(timeStamp, "YYYY-MM-DD HH:mm");

        if (![null, undefined, 0, ""].includes(this.dados.id)) {
            this.$q.loading.show({ message: "Buscando dados..." });
            axios(`/orcamentos/${this.dados.id}/edit`)
            .then(resposta => {
                this.$store.commit("setDadosOrcamento", resposta.data);
                this.$q.loading.hide();
            })
            .catch(() => this.$q.loading.hide());
        }
    },
    mounted(){
        this.$refs.cliente.focus();
    },
    computed:{
        dados(){
            return this.$store.state.dadosCadastro
        }
    },
    methods:{
        salvar(){
            this.$q.loading.show({ message: "Salvando orçamento..." });
            axios.post(`/orcamentos`, { dados: this.dados })
            .then(resposta => {
                this.$q.dialog({
                    title: "Confirmação",
                    message: `Orçamento ${[null, undefined, , ""].includes(this.dados.id) ? 'cadastrado' : 'atualizado'} com sucesso`,
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
            this.$store.commit("limparCadastro");
        }
    }
}
</script>

<style scoped>
    .q-btn-item >>> .q-icon{
        font-size: inherit
    }
</style>