$(document).ready(async function(){
    url_site = url_site.split("clientes/");
    url_site = url_site[1];
    url_site = url_site.split("/");
  
    //headers: {"Authorization": `Bearer ${token_api}`},

    switch (url_site[0]) {
        case "listar":
            $(".loading").show();
            await $.ajax({
                url: `${urlApi}api/cliente`, type: 'get', dataType: 'json',
                success: function (data) {
                    if(`${data}` != ""){
                        let x = 0;
                        for(let i of data){ 
                            let endereco = `${i.logradouro}, ${i.complemento} - ${i.bairro}, ${i.localidade}/${i.uf}`;
                            let listra_branca = x % 2 == 0 ? "listra-branca" : "";
                            $(".container-principal-div-table tbody").append(`
                                <tr class="${listra_branca} linha-${i.id}">
                                    <td>${i.nome}</td>  
                                    <td class="display-none-990">${i.email}</td>
                                    <td class="wid-cpf text-center display-none-990">${i.cpf}</td>
                                    <td class="display-none-1200">${endereco}</td> 
                                    <td class="wid-acao text-center">
                                        <div class="botoes-de-acao">
                                            <a href="${urlApi}painel/clientes/resumo/${i.id}" title="Resumo de vendas"> 
                                                <ion-icon name="eye-outline" role="img" class="md hydrated"></ion-icon>
                                            </a>
                                            <a href="${urlApi}painel/clientes/editar/${i.id}" title="Editar">
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
                let id_cliente = $(this).attr('id');
                if(confirm("Deseja excluir?")){
                    await $.ajax({  
                        url: `${urlApi}api/cliente/${id_cliente}?ativo=0`, type: 'put', dataType: 'json',
                        success: function (data) {
                            //alert("Exclúido com sucesso!");
                            $(`.linha-${id_cliente}`).remove();
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
                url: `${urlApi}api/resumo-do-cliente/${url_site[1]}`, type: 'get', dataType: 'json',
                success: function (data) {
                    if(`${data}` != ""){
                        $(".titulo-nome-vendedor").html(`${data.cliente_nome}, ${data.cliente_cpf}`);
                        let x = 0;
                        for(let i of data.compras){ 
                            let listra_branca = x % 2 == 0 ? "listra-branca" : "";
                            $(".container-principal-div-table tbody").append(`
                                <tr class="${listra_branca} linha-${i.id}">
                                    <td>${data_nascimentoBR(i.data)}</td>  
                                    <td class="display-none-990">${i.vendedor}</td>
                                    <td class="wid-resumo-itens-vendidos text-center display-none-990">${i.quantidade_de_itens}</td>
                                    <td class="wid-resumo-valor-da-venda text-center">R$ ${moedaBR(i.valor_da_compra)}</td>
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
                let cpf = $(".input-cpf").val();
                let cep = $(".input-cep").val();
                let logradouro = $(".input-logradouro").val();
                let complemento = $(".input-complemento").val();
                let bairro = $(".input-bairro").val();
                let localidade = $(".input-localidade").val();
                let uf = $(".input-uf").val();
                let ibge = ""; //$(".input-ibge").val();
                let ddd = ""; //$(".input-ddd").val();
                let ativo = "1";
                let id_cliente = [];
                let mensagem = [];

                if(`${acao}` == "Cadastrar"){
                    ajax_url = `${urlApi}api/cliente`;
                    ajax_type = "post";
                    mensagem = "Cadastrado com sucesso!";
                }else{
                    id_cliente = $(this).attr('id_cliente'); 
                    ajax_url = `${urlApi}api/cliente/${id_cliente}`;
                    ajax_type = "put";
                    mensagem = "Salvo com sucesso!";
                }

                if(`${nome}` == "" || `${email}` == "" || `${cpf}` == "" || `${cep}` == "" || `${logradouro}` == "" || `${complemento}` == "" || `${bairro}` == "" || `${localidade}` == "" || `${uf}` == ""){
                    alert("Campos marcados com (*) são obrigatórios!");
                    $(".loading").hide(); 
                }else{ 
                    await $.ajax({  
                        url: `${ajax_url}?nome=${nome}&email=${email}&cpf=${cpf}&cep=${cep}&logradouro=${logradouro}&complemento=${complemento}&bairro=${bairro}&localidade=${localidade}&uf=${uf}&ibge=${ibge}&ddd=${ddd}&ativo=${ativo}`, type: `${ajax_type}`, dataType: 'json',
                        success: function (data) {
                            alert(mensagem);
                            location.assign(`${urlApi}painel/clientes/listar`);
                        }, 
                        error: function (request, status, error) {
                            console.log(request);
                            alert("Ops! Falha ao comunicar com o servidor, tente novamente.");
                            $(".loading").hide();
                        } 
                    })  
                }
            });


            $(".input-cep").on('focusout', async function(){
                let cep = $(this).val();
                cep = cep.replace(/\D/g, '');
                await $.ajax({ url: `https://viacep.com.br/ws/${cep}/json/`, 
                    success: function(result){
                        console.log(result);
                        $(".input-logradouro").val(result.logradouro); 
                        cep_js("API", "cepbr_bairro", result);
                        cep_js("API", "cepbr_cidade", result);
                        cep_js("API", "cepbr_estado", result);
                    }
                });   
            }); 

            $(document).on("change", ".input-uf", async function(){
                let estado = $(this).val();
                cep_js("MANUAL", "cepbr_cidade", estado);
                $(".input-bairro").html(`<option value="" hidden>Selecione a cidade...</option>`); 
            });
            $(".input-localidade").on('change', async function(){
                let cidade = $(this).val();
                cep_js("MANUAL", "cepbr_bairro", cidade);
            });
             
            async function cep_js(tipo, acao, value){
                let classe = [];
                let value_url = [];
                let value_if = [];
                switch(acao){
                    case "cepbr_bairro":
                        classe = ".input-bairro";
                        if(tipo == "API"){
                            value_url = value.localidade;
                            value_if = value.bairro; 
                        }else{
                            value_url = value;
                        }
                    break;
                    case "cepbr_cidade":
                        classe = ".input-localidade";
                        if(tipo == "API"){
                            value_url = value.uf;
                            value_if = value.localidade; 
                        }else{ 
                            value_url = value;
                        }
                    break;
                    case "cepbr_estado":
                        classe = ".input-uf"; 
                        if(tipo == "API"){
                            value_url = value.uf;
                        }else{
                            value_url = value;
                        }
                        value_if = value_url;
                    break;
                }
                await $.ajax({
                    url: `${urlApi}painel/ajax/${acao}/${value_url}`, data: {"_token": "{{ csrf_token() }}"}, type: 'get', dataType: 'json',
                    success: function (data) {
                        $(classe).html(`<option value="" hidden>Selecione</option>`);      
                        for(let i of data.result){
                            let valueDB = [];
                            switch(acao){
                                case "cepbr_bairro":
                                    valueDB = i.bairro;
                                break;
                                case "cepbr_cidade":
                                    valueDB = i.cidade;
                                break;
                                case "cepbr_estado":
                                    valueDB = i.uf; 
                                break;
                            }                        
                            if(value_if == valueDB){
                                $(classe).append(`<option value="${valueDB}" selected>${valueDB}</option>`);
                            }else{
                                $(classe).append(`<option value="${valueDB}">${valueDB}</option>`);
                            }
                        }
                    }, 
                    error: function (data) {
                        console.log(data);
                    }  
                })
            }


        break;
    }
}); 