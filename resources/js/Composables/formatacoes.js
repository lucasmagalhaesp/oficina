const ignorarValidacaoDatas = ['', null, "0000-00-00", "0000-00-00 00:00:00", "2000-01-01", "2000-01-01 00:00:00"];

export function formataDataBR(data){
    return ignorarValidacaoDatas.includes(data) ? "" : new Date(data+"T00:00:00.0").toLocaleDateString("pt-BR")
}

export function formataDataTimeBR(data){
    return ignorarValidacaoDatas.includes(data) ?  "" : new Date(data.replace("-", ",")).toLocaleDateString("pt-BR", {hour:  "2-digit", minute: "2-digit", second: "2-digit"})
}

export function formataMoedaReal(valor) {
    if (valor == undefined || valor == null) valor = 0;
    return valor.toLocaleString("pt-BR", { style: "currency", currency: "BRL" })
}