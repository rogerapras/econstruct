<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Ocorrencias Controller
 *
 * @property \App\Model\Table\OcorrenciasTable $Ocorrencias
 *
 * @method \App\Model\Entity\Ocorrencia[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OcorrenciasController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub
        $this->loadModel('Modificacoes');

    }

    public function index()
    {
        $this->paginate = [
            'contain' => ['OcorrenciaTipos', 'Projetos']
        ];
        $ocorrencias = $this->paginate($this->Ocorrencias);

        $this->set(compact('ocorrencias'));
    }

    /**
     * View method
     *
     * @param string|null $id Ocorrencia id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $ocorrencia = $this->Ocorrencias->get($id, [
            'contain' => ['OcorrenciaTipos', 'Projetos']
        ]);

        $this->set('ocorrencia', $ocorrencia);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $ocorrencia = $this->Ocorrencias->newEntity();
        if ($this->request->is('post')) {
            $ocorrencia = $this->Ocorrencias->patchEntity($ocorrencia, $this->request->getData());
            if ($this->Ocorrencias->save($ocorrencia)) {
                $this->Flash->success(__('The ocorrencia has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ocorrencia could not be saved. Please, try again.'));
        }
        $ocorrenciaTipos = $this->Ocorrencias->OcorrenciaTipos->find('list', ['limit' => 200]);
        $projetos = $this->Ocorrencias->Projetos->find('list', ['limit' => 200]);
        $this->set(compact('ocorrencia', 'ocorrenciaTipos', 'projetos'));
    }

    public function visitaNovoCliente()
    {
        $user = $this->Auth->user();

        if ($this->request->is('post')) {
            $this->loadModel('Projetos');
            $this->loadModel('Pessoas');
            $this->loadModel('Clientes');
            $this->loadModel('Enderecos');
            $this->loadModel('Contatos');
            $dados = $this->request->getData();

            try {
                //cria pessoa
                $dados_pessoa['nome'] = (!empty($dados['nomePessoa'])?$dados['nomePessoa']: null);
                $dados_pessoa['nome_social'] = (!empty($dados['nomeSocialPessoa'])?$dados['nomeSocialPessoa']: null);
                $dados_pessoa['estado_civil'] = (!empty($dados['estadoCivilPessoa'])?$dados['estadoCivilPessoa']: null);
                $dados_pessoa['conjuge_id'] = (!empty($dados['conjugeHiddenPessoa'])?$dados['conjugeHiddenPessoa']: null);
                $dados_pessoa['filhos'] = (!empty($dados['filhosPessoa'])?$dados['filhosPessoa']: 0);
                $dados_pessoa['sexo'] = (!empty($dados['sexoPessoa'])?$dados['sexoPessoa']: null);
                $dados_pessoa['tipo'] = 'F';
                $dt = explode('/',$dados['dataNascimentoPessoa']);
                $dados_pessoa['data_nascimento'] = ($dados['dataNascimentoPessoa']<>''? date('Y-m-d',strtotime($dt[2].'-'.$dt[1].'-'.$dt[0])):null);
                $dados_pessoa['cpf_cnpj'] = (!empty($dados['cpfPessoa'])?preg_replace('/[^0-9]/', '', $dados['cpfPessoa']): null);
                $dados_pessoa['rg'] = (!empty($dados['rgPessoa'])?$dados['rgPessoa']: null);
                $dados_pessoa['empresa_id'] = $user['empresa_id'];
                $dados_pessoa['u_id'] = $user['id'];
                $pessoa = $this->Pessoas->newEntity($dados_pessoa);

                //dd($pessoa);

                if ($this->Pessoas->save($pessoa)) {
                    //cria cliente
                    $dados_cliente['pessoa_id'] = $pessoa->id;
                    $dados_cliente['cliente_situacao_id'] = 1;
                    $dados_cliente['observacao'] = (!empty($dados['observacaoCliente'])?$dados['observacaoCliente']: null);
                    $dados_cliente['empresa_id'] = $user['empresa_id'];
                    $dados_cliente['u_id'] = $user['id'];
                    $cliente = $this->Clientes->newEntity($dados_cliente);
                    if ($this->Clientes->save($cliente)) {
                        //cria contato;
                        $dados_contato[0]['pessoa_id'] = $pessoa->id;
                        $dados_contato[0]['tipo'] = 'telefone';
                        $dados_contato[0]['valor'] = (!empty($dados['telefoneCliente'])?$dados['telefoneCliente']: null);
                        $dados_contato[0]['principal'] = 'S';
                        $dados_contato[0]['empresa_id'] = $user['empresa_id'] ;
                        $dados_contato[0]['u_id'] = $user['id'];

                        $dados_contato[1]['pessoa_id'] = $pessoa->id;
                        $dados_contato[1]['tipo'] = 'email';
                        $dados_contato[1]['valor'] = (!empty($dados['emailCliente'])?$dados['emailCliente']: null);
                        $dados_contato[1]['principal'] = 'N';
                        $dados_contato[1]['empresa_id'] = $user['empresa_id'];
                        $dados_contato[1]['u_id'] = $user['id'];
                        $contatos = $this->Contatos->newEntities($dados_contato);//saveMany
                        if ($this->Contatos->saveMany($contatos)) {
                            //cria endereço
                            $dados_endereco['pessoa_id'] = $pessoa->id;
                            $dados_endereco['logradouro'] = (!empty($dados['logradouroCliente'])?$dados['logradouroCliente']: null);
                            $dados_endereco['numero'] = (!empty($dados['numeroCliente'])?$dados['numeroCliente']: null);
                            $dados_endereco['complemento'] = (!empty($dados['complementoCliente'])?$dados['complementoCliente']: null);
                            $dados_endereco['bairro'] = (!empty($dados['bairroCliente'])?$dados['bairroCliente']: null);
                            $dados_endereco['cep'] = (!empty($dados['cepCliente'])?preg_replace('/[^0-9]/', '', $dados['cepCliente']): null);
                            $dados_endereco['cidade'] = (!empty($dados['cidadeCliente'])?$dados['cidadeCliente']: null);
                            $dados_endereco['estado'] = (!empty($dados['estadoCliente'])?$dados['estadoCliente']: null);
                            $dados_endereco['principal'] = 'S';
                            $dados_endereco['empresa_id'] = $user['empresa_id'];
                            $dados_endereco['u_id'] = $user['id'];
                            $endereco = $this->Enderecos->newEntity($dados_endereco);

                            if ($this->Enderecos->save($endereco)) {
                                //cria projeto
                                $dados_projeto['cliente_id'] = $cliente->id;
                                $dados_projeto['descricao'] = (!empty($dados['descricaoProjeto'])?$dados['descricaoProjeto']: null);
                                $dados_projeto['detalhes'] = (!empty($dados['detalhesProjeto'])?$dados['detalhesProjeto']: null);
                                $dados_projeto['pasta_projeto'] = null;
                                $dados_projeto['projeto_situacao_id'] = 1;
                                $dados_projeto['contrato_id'] = null;
                                $dados_projeto['custo_estimado'] = (!empty($dados['custoEstimadoProjeto'])?str_replace(',','.',preg_replace("/[^0-9,]/", "", $dados['custoEstimadoProjeto'])): null);
                                $dados_projeto['observacao'] = (!empty($dados['anotacoesOcorrencia'])?$dados['anotacoesOcorrencia']: null);
                                $dados_projeto['empresa_id'] = $user['empresa_id'];
                                $dados_projeto['u_id'] = $user['id'];
                                $projeto = $this->Projetos->newEntity($dados_projeto);
                                if ($this->Projetos->save($projeto)) {
                                    //cria ocorrencia
                                    $dados_ocorrencia['projeto_id'] = $projeto->id;
                                    $dados_ocorrencia['ocorrencia_tipo_id'] = 1;
                                    $dados_ocorrencia['observacao'] = (!empty($dados['anotacoesOcorrencia'])?$dados['anotacoesOcorrencia']: null);
                                    $dt = explode('/',$dados['dataOcorrencia']);
                                    $dados_ocorrencia['data'] = ($dados['dataOcorrencia']<>''? date('Y-m-d',strtotime($dt[2].'-'.$dt[1].'-'.$dt[0])):null);
                                    $dt = explode('/',$dados['dataPendenciaOcorrencia']);
                                    $dados_ocorrencia['data_pendencia'] = ($dados['dataPendenciaOcorrencia']<>''? date('Y-m-d',strtotime($dt[2].'-'.$dt[1].'-'.$dt[0])):null);
                                    $dados_ocorrencia['empresa_id'] = $user['empresa_id'];
                                    $dados_ocorrencia['u_id'] = $user['id'];
                                    $ocorrencia = $this->Ocorrencias->newEntity($dados_ocorrencia);
                                    if ($this->Ocorrencias->save($ocorrencia)) {

                                        $dados_originais = json_encode([$user['id'],$user['username'],'Nova Visita']);
                                        $dados_novos = json_encode([$user['id'],$user['username'],$ocorrencia,$projeto,$contatos,$endereco,$cliente,$pessoa]);
                                        if($this->Modificacoes->emiteLog('Ocorrencias','visitaNovoCliente',$dados_originais,$dados_novos)) {
                                            $this->Flash->success(__('Visita cadastrada com sucesso.'));
                                        }else{
                                            $this->Flash->error(__('Erro ao gravar log.'));
                                        }

                                        return $this->redirect(['action' => 'todasVisitas']);
                                    }else{
                                        $this->Flash->error(__('Erro ao gravar Visita. Tente Novamente.'));
                                        $this->Projetos->delete($projeto);
                                        foreach($contatos as $c){
                                            $this->Contatos->delete($c);
                                        }
                                        $this->Clientes->delete($cliente);
                                        $this->Pessoas->delete($pessoa);
                                    }
                                }else{
                                    $this->Flash->error(__('Erro ao gravar Projeto. Tente Novamente.'));
                                    foreach($contatos as $c){
                                        $this->Contatos->delete($c);
                                    }
                                    $this->Clientes->delete($cliente);
                                    $this->Pessoas->delete($pessoa);
                                }
                            }else{
                                $this->Flash->error(__('Erro ao gravar Endereço. Tente Novamente.'));
                                foreach($contatos as $c){
                                    $this->Contatos->delete($c);
                                }
                                $this->Clientes->delete($cliente);
                                $this->Pessoas->delete($pessoa);
                            }
                        }else{
                            $this->Flash->error(__('Erro ao gravar Contatos. Tente Novamente.'));
                            $this->Clientes->delete($cliente);
                            $this->Pessoas->delete($pessoa);
                        }
                    }else{
                        $this->Flash->error(__('Erro ao gravar Cliente. Tente Novamente.'));
                        $this->Pessoas->delete($pessoa);
                    }
                } else {
                    $this->Flash->error(__('Erro ao gravar Pessoa. Tente Novamente.'));
                }

            }catch(\Exception $e){
                $this->Flash->error($e->getMessage());
            }
        }
    }

    public function visita()
    {
        $user = $this->Auth->user();
        $this->loadModel('Clientes');

        if ($this->request->is('post')) {
            $this->loadModel('Projetos');
            $this->loadModel('Pessoas');

            $this->loadModel('Enderecos');
            $this->loadModel('Contatos');
            $dados = $this->request->getData();

            try {
                //cria pessoa
                $dados_pessoa['nome'] = (!empty($dados['nomePessoa'])?$dados['nomePessoa']: null);
                $dados_pessoa['nome_social'] = (!empty($dados['nomeSocialPessoa'])?$dados['nomeSocialPessoa']: null);
                $dados_pessoa['estado_civil'] = (!empty($dados['estadoCivilPessoa'])?$dados['estadoCivilPessoa']: null);
                $dados_pessoa['conjuge_id'] = (!empty($dados['conjugeHiddenPessoa'])?$dados['conjugeHiddenPessoa']: null);
                $dados_pessoa['filhos'] = (!empty($dados['filhosPessoa'])?$dados['filhosPessoa']: 0);
                $dados_pessoa['sexo'] = (!empty($dados['sexoPessoa'])?$dados['sexoPessoa']: null);
                $dados_pessoa['tipo'] = 'F';
                $dt = explode('/',$dados['dataNascimentoPessoa']);
                $dados_pessoa['data_nascimento'] = ($dados['dataNascimentoPessoa']<>''? date('Y-m-d',strtotime($dt[2].'-'.$dt[1].'-'.$dt[0])):null);
                $dados_pessoa['cpf_cnpj'] = (!empty($dados['cpfPessoa'])?preg_replace('/[^0-9]/', '', $dados['cpfPessoa']): null);
                $dados_pessoa['rg'] = (!empty($dados['rgPessoa'])?$dados['rgPessoa']: null);
                $dados_pessoa['u_id'] = $user['id'];
                $pessoa = $this->Pessoas->get($dados['pessoa_id'],['contain'=>['Contatos','Enderecos']]);
                $pessoa = $this->Pessoas->patchEntity($pessoa,$dados_pessoa);

                if ($this->Pessoas->save($pessoa)) {
                    //cria cliente
                    $dados_cliente['pessoa_id'] = $pessoa->id;
                    $dados_cliente['cliente_situacao_id'] = 1;
                    $dados_cliente['observacao'] = (!empty($dados['observacaoCliente'])?$dados['observacaoCliente']: null);
                    $dados_cliente['u_id'] = $user['id'];
                    $cliente = $this->Clientes->get($dados['cliente_id']);
                    $cliente = $this->Clientes->patchEntity($cliente,$dados_cliente);
                    if ($this->Clientes->save($cliente)) {
                        foreach($pessoa->contatos as $val){
                            if($val->tipo == 'telefone'){
                                $val->valor = (!empty($dados['telefoneCliente'])?$dados['telefoneCliente']: null);
                                $val->u_id = $user['id'];
                            }else{
                                $val->valor = (!empty($dados['emailCliente'])?$dados['emailCliente']: null);
                                $val->u_id = $user['id'];
                            }
                        }
                        $contatos = $pessoa->contatos;
                        if ($this->Contatos->saveMany($contatos)) {
                            foreach($pessoa->enderecos as $val){
                                $val->logradouro = (!empty($dados['logradouroCliente'])?$dados['logradouroCliente']: null);
                                $val->numero = (!empty($dados['numeroCliente'])?$dados['numeroCliente']: null);
                                $val->complemento = (!empty($dados['complementoCliente'])?$dados['complementoCliente']: null);
                                $val->bairro = (!empty($dados['bairroCliente'])?$dados['bairroCliente']: null);
                                $val->cep = (!empty($dados['cepCliente'])?preg_replace('/[^0-9]/', '', $dados['cepCliente']): null);
                                $val->cidade = (!empty($dados['cidadeCliente'])?$dados['cidadeCliente']: null);
                                $val->estado = (!empty($dados['estadoCliente'])?$dados['estadoCliente']: null);
                                $val->u_id = $user['id'];
                            }
                            $endereco = $pessoa->enderecos;
                            if ($this->Enderecos->saveMany($endereco)) {
                                //cria projeto
                                $dados_projeto['descricao'] = (!empty($dados['descricaoProjeto'])?$dados['descricaoProjeto']: null);
                                $dados_projeto['detalhes'] = (!empty($dados['detalhesProjeto'])?$dados['detalhesProjeto']: null);
                                $dados_projeto['projeto_situacao_id'] = 1;
                                $dados_projeto['custo_estimado'] = (!empty($dados['custoEstimadoProjeto'])?str_replace(',','.',preg_replace("/[^0-9,]/", "", $dados['custoEstimadoProjeto'])): null);
                                $dados_projeto['observacao'] = (!empty($dados['anotacoesOcorrencia'])?$dados['anotacoesOcorrencia']: null);
                                $dados_projeto['u_id'] = $user['id'];
                                $projeto = $this->Projetos->get($dados['projeto_id']);
                                $projeto = $this->Projetos->patchEntity($projeto,$dados_projeto);
                                if ($this->Projetos->save($projeto)) {
                                    //cria ocorrencia
                                    $dados_ocorrencia['projeto_id'] = $projeto->id;
                                    $dados_ocorrencia['ocorrencia_tipo_id'] = 1;
                                    $dados_ocorrencia['observacao'] = (!empty($dados['anotacoesOcorrencia'])?$dados['anotacoesOcorrencia']: null);
                                    $dt = explode('/',$dados['dataOcorrencia']);
                                    $dados_ocorrencia['data'] = ($dados['dataOcorrencia']<>''? date('Y-m-d',strtotime($dt[2].'-'.$dt[1].'-'.$dt[0])):null);
                                    $dt = explode('/',$dados['dataPendenciaOcorrencia']);
                                    $dados_ocorrencia['data_pendencia'] = ($dados['dataPendenciaOcorrencia']<>''? date('Y-m-d',strtotime($dt[2].'-'.$dt[1].'-'.$dt[0])):null);
                                    $dados_ocorrencia['empresa_id'] = $user['empresa_id'];
                                    $dados_ocorrencia['u_id'] = $user['id'];
                                    $ocorrencia = $this->Ocorrencias->newEntity($dados_ocorrencia);
                                    if ($this->Ocorrencias->save($ocorrencia)) {

                                        $dados_originais = json_encode([$user['id'],$user['username'],'Nova Visita']);
                                        $dados_novos = json_encode([$user['id'],$user['username'],$ocorrencia,$projeto,$contatos,$endereco,$cliente,$pessoa]);
                                        if($this->Modificacoes->emiteLog('Ocorrencias','visitaNovoCliente',$dados_originais,$dados_novos)) {
                                            $this->Flash->success(__('Visita gravada com sucesso.'));
                                        }else{
                                            $this->Flash->error(__('Erro ao gravar log.'));
                                        }

                                        return $this->redirect(['action' => 'todasVisitas']);
                                    }
                                }else{
                                    $this->Flash->error(__('Erro ao gravar Projeto. Tente Novamente.'));
                                }
                            }else{
                                $this->Flash->error(__('Erro ao gravar Endereço. Tente Novamente.'));
                            }
                        }else{
                            $this->Flash->error(__('Erro ao gravar Contatos. Tente Novamente.'));
                        }
                    }else{
                        $this->Flash->error(__('Erro ao gravar Cliente. Tente Novamente.'));
                    }
                } else {
                    $this->Flash->error(__('Erro ao gravar Pessoa. Tente Novamente.'));
                }

            }catch(\Exception $e){
                $this->Flash->error($e->getMessage());
            }
        }

        $clientes = $this->Clientes->find()->contain(['Pessoas','Pessoas.Contatos','Pessoas.Enderecos','Projetos']);

        $listaClientes = [];
        $listaClientes+= [''=>''];
        foreach($clientes as $val){
            $listaClientes += [$val->id=>$val->pessoa->nome];
        }
        $this->set(compact('listaClientes','clientes'));

    }

    public function todasVisitas(){
        $this->paginate = [
            'contain' => ['OcorrenciaTipos', 'Projetos','Projetos.Clientes','Projetos.Clientes.Pessoas','Projetos.Clientes.Pessoas.Contatos','Projetos.Clientes.Pessoas.Enderecos'],
            'conditions' => ['ocorrencia_tipo_id'=>1 ]
        ];
        $ocorrencias = $this->paginate($this->Ocorrencias);

        $this->set(compact('ocorrencias'));
    }

    public function relatorio()
    {
        $ocorrencia = $this->Ocorrencias->newEntity();
        if ($this->request->is('post')) {
            $ocorrencia = $this->Ocorrencias->patchEntity($ocorrencia, $this->request->getData());
            if ($this->Ocorrencias->save($ocorrencia)) {
                $this->Flash->success(__('The ocorrencia has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ocorrencia could not be saved. Please, try again.'));
        }
        $ocorrenciaTipos = $this->Ocorrencias->OcorrenciaTipos->find('list', ['limit' => 200]);
        $projetos = $this->Ocorrencias->Projetos->find('list', ['limit' => 200]);
        $this->set(compact('ocorrencia', 'ocorrenciaTipos', 'projetos'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Ocorrencia id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null,$origem=null)
    {
        $ocorrencia = $this->Ocorrencias->get($id, [
            'contain' => ['OcorrenciaTipos','Projetos','Projetos.Clientes','Projetos.Clientes.Pessoas','Projetos.Clientes.Pessoas.Contatos']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $dados = $this->request->getData();

            $dt = explode('/',$dados['data']);
            $dados['data'] = ($dados['data']<>''? date('Y-m-d',strtotime($dt[2].'-'.$dt[1].'-'.$dt[0])):null);
            $dt = explode('/',$dados['data_pendencia']);
            $dados['data_pendencia'] = ($dados['data_pendencia']<>''? date('Y-m-d',strtotime($dt[2].'-'.$dt[1].'-'.$dt[0])):null);

            $ocorrencia = $this->Ocorrencias->patchEntity($ocorrencia, $dados);
            if ($this->Ocorrencias->save($ocorrencia)) {

                if($origem == 1) {
                    $this->Flash->success(__('A visita foi editada.'));
                    return $this->redirect(['action' => 'todasVisitas']);
                }else{
                    $this->Flash->success(__('A ocorrência foi editada.'));
                    return $this->redirect(['action' => 'index']);
                }
            }
            $this->Flash->error(__('The ocorrencia could not be saved. Please, try again.'));
        }
        $ocorrenciaTipos = $this->Ocorrencias->OcorrenciaTipos->find('list', ['limit' => 200]);
        $projetos = $this->Ocorrencias->Projetos->find('list', ['limit' => 200]);
        $this->set(compact('ocorrencia', 'ocorrenciaTipos', 'projetos'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Ocorrencia id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ocorrencia = $this->Ocorrencias->get($id);
        if ($this->Ocorrencias->delete($ocorrencia)) {
            $this->Flash->success(__('The ocorrencia has been deleted.'));
        } else {
            $this->Flash->error(__('The ocorrencia could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
