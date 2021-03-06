<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UserPapel $userPapel
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List User Papeis'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Papeis'), ['controller' => 'Papeis', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Papel'), ['controller' => 'Papeis', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="userPapeis form large-9 medium-8 columns content">
    <?= $this->Form->create($userPapel) ?>
    <fieldset>
        <legend><?= __('Add User Papel') ?></legend>
        <?php
            echo $this->Form->control('user_id');
            echo $this->Form->control('papel_id', ['options' => $papeis]);
            echo $this->Form->control('empresa_id');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
