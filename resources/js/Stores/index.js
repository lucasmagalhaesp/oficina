import { createStore } from "vuex"
export default createStore({
    state: {
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