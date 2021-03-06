<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cliente $cliente
 */
?>
<script>
    var stSitConj = {
        sE: true,
        sF: true,
        sJ: true,
        sC: true,
        sP: true,
        sL: true
    }
    var imgLoad = '<?= $this->Url->build('/img/ajax-loader.gif') ?>';
</script>
<?= $this->Html->script('conjuge.js') ?>

<div id="addConjuge" >
    <?php echo $this->Flash->render() ?>
    <div class="modal-header">
        <h5 class="modal-title">Cadastro de Cônjuge</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="fechar">
            <span aria-hidden="true">×</span>
        </button>
    </div>
    <?= $this->Form->create(null,['id'=>'formConjuge']) ?>
    <div class="modal-body">
        <h5 class="card-title">Preencha as informações abaixo</h5>
            <?= $this->Form->control('conjuge_id', ['id'=>'conjuge_id','type' => 'hidden','value'=>$conjuge_id]); ?>
        <div class="position-relative row form-group">
            <label for="nomePessoa" class="col-sm-2 col-form-label">Nome:</label>
            <div class="col-sm-10">
                <?= $this->Form->control('nomePessoa',['label'=>false,'type'=>'text','name'=>'nomePessoa','id'=>'nomePessoa','class'=>'form-control','placeholder'=>'Digite o nome da(o) Cônjuge']); ?>
            </div>
        </div>

        <div class="position-relative row form-group">
            <label for="sexoPessoa" class="col-sm-2 col-form-label">Sexo:</label>
            <div class="col-sm-10">
                <?= $this->Form->control('sexoPessoa', ['label'=>false,'options'=>['M'=>'Masculino','F'=>'Feminino'],'id'=>'sexoPessoa','class' => 'form-control']); ?>
            </div>
        </div>

        <div class="position-relative row form-group">
            <label for="cpfPessoaConjuge" class="col-sm-2 col-form-label">CPF:</label>
            <div class="col-sm-10">
                <?= $this->Form->control('cpfPessoaConjuge', ['id'=>'cpfPessoaConjuge','label'=>false,'placeholder'=>'Somente números','class' => 'form-control cpf']); ?>
                <div id="erro_cpf_conjuge" role="alert" style="margin-top:4px;"></div>
            </div>
        </div>

        <div class="position-relative row form-group">
            <label for="telefoneCliente" class="col-sm-2 col-form-label">Telefone:</label>
            <div class="col-sm-10">
                <?= $this->Form->control('telefoneCliente', ['id'=>'telefoneCliente','label'=>false,'placeholder'=>'(99) 99999-9999','class' => 'form-control telefone']); ?>
            </div>
        </div>

        <div class="position-relative row form-group">
            <label for="rgPessoa" class="col-sm-2 col-form-label">RG:</label>
            <div class="col-sm-10">
                <?= $this->Form->control('rgPessoa',['label'=>false,'type'=>'text','name'=>'rgPessoa','id'=>'rgPessoa','class'=>'form-control']); ?>
            </div>
        </div>
        <div class="position-relative row form-group">
            <label for="dataNascimento" class="col-sm-2 col-form-label">Data de Nascimento:</label>
            <div class="col-sm-10">
                <?= $this->Form->control('dataNascimento',['label'=>false,'type'=>'text','name'=>'dataNascimento','id'=>'dataNascimento','class'=>'form-control']); ?>
            </div>
        </div>
        <div class="position-relative row form-group">
            <label for="profissaoPessoa" class="col-sm-2 col-form-label">Profissão:</label>
            <div class="col-sm-10">
                <?= $this->Form->control('profissaoPessoa',['label'=>false,'type'=>'text','name'=>'profissaoPessoa','id'=>'profissaoPessoa','class'=>'form-control','placeholder'=>'Digite a profissão da(o) Cônjuge']); ?>
            </div>
        </div>

        <div class="position-relative row form-group">
            <label for="nacionalidadePessoa" class="col-sm-2 col-form-label">Nacionalidade:</label>
            <div class="col-sm-10">
                <?= $this->Form->control('nacionalidadePessoa',['label'=>false,'type'=>'text','name'=>'nacionalidadePessoa','id'=>'nacionalidadePessoa','class'=>'form-control','placeholder'=>'Digite a nacionalidade da(o) Cônjuge']); ?>
            </div>
        </div>
        <div class="position-relative row form-group">
            <label for="naturalidadePessoa" class="col-sm-2 col-form-label">Naturalidade:</label>
            <div class="col-sm-10">
                <?= $this->Form->control('naturalidadePessoa',['label'=>false,'type'=>'text','name'=>'naturalidadePessoa','id'=>'naturalidadePessoa','class'=>'form-control','placeholder'=>'Digite a naturalidade da(o) Cônjuge']); ?>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <?= $this->Form->button(__('Salvar'),['id'=>'salvarConjuge','class'=>'btn btn-secondary']) ?>
        <button id="fechaModal" type="button" class="btn btn-secondary close-popdown" data-dismiss="modal">fechar</button>
    </div>
    <?= $this->Form->end() ?>
    <script>
        $(document).ready(function(){
            $("#erro_cpf_conjuge").hide();
            $('.cpf').mask('000.000.000-00');
            $('.cpf').on('blur',function()
            {
                validaCpf($('.cpf'),$("#erro_cpf_conjuge"),$('#salvarConjuge'),stSitConj);
            });
        });
        $( function() {
            $( "#dataNascimento" ).datepicker({
                format: 'dd/mm/yyyy',
                todayBtn: false,
                language: "pt-BR"
            });
        } );
        $('.telefone').mask(SPMaskBehavior, spOptions);
    </script>
</div>

