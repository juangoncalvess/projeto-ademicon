$(document).ready(async function(){
    url_site = url_site.split("vendedores/");
    url_site = url_site[1];
    url_site = url_site.split("/");
  
    //headers: {"Authorization": `Bearer ${token_api}`},

    switch (url_site[0]) {
        case "listar":
            $(".loading").show();
            await $.ajax({
                url: `${urlApi}api/vendedor`, type: 'get', dataType: 'json',
                success: function (data) {
                    if(`${data}` != ""){
                        let x = 0;
                        for(let i of data){
                            let listra_branca = x % 2 == 0 ? "listra-branca" : "";
                            $(".container-principal-div-table tbody").append(`
                                <tr class="${listra_branca} linha-${i.id}">
                                    <td>${i.nome}</td>  
                                    <td class="display-none-1200">${i.email}</td>
                                    <td class="wid-data-nasc text-center">${data_nascimentoBR(i.data_nascimento)}</td>
                                    <td class="wid-acao text-center">
                                        <div class="botoes-de-acao">
                                            <a href="${urlApi}painel/vendedores/resumo/${i.id}" title="Resumo">
                                                <ion-icon name="eye-outline" role="img" class="md hydrated"></ion-icon>
                                            </a>
                                            <a href="${urlApi}painel/vendedores/editar/${i.id}" title="Editar">
                                                <ion-icon name="settings-outline" role="img" class="md hydrated"></ion-icon>
                                            </a>                                     
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
                let id_vendedor = $(this).attr('id');
                if(confirm("Deseja excluir?")){
                    await $.ajax({  
                        url: `${urlApi}api/vendedor/${id_vendedor}?ativo=0`, type: 'put', dataType: 'json',
                        success: function (data) {
                            $(`.linha-${id_vendedor}`).remove();
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

        case "resumo":
            $(".loading").show();
            await $.ajax({
                url: `${urlApi}api/resumo-do-vendedor/${url_site[1]}`, type: 'get', dataType: 'json',
                success: function (data) {
                    let vendas = data.vendas;
                    let itens = vendas.map(item => item.itens);
                    if(`${data}` != ""){
                        $(".titulo-nome-vendedor").html(`${data.vendedor_nome} | Vendas: ${data.quantidade_de_vendas} | Total: R$ ${moedaBR(data.total_de_vendas)}`);
                        let x = 0;
                        for(let i of vendas){                             
                            let listra_branca = x % 2 == 0 ? "listra-branca" : "";
                            $(".container-principal-div-table tbody").append(`
                                <tr class="${listra_branca} linha-${i.id}">
                                    <td>${data_nascimentoBR(i.data)}</td>  
                                    <td class="wid-resumo-itens-vendidos text-center">${i.quantidade_de_itens}</td>
                                    <td class="wid-resumo-valor-da-venda text-center">R$ ${moedaBR(i.valor_da_venda)}</td>
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
        break;
    
        default:
            $(document).on("click", ".button-form", async function(){
                $(".loading").show();
                let ajax_type = [];
                let ajax_url = [];
                let acao = $(this).attr('id');
                let nome = $(".input-nome").val();
                let email = $(".input-email").val();
                let data_nascimento = $(".input-data_nascimento").val();
                let ativo = "1";
                let id_vendedor = [];
                let mensagem = [];

                if(`${acao}` == "Cadastrar"){
                    ajax_url = `${urlApi}api/vendedor`;
                    ajax_type = "post";
                    mensagem = "Cadastrado com sucesso!";
                }else{
                    id_vendedor = $(this).attr('id_vendedor'); 
                    ajax_url = `${urlApi}api/vendedor/${id_vendedor}`;
                    ajax_type = "put";
                    mensagem = "Salvo com sucesso!";
                }

                if(`${nome}` == "" || `${email}` == "" || `${data_nascimento}` == ""){
                    alert("Campos marcados com (*) são obrigatórios!");
                    $(".loading").hide(); 
                }else{ 
                    await $.ajax({  
                        url: `${ajax_url}?nome=${nome}&email=${email}&data_nascimento=${data_nascimento}&ativo=${ativo}`, type: `${ajax_type}`, dataType: 'json',
                        success: function (data) {
                            alert(mensagem);
                            location.assign(`${urlApi}painel/vendedores/listar`);
                        }, 
                        error: function (request, status, error) {
                            console.log(request);
                            alert("Ops! Falha ao comunicar com o servidor, tente novamente.");
                            $(".loading").hide();
                        } 
                    })  
                }
            }); 
        break;
    }
}); 