$(document).ready(function(){

    $("#erro_cpf_cnpj").hide();
    $('#cpf_cnpj').mask('00.000.000/0000-00');
    $('#cpf_cnpj').on('blur',function() {
        validaCnpj($('#cpf_cnpj'), $("#erro_cpf_cnpj"), $('#salvarRenda'));
    });
    $('#tipo').change(function(){
        $('#cpf_cnpj').val('');
        if($('#tipo option:selected').val() == 'F'){
            $('#cpf_cnpj').mask('000.000.000-00');
            $('#cpf_cnpj').on('blur',function()
            {
                validaCpf($('#cpf_cnpj'),$("#erro_cpf_cnpj"),$('#salvarRenda'));

            });
        }else{
            $('#cpf_cnpj').mask('00.000.000/0000-00');
            $('#cpf_cnpj').on('blur',function()
            {
                validaCnpj($('#cpf_cnpj'),$("#erro_cpf_cnpj"),$('#salvarRenda'));

            });
        }
    });

    $("#renda_bruta").maskMoney({
        prefix: "R$ ",
        decimal: ",",
        thousands: "."
    });

    $("#renda_liquida").maskMoney({
        prefix: "R$ ",
        decimal: ",",
        thousands: "."
    });
});