import { createStore } from "vuex"
export default createStore({
    state: {
        dadosCadastro:{
            id: null,
            cliente: "",
            vendedor: "",
            valor: "",
            descricao: "",
            data_hora_criacao: ""
        },
        filtros:{
            cliente: "",
            vendedor: "",
            dataCriacao: {
                dataInicial: null,
                dataFinal: null,
            }
        }
    },
    getters:{
        
    },
    mutations:{
        editarOrcamento(state, id){
            state.dadosCadastro.id = id;
        },
        setDadosOrcamento(state, dados){
            state.dadosCadastro = { ...dados };
        },
        limparCadastro(state){
            state.dadosCadastro = {
                id: null,
                cliente: "",
                vendedor: "",
                valor: "",
                descricao: "",
                data_hora_criacao: null
            };
        },
        limparFiltros(state){
            state.filtros = {
                cliente: "",
                vendedor: "",
                dataCriacao: {
                    dataInicial: null,
                    dataFinal: null,
                }
            }
        }
    },
    actions:{
        
    }
})