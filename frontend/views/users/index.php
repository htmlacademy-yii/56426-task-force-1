<?php

/* @var $this yii\web\View */

use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;

$this->title = 'Список исполнителей - TaskForce';

?>

<section class="user__search">
    <div class="user__search-link">
        <p>Сортировать по:</p>
        <ul class="user__search-list">
            <li class="user__search-item user__search-item--current">
                <a href="#" class="link-regular">Рейтингу</a>
            </li>
            <li class="user__search-item">
                <a href="#" class="link-regular">Числу заказов</a>
            </li>
            <li class="user__search-item">
                <a href="#" class="link-regular">Популярности</a>
            </li>
        </ul>
    </div>
    <?php foreach($users as $user): ?>
        <?php
            $tasks = count($user->contractorTasks);
            $feedbacks = count($user->feedbacks);
            $rating = 0;
            if($feedbacks > 0) {
                $rating = array_sum(array_column($user->feedbacks, 'rating')) / $feedbacks;
            }
        ?>
        <div class="content-view__feedback-card user__search-wrapper">
            <div class="feedback-card__top">
                <div class="user__search-icon">
                    <a href="#"><img src="./img/user-man.jpg" width="65" height="65"></a>
                    <span><?=$tasks;?> заданий</span>
                    <span><?=$feedbacks;?> отзывов</span>
                </div>
                <div class="feedback-card__top--name user__search-card">
                    <p class="link-name"><a href="#" class="link-regular"><?=$user->name;?></a></p>
                    <?php
                        $stars = '';
                        for($star = 1; $star <= 5; $star++) {
                            if($rating >= $star) {
                                $stars .= '<span></span>';
                            } else {
                                $stars .= '<span class="star-disabled"></span>';
                            }
                        }
                    ?>
                    <?=$stars;?>
                    <b><?=sprintf("%0.2f", $rating);?></b>
                    <p class="user__search-content"><?=$user->profile->about;?></p>
                </div>
                <span class="new-task__time">Был на сайте час назад</span>
            </div>
            <div class="link-specialization user__search-link--bottom">
            <?php foreach($user->skills as $skill): ?>
                <a href="#" class="link-regular"><?=$skill->name;?></a>
            <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</section>

<section  class="search-task">
    <div class="search-task__wrapper">

        <?php $form = ActiveForm::begin([
            'id' => 'search-task-form',
            'options' => [
                'class' => 'search-task__form',
                'name' => $model->formName()
            ],
            'fieldConfig' => [
                'options' => [
                    'tag' => false
                ]
            ]
        ]); ?>

            <fieldset class="search-task__categories">
                <legend>Категории</legend>
                <?php foreach ($model->attributeLabels()['skill'] as $id => $name): ?>
                    <?php $options = [
                        'class' => 'visually-hidden checkbox__input',
                        'id' => $id,
                        'name' => 'skill['.$id.']',
                        'tag' => false
                    ];
                    if ($model->skill[$id]) {
                        $options['checked'] = "";
                    } ?>
                    <?=$form->field($model, 'skill[]', ['template' => "{label}\n{input}"])->checkbox($options, false)->label(false); ?>
                    <label for="<?=$id;?>"><?=$name;?></label>
                <?php endforeach; ?>
            </fieldset>

            <fieldset class="search-task__categories">
                <legend>Дополнительно</legend>
                <?php $attributes = ['free', 'online', 'feedback', 'favorite']; ?>
                <?php foreach ($attributes as $attribute): ?>
                    <?php $options = [
                        'class' => 'visually-hidden checkbox__input',
                        'id' => $attribute,
                        'name' => $attribute,
                        'tag' => false
                    ]; ?>
                    <?=$form->field($model, $attribute, ['template' => "{label}\n{input}"])->checkbox($options, false)->label(false); ?>
                    <label for="<?=$attribute;?>"><?=$model->attributeLabels()[$attribute];?></label>
                <?php endforeach; ?>
            </fieldset>

            <label class="search-task__name" for="search"><?=$model->attributeLabels()['search'];?></label>
            <?php $options = [
                'class' => 'input-middle input',
                'id' => 'search',
                'name' => 'search',
                'tag' => false
            ]; ?>
            <?=$form->field($model, 'search', ['template' => "{label}\n{input}"])->input('text', $options)->label(false); ?>

            <button class="button" type="submit">Искать</button>

        <?php ActiveForm::end(); ?>

    </div>
</section>
