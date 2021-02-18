<?php

/* @var $this yii\web\View */

use Yii;
use yii\helpers\Url;
use HtmlAcademy\Models\TaskStatus;
use HtmlAcademy\Models\ActionAccept;
use HtmlAcademy\Models\ActionReject;
use HtmlAcademy\Models\ActionCancel;
use HtmlAcademy\Models\ActionComplete;
use HtmlAcademy\Models\AvailableActions;

$this->title = 'Задание - TaskForce';

?>

<section class="content-view">
    <div class="content-view__card">
        <div class="content-view__card-wrapper">
            <div class="content-view__header">
                <div class="content-view__headline">
                    <h1><?=$task->name;?></h1>
                    <span>
                        Размещено в категории
                        <a href="#" class="link-regular"><?=$task->category->name;?></a>
                        <?= Yii::$app->formatter->asRelativeTime($task->dt_add); ?>
                    </span>
                </div>
                <b class="new-task__price new-task__price--<?=$task->category->icon;?> content-view-price"><?=$task->budget;?><b> ₽</b></b>
                <div class="new-task__icon new-task__icon--<?=$task->category->icon;?> content-view-icon"></div>
            </div>
            <div class="content-view__description">
                <h3 class="content-view__h3">Общее описание</h3>
                <p><?=$task->description;?></p>
            </div>
            <div class="content-view__attach">
                <?php if ($task->files): ?>
                    <h3 class="content-view__h3">Вложения</h3>
                    <?php foreach ($task->files as $file): ?>
                        <a href="#"><?=$file->original_name;?></a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="content-view__location">
                <h3 class="content-view__h3">Расположение</h3>
                <div class="content-view__location-wrapper">
                    <div class="content-view__map">
                        <a href="#">
                            <div id="task-location-map" style="width: 361px; height: 292px; background-color: lightgray;"></div>
                        </a>
                    </div>
                    <div class="content-view__address">
                    <?php if (empty($task->address)): ?>
                        <span>Удаленная работа</span>
                    <?php else: ?>
                        <span class="address__town"><?=explode(', ', $task->address)[0];?></span><br>
                        <span><?=implode(', ', array_slice(explode(', ', $task->address), 1));?></span>
                        <p></p>
                    <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-view__action-buttons">
            <?php foreach (AvailableActions::getActions($task) as $action): ?>
                <?php if ($action === ActionAccept::class): ?>
                    <button class="button button__big-color response-button open-modal" type="button" data-for="response-form">Откликнуться</button>
                <?php endif; ?>
                <?php if ($action === ActionReject::class): ?>
                    <button class="button button__big-color refusal-button open-modal" type="button" data-for="refuse-form">Отказаться</button>
                <?php endif; ?>
                <?php if ($action === ActionCancel::class): ?>
                    <button class="button button__big-color refusal-button open-modal" type="button" data-for="cancel-form">Отменить</button>
                <?php endif; ?>
                <?php if ($action === ActionComplete::class): ?>
                    <button class="button button__big-color request-button open-modal" type="button" data-for="complete-form">Завершить</button>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="content-view__feedback">
        <?php if ($replies): ?>
            <h2>Отклики <span>(<?=count($replies);?>)</span></h2>
            <div class="content-view__feedback-wrapper">
                <?php foreach ($replies as $reply): ?>
                <div class="content-view__feedback-card">
                    <div class="feedback-card__top">
                        <a href="#"><img src="/img/man-blond.jpg" width="55" height="55"></a>
                        <div class="feedback-card__top--name">
                            <p><a href="<?=Url::to(['users/view', 'id' => $reply->contractor->id]);?>" class="link-regular"><?=$reply->contractor->name;?></a></p>
                            <?=$reply->contractor->stars();?>
                            <b><?=sprintf("%0.2f", $reply->contractor->rating());?></b>
                        </div>
                        <span class="new-task__time"><?= Yii::$app->formatter->asRelativeTime($reply->dt_add); ?></span>
                    </div>
                    <div class="feedback-card__content">
                        <p><?=$reply->comment;?></p>
                        <span><?= ($reply->price) ? $reply->price : $reply->task->budget; ?> ₽</span>
                    </div>
                    <?php if ($reply->active && $task->status === TaskStatus::NEW_TASK && $task->customer_id === Yii::$app->user->getId()): ?>
                    <div class="feedback-card__actions">
                        <a href="<?=Url::to(['tasks/apply', 'task' => $task->id, 'user' => $reply->contractor->id]);?>" class="button__small-color request-button button" type="button">Подтвердить</a>
                        <a href="<?=Url::to(['tasks/refuse', 'task' => $task->id, 'reply' => $reply->id]);?>" class="button__small-color refusal-button button" type="button">Отказать</a>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<section class="connect-desk">
    <div class="connect-desk__profile-mini">
        <div class="profile-mini__wrapper">
            <h3>Заказчик</h3>
            <div class="profile-mini__top">
                <img src="/img/man-brune.jpg" width="62" height="62" alt="Аватар заказчика">
                <div class="profile-mini__name five-stars__rate">
                    <p><?=$customer->name;?></p>
                </div>
            </div>
            <p class="info-customer">
                <span><?=count($customer->customerTasks);?> заданий</span>
                <span class="last-"><?=date_diff(date_create($customer->dt_add), date_create())->format("%y лет");?> на сайте</span>
            </p>
            <a href="#" class="link-regular">Смотреть профиль</a>
        </div>
    </div>
    <div id="chat-container">
        <chat class="connect-desk__chat" task="<?=$task->id;?>"></chat>
    </div>
</section>
