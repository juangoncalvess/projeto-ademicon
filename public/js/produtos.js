$(document).ready(async function(){
    url_site = url_site.split("produtos/");
    url_site = url_site[1];
    url_site = url_site.split("/");
    console.log(url_site[0]);
  
    //headers: {"Authorization": `Bearer ${token_api}`},

    switch (url_site[0]) {
        case "listar":
            $(".loading").show();
            await $.ajax({
                url: `${urlApi}api/produto`, type: 'get', dataType: 'json',
                success: function (data) {
                    if(`${data}` != ""){
                        let x = 0;
                        for(let i of data){ 
                            let listra_branca = x % 2 == 0 ? "listra-branca" : "";
                            $(".container-principal-div-table tbody").append(`
                                <tr class="${listra_branca} linha-${i.id}">
                                    <td>${i.nome}</td>  
                                    <td class="text-center">R$ ${moedaBR(i.preco)}</td>
                                    <td class="wid-acao text-center"> 
                                        <div class="botoes-de-acao">
                                            <a href="${urlApi}painel/produtos/editar/${i.id}" title="Editar">
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
                let id_produto = $(this).attr('id');
                if(confirm("Deseja excluir?")){
                    await $.ajax({  
                        url: `${urlApi}api/produto/${id_produto}`, type: 'delete', dataType: 'json',
                        success: function (data) {
                            $(`.linha-${id_produto}`).remove();
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
                let nome = $(".input-nome").val();
                let preco = $(".input-preco").val();
                preco = preco.replace(/\./g, '');
                preco = preco.replace(/\,/g, '.');
                let id_produto = [];
                let mensagem = []; 

                if(`${acao}` == "Cadastrar"){
                    ajax_url = `${urlApi}api/produto`;
                    ajax_type = "post";
                    mensagem = "Cadastrado com sucesso!";
                }else{
                    id_produto = $(this).attr('id_produto');
                    ajax_url = `${urlApi}api/produto/${id_produto}`;
                    ajax_type = "put";
                    mensagem = "Salvo com sucesso!";
                }
 
                if(`${nome}` == "" || `${preco}` == ""){ 
                    alert("Campos marcados com (*) são obrigatórios!");
                    $(".loading").hide(); 
                }else{ 
                    await $.ajax({  
                        url: `${ajax_url}?nome=${nome}&preco=${preco}`, type: `${ajax_type}`, dataType: 'json',
                        success: function (data) {
                            alert(mensagem);
                            location.assign(`${urlApi}painel/produtos/listar`);
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