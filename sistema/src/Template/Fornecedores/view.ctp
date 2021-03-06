<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Fornecedor $fornecedor
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Fornecedor'), ['action' => 'edit', $fornecedor->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Fornecedor'), ['action' => 'delete', $fornecedor->id], ['confirm' => __('Are you sure you want to delete # {0}?', $fornecedor->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Fornecedores'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Fornecedor'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Fornecedor Situacoes'), ['controller' => 'FornecedorSituacoes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Fornecedor Situacao'), ['controller' => 'FornecedorSituacoes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Pessoas'), ['controller' => 'Pessoas', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Pessoa'), ['controller' => 'Pessoas', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Itens'), ['controller' => 'Itens', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Itens', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="fornecedores view large-9 medium-8 columns content">
    <h3><?= h($fornecedor->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Fornecedor Situacao') ?></th>
            <td><?= $fornecedor->has('fornecedor_situacao') ? $this->Html->link($fornecedor->fornecedor_situacao->id, ['controller' => 'FornecedorSituacoes', 'action' => 'view', $fornecedor->fornecedor_situacao->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Pessoa') ?></th>
            <td><?= $fornecedor->has('pessoa') ? $this->Html->link($fornecedor->pessoa->id, ['controller' => 'Pessoas', 'action' => 'view', $fornecedor->pessoa->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($fornecedor->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Empresa Id') ?></th>
            <td><?= $this->Number->format($fornecedor->empresa_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($fornecedor->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($fornecedor->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Observacao') ?></h4>
        <?= $this->Text->autoParagraph(h($fornecedor->observacao)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Itens') ?></h4>
        <?php if (!empty($fornecedor->itens)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Nota Id') ?></th>
                <th scope="col"><?= __('Fornecedor Id') ?></th>
                <th scope="col"><?= __('Produto Id') ?></th>
                <th scope="col"><?= __('Observacao') ?></th>
                <th scope="col"><?= __('Valor') ?></th>
                <th scope="col"><?= __('Desconto Valor') ?></th>
                <th scope="col"><?= __('Desconto Percentual') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col"><?= __('Empresa Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($fornecedor->itens as $itens): ?>
            <tr>
                <td><?= h($itens->id) ?></td>
                <td><?= h($itens->nota_id) ?></td>
                <td><?= h($itens->fornecedor_id) ?></td>
                <td><?= h($itens->produto_id) ?></td>
                <td><?= h($itens->observacao) ?></td>
                <td><?= h($itens->valor) ?></td>
                <td><?= h($itens->desconto_valor) ?></td>
                <td><?= h($itens->desconto_percentual) ?></td>
                <td><?= h($itens->created) ?></td>
                <td><?= h($itens->modified) ?></td>
                <td><?= h($itens->empresa_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Itens', 'action' => 'view', $itens->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Itens', 'action' => 'edit', $itens->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Itens', 'action' => 'delete', $itens->id], ['confirm' => __('Are you sure you want to delete # {0}?', $itens->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
