<?php

/* @var $this yii\web\View */

$this->title = 'Исполнитель - TaskForce';

use yii\helpers\Url;
use frontend\models\User;

?>

<section class="content-view">
    <div class="user__card-wrapper">
        <div class="user__card">
            <img src="<?=User::getAvatar($user->id);?>" width="120" height="120" alt="Аватар пользователя">
                <div class="content-view__headline">
                    <h1><?=$user->name;?></h1>
                    <p>Россия, <?=$user->profile->city->name;?>, <?=date_diff(date_create(), date_create($user->profile->birthday))->format("%y лет");?></p>
                    <div class="profile-mini__name five-stars__rate">
                        <?=$user->stars();?>
                        <b><?=sprintf("%0.2f", $user->rating());?></b>
                    </div>
                    <b class="done-task">Выполнил <?=$user->taskCount();?> заказов</b>
                    <b class="done-review">Получил <?=$user->feedbackCount();?> отзывов</b>
                </div>
            <div class="content-view__headline user__card-bookmark user__card-bookmark--current">
                <span>Был на сайте <?= Yii::$app->formatter->asRelativeTime($user->profile->last_activity); ?></span>
                <a href="#"><b></b></a>
            </div>
        </div>
        <div class="content-view__description">
            <p><?=$user->profile->about;?></p>
        </div>
        <div class="user__card-general-information">
            <div class="user__card-info">
                <h3 class="content-view__h3">Специализации</h3>
                <div class="link-specialization">
                <?php foreach($user->skills as $skill): ?>
                    <a href="#" class="link-regular"><?=$skill->name;?></a>
                <?php endforeach; ?>
                </div>
                <h3 class="content-view__h3">Контакты</h3>
                <div class="user__card-link">
                    <a class="user__card-link--tel link-regular" href="#"><?=$user->profile->phone;?></a>
                    <a class="user__card-link--email link-regular" href="#"><?=$user->email;?></a>
                    <a class="user__card-link--skype link-regular" href="#"><?=$user->profile->skype;?></a>
                </div>
            </div>
            <div class="user__card-photo">
                <?php if ($user->photos): ?>
                    <h3 class="content-view__h3">Фото работ</h3>
                    <?php foreach ($user->photos as $photo): ?>
                        <a href="<?=Url::to([$photo->file]);?>"><img src="<?=Url::to([$photo->file]);?>" width="86" height="86" alt="<?=$photo->name;?>"></a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php if ($feedbacks): ?>
    <div class="content-view__feedback">
        <h2>Отзывы <span>(<?=count($feedbacks);?>)</span></h2>
        <div class="content-view__feedback-wrapper reviews-wrapper">
        <?php foreach($feedbacks as $feedback): ?>
            <div class="feedback-card__reviews">
                <p class="link-task link">Задание <a href="<?=Url::to(['/task/'.$feedback->task->id]);?>" class="link-regular">«<?=$feedback->task->name;?>»</a></p>
                <div class="card__review">
                    <img src="<?=User::getAvatar($feedback->task->customer->id);?>" width="55" height="54">
                    <div class="feedback-card__reviews-content">
                        <p class="link-name link"><?=$feedback->task->customer->name;?></p>
                        <p class="review-text"><?=$feedback->description;?></p>
                    </div>
                    <div class="card__review-rate">
                        <p class="<?=$feedback->ratingClass();?> big-rate"><?=$feedback->rating;?><span></span></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</section>

<section class="connect-desk">
    <div class="connect-desk__chat"></div>
</section>
