<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
use frontend\models\User;
use HtmlAcademy\Models\TaskStatus;
use HtmlAcademy\Models\UserRole;

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

    <h1>Мои задания<?=($currentStatus !== null) ? ' - '.TaskStatus::getNamePlural($currentStatus) : '';?> (<?=count($tasks);?>)</h1>

        <?php foreach ($tasks as $task): ?>
            <div class="new-task__card">
                <div class="new-task__title">
                    <a href="<?=Url::to(['/task/'.$task->id]);?>" class="link-regular"><h2><?=$task->name;?></h2></a>
                    <a class="new-task__type link-regular" href="<?=Url::to(['/tasks/category/'.$task->category->id]);?>"><p><?=$task->category->name;?></p></a>
                </div>
                <div class="task-status  task-status__<?=TaskStatus::getClass($task->status);?>"><?=TaskStatus::getName($task->status);?></div>
                <p class="new-task__description"><?=$task->description;?></p>
                <?php $user = ($role === UserRole::CUSTOMER) ? $task->contractor : $task->customer; ?>
                <?php if (isset($user)): ?>
                <div class="feedback-card__top ">
                    <a href="<?=Url::to(['/user/'.$user->id]);?>"><img src="<?=User::getAvatar($user->id);?>" width="36" height="36"></a>
                    <div class="feedback-card__top--name my-list__bottom">
                        <p class="link-name"><a <?=($role === UserRole::CUSTOMER) ? 'href="'.Url::to(['/user/'.$user->id]).'"' : '' ;?> class="link-regular"><?=$user->name;?></a></p>
                        <?php $new_messages_count = $task->newMessagesCount(); ?>
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
        <?php endforeach; ?>

    </div>
</section>
