<?php

/* @var $this yii\web\View */

use Yii;
use yii\helpers\Url;
use frontend\models\User;
use HtmlAcademy\Tools\Grammar;
use HtmlAcademy\Models\TaskStatus;
use HtmlAcademy\Models\ActionAccept;
use HtmlAcademy\Models\ActionReject;
use HtmlAcademy\Models\ActionCancel;
use HtmlAcademy\Models\ActionComplete;
use HtmlAcademy\Models\AvailableActions;

$this->title = 'Задание - TaskForce';

$customerTasksCount = count($customer->customerTasks);

?>

<section class="content-view">
    <div class="content-view__card">
        <div class="content-view__card-wrapper">
            <div class="content-view__header">
                <div class="content-view__headline">
                    <div class="content-view__title">
                        <h1><?=$task->name;?></h1>
                        <div class="task-status  task-status__<?=TaskStatus::getClass($task->status);?>"><?=TaskStatus::getName($task->status);?></div>
                    </div>
                    <div class="content-view__clear"></div>
                    <span>
                        Размещено в категории
                        <a href="#" class="link-regular"><?=$task->category->name;?></a>
                        <?=Yii::$app->formatter->asRelativeTime($task->created_at);?>
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
                <?php if ($task->attachments): ?>
                    <h3 class="content-view__h3">Вложения</h3>
                    <?php foreach ($task->attachments as $attachment): ?>
                        <a href="<?=Url::to([$attachment->file]);?>"><?=$attachment->name;?></a>
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
                    <?php if (is_null($task->city) && empty($task->address)): ?>
                        <span class="address__town"></span>
                        <span>Удаленная работа</span>
                    <?php elseif (is_null($task->city)): ?>
                        <span class="address__town"><?=explode(', ', $task->address)[0];?></span><br>
                        <span><?=implode(', ', array_slice(explode(', ', $task->address), 1));?></span>
                        <p></p>
                    <?php else: ?>
                        <span class="address__town"><?=$task->city->name;?></span><br>
                        <span><?=$task->address;?></span>
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
            <?php if ($task->contractor_id): ?>
                <h2>Исполнитель</h2>
            <?php else: ?>
                <h2>Отклики <span>(<?=count($replies);?>)</span></h2>
            <?php endif; ?>
            <div class="content-view__feedback-wrapper">
                <?php foreach ($replies as $reply): ?>
                <div class="content-view__feedback-card">
                    <div class="feedback-card__top">
                        <img src="<?=User::getAvatar($reply->contractor->id);?>" width="55" height="55">
                        <div class="feedback-card__top--name">
                            <p><a href="<?=Url::to(['users/view', 'id' => $reply->contractor->id]);?>" class="link-regular"><?=$reply->contractor->name;?></a></p>
                            <?=$reply->contractor->stars();?>
                            <b><?=sprintf("%0.2f", $reply->contractor->rating());?></b>
                        </div>
                        <span class="new-task__time"><?=Yii::$app->formatter->asRelativeTime($reply->created_at);?></span>
                    </div>
                    <div class="feedback-card__content">
                        <p><?=$reply->comment;?></p>
                        <span><?= ($reply->price) ? $reply->price : $reply->task->budget; ?> ₽</span>
                    </div>
                    <?php if ($reply->is_active && $task->status === TaskStatus::NEW_TASK && $task->customer_id === Yii::$app->user->getId()): ?>
                    <div class="feedback-card__actions">
                        <a href="<?=Url::to(['tasks/apply', 'task_id' => $task->id, 'user_id' => $reply->contractor->id]);?>" class="button__small-color request-button button" type="button">Подтвердить</a>
                        <a href="<?=Url::to(['tasks/refuse', 'task_id' => $task->id, 'reply_id' => $reply->id]);?>" class="button__small-color refusal-button button" type="button">Отказать</a>
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
                <img src="<?=User::getAvatar($customer->id);?>" width="62" height="62" alt="Аватар заказчика">
                <div class="profile-mini__name five-stars__rate">
                    <p><?=$customer->name;?></p>
                </div>
            </div>
            <p class="info-customer">
                <span><?=$customerTasksCount;?> задан<?=Grammar::getSuffix($customerTasksCount, '2');?></span>
                <span class="last-"><?=Grammar::getYearsString($customer->created_at);?> на сайте</span>
            </p>
            <a href="#" class="link-regular">Смотреть профиль</a>
        </div>
    </div>
    <?php if (($task->customer_id === Yii::$app->user->getId() && !is_null($task->contractor_id)) || $task->contractor_id === Yii::$app->user->getId()): ?>
        <div id="chat-container">
            <chat class="connect-desk__chat" task="<?=$task->id;?>"></chat>
        </div>
    <?php elseif ($task->customer_id === Yii::$app->user->getId() && is_null($task->contractor_id)): ?>
        <div class="chat-usage-hint">Для работы с чатом необходимо выбрать исполнителя</div>
    <?php elseif ($task->customer_id !== Yii::$app->user->getId()): ?>
        <div class="chat-usage-hint">Для переписки с заказчиком необходимо стать исполнителем</div>
    <?php endif; ?>
</section>
