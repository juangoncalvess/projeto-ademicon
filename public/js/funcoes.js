let url_site = window.location.href;
let urlApi = $("body").attr('url');
let token_api = $("body").attr('token-auth');

function data_nascimentoBR(data_nascimento){
    data_nascimento = data_nascimento.split(" ");
    data_nascimento = data_nascimento[0].split("-");
    return `${data_nascimento[2]}/${data_nascimento[1]}/${data_nascimento[0]}`;
} 

function moedaBR(valor){
    valor = valor.toString().replace(/\D/g,"");
    valor = valor.toString().replace(/(\d)(\d{8})$/,"$1.$2");
    valor = valor.toString().replace(/(\d)(\d{5})$/,"$1.$2");
    valor = valor.toString().replace(/(\d)(\d{2})$/,"$1,$2");
    return valor;
} 

$(document).ready(function(){
    $(".valida-cpf").mask("999.999.999-99");
    $(".valida-cep").mask("99.999-999");

    $(".valida-preco").on('keyup', function(){
        let preco = $(this).val();
        preco = preco.replace(/[^\d,]/g, '');
        preco = preco.toString().replace(/\D/g,"");
        preco = preco.toString().replace(/(\d)(\d{8})$/,"$1.$2");
        preco = preco.toString().replace(/(\d)(\d{5})$/,"$1.$2");
        preco = preco.toString().replace(/(\d)(\d{2})$/,"$1,$2");
        $(this).val(preco);
    });

    $('.menu-mobile-icon').click(function() {
        $('.menu-lateral-engloba').css({"left": "0%", "transition": "0.5s"});
    });
    $('.menu-lateral-fechar').click(function() {
        $('.menu-lateral-engloba').css({"left": "-100%", "transition": "0.5s"});
    });

}); 