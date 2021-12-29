<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\widgets\ListView;
use HtmlAcademy\Models\TaskStatus;

$this->title = 'Мои задания - TaskForce';

?>

<section class="menu-toggle">
    <ul class="menu-toggle__list">

        <li class="menu-toggle__item<?=($currentStatus === null) ? '  menu-toggle__item--current' : '';?>">
            <a class="menu-toggle__link" href="<?=Url::to(['/list']);?>">
                <div class="menu-toggle__icon  menu-toggle__icon--all"></div>
                <div class="menu-toggle__name">Все задания</div>
            </a>
        </li>

        <?php foreach (TaskStatus::getAll() as $status): ?>
            <li class="menu-toggle__item<?=($currentStatus === $status) ? '  menu-toggle__item--current' : '';?>">
                <a class="menu-toggle__link" href="<?=Url::to(['/list/'.TaskStatus::getClass($status)]);?>">
                    <div class="menu-toggle__icon  menu-toggle__icon--<?=TaskStatus::getClass($status);?>"></div>
                    <div class="menu-toggle__name"><?=TaskStatus::getNamePlural($status);?></div>
                </a>
            </li>
        <?php endforeach; ?>

    </ul>
</section>

<section class="my-list">
    <div class="my-list__wrapper">

        <h1>Мои задания<?=($currentStatus !== null) ? ' - '.TaskStatus::getNamePlural($currentStatus) : '';?> (<?=$tasks->count;?>)</h1>

        <?=ListView::widget([
            'dataProvider' => $tasks,
            'options' => ['tag' => false],
            'layout' => "{items}",
            'itemView' => '_list_item',
            'itemOptions' => ['tag' => false],
            'viewParams' => ['role' => $role],
            'emptyText' => false
        ]);?>

    </div>
</section>
