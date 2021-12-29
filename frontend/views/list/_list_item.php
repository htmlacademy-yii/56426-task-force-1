<?php

use yii\helpers\Url;
use yii\helpers\Html;
use frontend\models\User;
use HtmlAcademy\Models\TaskStatus;
use HtmlAcademy\Models\UserRole;

?>

<div class="new-task__card">
    <div class="new-task__title">
        <a href="<?=Url::to(['/task/'.$model->id]);?>" class="link-regular"><h2><?=Html::encode($model->name);?></h2></a>
        <a class="new-task__type link-regular" href="<?=Url::to(['/tasks/category/'.$model->category->id]);?>"><p><?=$model->category->name;?></p></a>
    </div>
    <div class="task-status  task-status__<?=TaskStatus::getClass($model->status);?>"><?=TaskStatus::getName($model->status);?></div>
    <p class="new-task__description"><?=Html::encode($model->description);?></p>
    <?php $user = ($role === UserRole::CUSTOMER) ? $model->contractor : $model->customer; ?>
    <?php if (isset($user)): ?>
    <div class="feedback-card__top ">
        <a href="<?=Url::to(['/user/'.$user->id]);?>"><img src="<?=User::getAvatar($user->id);?>" width="36" height="36"></a>
        <div class="feedback-card__top--name my-list__bottom">
            <p class="link-name"><a <?=($role === UserRole::CUSTOMER) ? 'href="'.Url::to(['/user/'.$user->id]).'"' : '' ;?> class="link-regular"><?=Html::encode($user->name);?></a></p>
            <?php $new_messages_count = $model->newMessagesCount(); ?>
            <?php if ($new_messages_count > 0): ?>
                <a href="#" class="my-list__bottom-chat  my-list__bottom-chat--new"><b><?=$new_messages_count;?></b></a>
            <?php else: ?>
                <a href="#" class="my-list__bottom-chat"><b></b></a>
            <?php endif; ?>
            <?=$user->stars();?>
            <b><?=sprintf("%0.2f", $user->rating());?></b>
        </div>
    </div>
    <?php endif; ?>
</div>
