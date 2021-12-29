<?php

use yii\helpers\Url;
use yii\helpers\Html;

?>

<div class="new-task__card">
    <div class="new-task__title">
        <a href="<?=Url::to(['view', 'id' => $model->id]);?>" class="link-regular"><h2><?=Html::encode($model->name);?></h2></a>
        <a class="new-task__type link-regular" href="<?=Url::to(['/tasks/category/'.$model->category->id]);?>"><p><?= $model->category->name; ?></p></a>
    </div>
    <div class="new-task__icon new-task__icon--<?= $model->category->icon; ?>"></div>
    <p class="new-task__description"><?=Html::encode($model->description);?></p>
    <b class="new-task__price new-task__price--<?= $model->category->icon; ?>"><?= $model->budget; ?><b> ₽</b></b>
    <p class="new-task__place"><?= ($model->address) ? $model->address : "Удаленная работа"; ?></p>
    <span class="new-task__time"><?= Yii::$app->formatter->asRelativeTime($model->created_at); ?></span>
</div>
