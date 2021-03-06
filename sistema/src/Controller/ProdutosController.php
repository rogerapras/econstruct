<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Produtos Controller
 *
 * @property \App\Model\Table\ProdutosTable $Produtos
 *
 * @method \App\Model\Entity\Produto[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProdutosController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */

    public function index()
    {
        $this->paginate = [
            'contain' => ['ProdutoTipos','ProdutoPai']
        ];
        $produtos = $this->paginate($this->Produtos);

        $this->set(compact('produtos'));
    }

    /**
     * View method
     *
     * @param string|null $id Produto id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $produto = $this->Produtos->get($id, [
            'contain' => ['ProdutoTipos', 'Itens','ProdutoPai']
        ]);

        $this->set('produto', $produto);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $produto = $this->Produtos->newEntity();
        if ($this->request->is('post')) {
            $dados = $this->request->getData();
            $dados['empresa_id'] = $this->user['empresa_id'];
            $dados['u_id'] = $this->user['id'];

            $produto = $this->Produtos->patchEntity($produto, $dados);
            if ($this->Produtos->save($produto)) {
                $this->Flash->success(__('O produto foi salvo com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('O produto não pode ser salvo. Tente novamente mais tarde.'));
        }
        $produtoTipos = $this->Produtos->ProdutoTipos->find('list', ['limit' => 200]);
        $produtos = $this->Produtos->find('list', ['limit' => 200]);
        $this->set(compact('produto', 'produtoTipos','produtos'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Produto id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $produto = $this->Produtos->get($id, [
            'contain' => ['ProdutoTipos', 'Itens','ProdutoPai']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $dados = $this->request->getData();
            $dados['u_id'] = $this->user['id'];
            $produto = $this->Produtos->patchEntity($produto, $dados);
            if ($this->Produtos->save($produto)) {
                $this->Flash->success(__('O produto foi salvo com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('O produto não pode ser salvo. Tente novamente mais tarde.'));
        }
        $produtoTipos = $this->Produtos->ProdutoTipos->find('list', ['limit' => 200]);
        $produtos = $this->Produtos->find('list', ['limit' => 200])->where(['id <> '.$id]);
        $this->set(compact('produto', 'produtoTipos','produtos'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Produto id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $produto = $this->Produtos->get($id);
        if ($this->Produtos->delete($produto)) {
            $this->Flash->success(__('O produto foi excluído com sucesso.'));
        } else {
            $this->Flash->error(__('O produto não pode ser excluído. Tente novamente mais tarde.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
