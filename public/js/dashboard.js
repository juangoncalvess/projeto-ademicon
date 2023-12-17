$(document).ready(async function(){  
    //headers: {"Authorization": `Bearer ${token_api}`},

    $(".loading").show();
    await $.ajax({
        url: `${urlApi}api/resumo-das-vendas`, type: 'get', dataType: 'json',
        success: function (data) {
            if(`${data}` != ""){
                let x = 0;
                for(let i of data){ 
                    let listra_branca = x % 2 == 0 ? "listra-branca" : "";
                    $(".registro-tbody").append(`
                        <tr class="${listra_branca} linha-${i.id}">
                            <td>${data_nascimentoBR(i.data_da_venda)}</td>  
                            <td>${i.cliente_nome}</td>
                            <td class="display-none-1200">${i.vendedor_nome}</td>
                            <td class="wid-resumo-itens-vendidos text-center display-none-1300">${i.quantidade_de_itens}</td>
                            <td class="wid-resumo-valor-da-venda text-center">R$ ${moedaBR(i.valor_total)}</td>
                        </tr>
                    `);
                    x++;
                }
            }
            $(".loading").hide();
        }, 
        error: function (data) {
            console.log(data); 
            $(".loading").hide();
        } 
    });
 
    let mensuracao_mensal_ativa = $(".mensuracao-mensal-ativa").attr('id');
    mensuracao_mensal(mensuracao_mensal_ativa);

    $(document).on("click", ".mensuracao-mensal", async function(){
        $(".loading").show();
        $(".mensuracao-mensal").removeClass("mensuracao-mensal-ativa");
        $(this).addClass("mensuracao-mensal-ativa");
        let data_selecionada = $(this).attr('id');
        mensuracao_mensal(data_selecionada);
    }); 
 
    async function mensuracao_mensal(data_selecionada){
        await $.ajax({
            url: `${urlApi}api/mensuracao-mensal/${data_selecionada}`, type: 'get', dataType: 'json',
            success: function (data) {                
                if(`${data}` != ""){
                    let quantidade_formas_pagamento = "";
                    let tipos_formas_pagamento = "";
                    let quantidade_formas_pagamento_tbody = "";
                    let tipos_formas_pagamento_tbody = "";
                    for(let i of data.formas_de_pagamento){ 
                        quantidade_formas_pagamento = quantidade_formas_pagamento.concat(`<td class="text-center">Quantidade de vendas no ${i.formas_de_pagamento_tipo}</td>`);
                        tipos_formas_pagamento = tipos_formas_pagamento.concat(`<td class="text-center">Valor de vendas no ${i.formas_de_pagamento_tipo}</td>`);
                        quantidade_formas_pagamento_tbody = quantidade_formas_pagamento_tbody.concat(`<td class="text-center">${i.quantidade_por_formas_de_pagamento}</td>`);
                        tipos_formas_pagamento_tbody = tipos_formas_pagamento_tbody.concat(`<td class="text-center">R$ ${moedaBR(i.valor_total_por_formas_de_pagamento)}</td>`);
                    }
                    $(".container-tabela-mensuracao-mensal").html(`
                        <table class="container-principal-div-table">
                            <thead>
                                <tr>
                                    ${quantidade_formas_pagamento}
                                    ${tipos_formas_pagamento}
                                    <td class="text-center">Quantidade total de vendas</td>
                                    <td class="text-center">Valor total de vendas</td>
                                </tr>
                            </thead>
                            <tbody>
                            <tr>
                                ${quantidade_formas_pagamento_tbody}
                                ${tipos_formas_pagamento_tbody}
                                <td class="text-center">${data.quantidade_total_de_todas_as_vendas}</td>
                                <td class="text-center">R$ ${moedaBR(data.valor_total_de_todas_as_vendas)}</td>
                            </tr>
                            </tbody> 
                        </table>
                    `);
                }
                $(".loading").hide();
            }, 
            error: function (data) {
                console.log(data); 
                $(".loading").hide();
            } 
        });
    }

}); 