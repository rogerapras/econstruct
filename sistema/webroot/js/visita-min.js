$(document).ready(function(){$("#clienteId").on("change",function(){var e=$(this).val();$.ajax({type:"GET",url:urlVisit+e,ProcessData:!0,data:{hash:hashVisit},success:function(e){if(""==e)$("#nomePessoa").val(""),$("#telefoneCliente").val(""),$("#emailCliente").val(""),$("#cpfPessoa").val(""),$("#sexoPessoa").val(""),$("#rgPessoa").val(""),$("#estadoCivilPessoa").val(""),$("#filhosPessoa").val(""),$("#conjugeHiddenPessoa").val(""),$("#cepCliente").val(""),$("#logradouroCliente").val(""),$("#numeroCliente").val(""),$("#bairroCliente").val(""),$("#complementoCliente").val(""),$("#cidadeCliente").val(""),$("#estadoCliente").val(""),$("#nomeSocialPessoa").val(""),$("#observacaoCliente").val(""),$("#descricaoProjeto").val(""),$("#detalhesProjeto").val(""),$("#custoEstimadoProjeto").val(""),$("#observacaoProjeto").val(""),$("#pessoa_id").val(""),$("#projeto_id").val(""),$("#cliente_id").val(""),href=$("#conjugeCliente").attr("href"),href.indexOf("edit")>-1&&(href=href.replace("edit","add"),$("#conjugeCliente").attr("href",href),$("#conjugeCliente").html("Cadastrar Cônjuge")),href2=$("#linkRenda").html(),$("#rendaCliente").attr("href",href2);else{var a=jQuery.parseJSON(e);telefone="",a.pessoa.contatos.forEach(function(e,a){"telefone"==e.tipo&&(""==telefone?telefone=e.valor:telefone=telefone+"/"+e.valor)}),email="",a.pessoa.contatos.forEach(function(e,a){"email"==e.tipo&&(""==email?email=e.valor:email=email+"/"+e.valor)}),endereco="",a.pessoa.enderecos.forEach(function(e,a){endereco=e}),$("#nomePessoa").val(a.pessoa.nome),$("#telefoneCliente").val(telefone),$("#emailCliente").val(email),$("#cpfPessoa").val(a.pessoa.cpf_cnpj),$("#sexoPessoa").val(a.pessoa.sexo),$("#rgPessoa").val(a.pessoa.rg),$("#estadoCivilPessoa").val(a.pessoa.estado_civil),$("#filhosPessoa").val(a.pessoa.filhos),$("#conjugeHiddenPessoa").val(a.pessoa.conjuge_id),$("#cepCliente").val(endereco.cep),$("#logradouroCliente").val(endereco.logradouro),$("#numeroCliente").val(endereco.numero),$("#bairroCliente").val(endereco.bairro),$("#complementoCliente").val(endereco.complemento),$("#cidadeCliente").val(endereco.cidade),$("#estadoCliente").val(endereco.estado),$("#nomeSocialPessoa").val(a.pessoa.nome_social),$("#observacaoCliente").val(a.pessoa.observacao),$("#descricaoProjeto").val(a.projeto.descricao),$("#detalhesProjeto").val(a.projeto.detalhes),$("#custoEstimadoProjeto").val(a.projeto.custo_estimado),$("#observacaoProjeto").val(a.projeto.observacao),$("#pessoa_id").val(a.pessoa.id),$("#projeto_id").val(a.projeto.id),$("#cliente_id").val(a.id),null!=$("#conjugeHiddenPessoa").val()&&null!=$("#conjugeHiddenPessoa").val()&&""!=$("#conjugeHiddenPessoa").val()&&(href=$("#conjugeCliente").attr("href"),-1==href.indexOf("edit")&&(href=href.replace("add","edit"),href=href+"/"+$("#conjugeHiddenPessoa").val(),$("#conjugeCliente").attr("href",href),$("#conjugeCliente").html("Editar Cônjuge"))),href2=$("#rendaCliente").attr("href"),alert(href2),href2=href2+"/"+$("#pessoa_id").val(),$("#rendaCliente").attr("href",href2)}},contentType:"application/json; charset=utf-8"})}),$("#erro_email").hide(),$(".email").on("blur",function(){validaEmail($(this),$("#erro_email"),$("#salvar"))}),$(".email").focus(function(){$("#salvar").prop("disabled",!1),$("#erro_email").hide()}),lc=$("#logradouroCliente"),bc=$("#bairroCliente"),cc=$("#cidadeCliente"),ec=$("#estadoCliente"),nc=$("#numeroCliente"),limpa_formulário_cep(lc,bc,cc,ec),$("#erro_cep").hide(),$(".cep").mask("00.000-000"),$(".cep").blur(function(){validaCep($(this),lc,bc,cc,ec,nc,$("#erro_cep"))}),$("#erro_cpf").hide(),$("#cpfPessoa").mask("000.000.000-00"),$("#cpfPessoa").on("blur",function(){validaCpf($("#cpfPessoa"),$("#erro_cpf"),$("#salvar"))}),$("#custoEstimadoProjeto").maskMoney({prefix:"R$ ",decimal:",",thousands:"."})});