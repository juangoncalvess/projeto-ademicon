$(document).ready(async function(){
    url_site = url_site.split("vendas/");
    url_site = url_site[1];
    url_site = url_site.split("/");
    console.log(url_site[0]);
  
    //headers: {"Authorization": `Bearer ${token_api}`},

    switch (url_site[0]) {
        case "listar":
            $(".loading").show();
            await $.ajax({
                url: `${urlApi}api/venda`, type: 'get', dataType: 'json',
                success: function (data) {
                    if(`${data}` != ""){
                        let x = 0;
                        for(let i of data){ 
                            let listra_branca = x % 2 == 0 ? "listra-branca" : "";
                            $(".container-principal-div-table tbody").append(`
                                <tr class="${listra_branca} linha-${i.id}">
                                    <td>${data_nascimentoBR(i.data_da_venda)}</td>  
                                    <td>${i.nome_cliente}</td>  
                                    <td class="display-none-990">${i.nome_vendedor}</td>  
                                    <td>R$ ${moedaBR(i.valor_total)}</td>
                                    <td class="wid-acao text-center display-none-990"> 
                                        <div class="botoes-de-acao">
                                            <a class="excluir-js" id="${i.id}" title="Excluir">
                                                <ion-icon name="close-circle-outline" role="img" class="md hydrated"></ion-icon>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            `);
                            x++; 
                        }
                        $(".loading").hide();
                    }
                }, 
                error: function (data) {
                    console.log(data); 
                    $(".loading").hide();
                } 
            });

            $(document).on("click", ".excluir-js", async function(){
                $(".loading").show();
                let id_venda = $(this).attr('id');
                if(confirm("Deseja excluir?")){
                    await $.ajax({  
                        url: `${urlApi}api/venda/${id_venda}`, type: 'delete', dataType: 'json',
                        success: function (data) {
                            $(`.linha-${id_venda}`).remove();
                            $(".loading").hide(); 
                        },  
                        error: function (request, status, error) {
                            console.log(request);
                            alert("Ops! Falha ao comunicar com o servidor, tente novamente.");
                            $(".loading").hide();
                        } 
                    })  
                }else{
                    $(".loading").hide();
                }
            });
        break;    
        default:
            $(document).on("click", ".button-form", async function(){
                $(".loading").show();
                let ajax_type = [];
                let ajax_url = [];
                let acao = $(this).attr('id');
                let id_cliente = $(".input-id_cliente").val();
                let id_vendedor = $(".input-id_vendedor").val();
                let id_forma_de_pagamento = $(".input-id_forma_de_pagamento").val();
                let data_da_venda = $(".input-data_da_venda").val();
                let add_produto_id = [];
                let add_produto_nome = [];
                let add_produto_valor = [];
        
                $(".input-checkbox").each(function(a){
                    if ($(this).prop('checked')) { 
                        add_produto_id.push($(this).attr('id'));
                        add_produto_nome.push($(this).attr('nome'));
                        add_produto_valor.push($(this).attr('valor'));
                    }
                });

                let valor_total = add_produto_valor.map(Number).reduce(function (total, numero) { return total + numero; }, 0);

                let id_venda = [];
                let mensagem = []; 

                if(`${acao}` == "Cadastrar"){
                    ajax_url = `${urlApi}api/venda`;
                    ajax_type = "post";
                    mensagem = "Cadastrado com sucesso!";
                }else{
                    id_venda = $(this).attr('id_venda');
                    ajax_url = `${urlApi}api/venda/${id_venda}`;
                    ajax_type = "put";
                    mensagem = "Salvo com sucesso!";
                }

                if(`${id_cliente}` == "" || `${id_vendedor}` == "" || `${id_forma_de_pagamento}` == "" || `${data_da_venda}` == "" || `${valor_total}` == "0"){ 
                    alert("Campos marcados com (*) são obrigatórios!");
                    $(".loading").hide(); 
                }else{ 
                    await $.ajax({  
                        url: `${ajax_url}?id_cliente=${id_cliente}&id_vendedor=${id_vendedor}&id_forma_de_pagamento=${id_forma_de_pagamento}&valor_total=${valor_total}&data_da_venda=${data_da_venda}`, type: `${ajax_type}`, dataType: 'json',
                        success: function (data) {
                            pega_ultimo_registro(add_produto_id, add_produto_nome, add_produto_valor);
                        }, 
                        error: function (request, status, error) {
                            console.log(request);
                            alert("Ops! Falha ao comunicar com o servidor, tente novamente.");
                            $(".loading").hide();
                        } 
                    })  

                    async function pega_ultimo_registro(add_produto_id, add_produto_nome, add_produto_valor){
                        await $.ajax({
                            url: `${urlApi}api/get-ultimo-registro-db`, type: 'get', dataType: 'json',
                            success: function (data) {
                                itensDB(data.id, add_produto_id, add_produto_nome, add_produto_valor);
                            }, 
                            error: function (data) {
                                console.log(data); 
                                $(".loading").hide();
                            } 
                        });
                    }

                    async function itensDB(id_venda, add_produto_id, add_produto_nome, add_produto_valor){
                        let quantidade_produtos = add_produto_id.length;
                        let itens_ok = [];
                        let x = 0;
                        let x2 = 1;
                        for(let i of add_produto_id){
                            await $.ajax({  
                                url: `${urlApi}api/venda-itens?id_venda=${id_venda}&id_item=${add_produto_id[x]}&item=${add_produto_nome[x]}&valor=${add_produto_valor[x]}`, type: `${ajax_type}`, dataType: 'json',
                                success: function (data) {
                                    itens_ok.push("ok");
                                }, 
                                error: function (request, status, error) {
                                    console.log(request);
                                    alert("Ops! Falha ao comunicar com o servidor, tente novamente.");
                                    $(".loading").hide();
                                } 
                            });
                            if(`${x2}` == `${quantidade_produtos}`){
                                if(`${x2}` == `${itens_ok.length}`){ 
                                    alert(mensagem);
                                    location.assign(`${urlApi}painel/vendas/listar`);
                                }else{
                                    alert("Ops! Falha ao comunicar com o servidor, tente novamente.");
                                    $(".loading").hide();
                                }
                            }
                            x++;
                            x2++; 
                        }
                    }
                }
            });
        break;
    }
}); 