
$( document ).ready(function(){
    if($('#id').val() != '' && $('#id').val()!= null && $('#id').val() != undefined){
        $('#novoOrcamento').attr('style','display:block');
    }else{
        $('#novoOrcamento').attr('style','display:none');
    }

    $('#novoOrcamento').on('click',function(){
        $('#id').val('');
        $('#idOrcamento').html('');
        $(this).attr('style','display:none');
        $('#custo').focus();
    });

    $('.form-edit-orcamento').on('click', function(e) {
        e.preventDefault();
        $('body').append("<div id='loadingAjax' style='display: block;position:fixed; top:0;left:0; z-index: 99999; width: 100%; height: 100%; opacity: .5; transition: opacity 0.15s linear;   background-color: #000;  box-sizing: border-box;'><img style='position: absolute;top:50%;left:50%' src='"+imgLoad+"'></div>");
        $.ajax({
            url: $(this).attr("href"),
            type: "get",
            data: {hash: hashOrcamento},
            success: function (result) {
                $('#loadingAjax').remove();
                var orc = jQuery.parseJSON(result);

                $('#id').val(orc.id);
                $('#projeto_id').val(orc.projeto.id);
                $('#idOrcamento').html(orc.id);
                $('#custo').val(orc.custo);
                $('#total').val(orc.total);

                dt = orc.data_inicial;
                if(dt != null && dt != undefined) {
                    dt = dt.split('-');
                    day = dt[2];
                    day = day.split('T');
                    dt_r = day[0] + '/' + dt[1] + '/' + dt[0];
                    $('#data_inicial').val(dt_r);
                    $('#data_inicial').datepicker('update', dt_r);
                }else{
                    $('#data_inicial').val('');
                    $('#data_inicial').datepicker('update', '');
                }

                dt = orc.data_entrega;
                if(dt != null && dt != undefined) {
                    dt = dt.split('-');
                    day = dt[2];
                    day = day.split('T');
                    dt_r = day[0] + '/' + dt[1] + '/' + dt[0];
                    $('#data_entrega').val(dt_r);
                    $('#data_inicial').datepicker('update', dt_r);
                }else{
                    $('#data_entrega').val('');
                    $('#data_inicial').datepicker('update', '');
                }

                $('#observacao').val(orc.observacao);

                $('#novoOrcamento').attr('style','display:block');
            },
        });
    });

    $("#custo").maskMoney({
        prefix: "R$ ",
        decimal: ",",
        thousands: "."
    });
    $("#total").maskMoney({
        prefix: "R$ ",
        decimal: ",",
        thousands: "."
    });
    $( function() {
        $( "#data_inicial" ).datepicker({
            format: 'dd/mm/yyyy',
            todayBtn: false,
            language: "pt-BR"
        });
    } );
    $( function() {
        $( "#data_entrega" ).datepicker({
            format: 'dd/mm/yyyy',
            todayBtn: false,
            language: "pt-BR"
        });
    } );

    $('#id').val('');
    $('#custo').val('');
    $('#total').val('');
    $('#data_inicial').val('');
    $('#data_entrega').val('');
    $('#observacao').val('');
});