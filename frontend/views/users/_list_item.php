<?php

use yii\helpers\Url;
use yii\helpers\Html;
use frontend\models\User;

?>

<div class="content-view__feedback-card user__search-wrapper">
    <div class="feedback-card__top">
        <div class="user__search-icon">
            <a href="<?=Url::to(['view', 'id' => $model->id]);?>"><img src="<?=User::getAvatar($model->id);?>" width="65" height="65"></a>
            <span><?=$model->taskCount();?> заданий</span>
            <span><?=$model->feedbackCount();?> отзывов</span>
        </div>
        <div class="feedback-card__top--name user__search-card">
            <p class="link-name"><a href="<?=Url::to(['view', 'id' => $model->id]);?>" class="link-regular"><?=Html::encode($model->name);?></a></p>
            <?=$model->stars();?>
            <b><?=sprintf("%0.2f", $model->rating());?></b>
            <p class="user__search-content"><?=Html::encode($model->profile->about);?></p>
        </div>
        <span class="new-task__time">Был на сайте <?= Yii::$app->formatter->asRelativeTime($model->profile->last_activity); ?></span>
    </div>
    <div class="link-specialization user__search-link--bottom">
    <?php foreach($model->skills as $skill): ?>
        <a href="<?=Url::to(['/users/skill/'.$skill->id]);?>" class="link-regular"><?=$skill->name;?></a>
    <?php endforeach; ?>
    </div>
</div>
