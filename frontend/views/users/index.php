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
        <?php if(count($user->skills) > 0): ?>
        <div class="content-view__feedback-card user__search-wrapper">
            <div class="feedback-card__top">
                <div class="user__search-icon">
                    <a href="#"><img src="./img/user-man.jpg" width="65" height="65"></a>
                    <span>6 заданий</span>
                    <span>3 отзывов</span>
                </div>
                <div class="feedback-card__top--name user__search-card">
                    <p class="link-name"><a href="#" class="link-regular"><?=$user->name; ?></a></p>
                    <span></span><span></span><span></span><span></span><span class="star-disabled"></span>
                    <b>4.25</b>
                    <p class="user__search-content"><?=$user->profile->about; ?></p>
                </div>
                <span class="new-task__time">Был на сайте час назад</span>
            </div>
            <div class="link-specialization user__search-link--bottom">
            <?php foreach($user->skills as $skill): ?>
                <a href="#" class="link-regular"><?=$skill->name; ?></a>
            <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    <?php endforeach; ?>
</section>

<section  class="search-task">
    <div class="search-task__wrapper">

        <?php $form = ActiveForm::begin([
            'id' => 'search-task-form',
            'options' => [
                'class' => 'search-task__form'
            ],
            'fieldConfig' => [
                'options' => [
                    'tag' => false
                ]
            ]
        ]); ?>

            <fieldset class="search-task__categories">
                <legend>Категории</legend>
                <?php foreach ($model->skill as $id => $name): ?>
                    <?=$form->field($model, 'skill[]', ['template' => "{label}\n{input}"])->checkbox([
                        'class' => 'visually-hidden checkbox__input',
                        'id' => $id,
                        'name' => 'skill[]',
                        'tag' => false,
                    ], false)->label(false); ?>
                    <label for="<?=$id;?>"><?=$name;?></label>
                <?php endforeach; ?>
            </fieldset>

            <fieldset class="search-task__categories">
                <legend>Дополнительно</legend>

                <?=$form->field($model, 'free', ['template' => "{label}\n{input}"])->checkbox([
                    'class' => 'visually-hidden checkbox__input',
                    'id' => 'free',
                    'name' => 'free',
                    'tag' => false,
                ], false)->label(false); ?>
                <label for="free">Сейчас свободен</label>

                <?=$form->field($model, 'online', ['template' => "{label}\n{input}"])->checkbox([
                    'class' => 'visually-hidden checkbox__input',
                    'id' => 'online',
                    'name' => 'online',
                    'tag' => false,
                ], false)->label(false); ?>
                <label for="online">Сейчас онлайн</label>

                <?=$form->field($model, 'feedback', ['template' => "{label}\n{input}"])->checkbox([
                    'class' => 'visually-hidden checkbox__input',
                    'id' => 'feedback',
                    'name' => 'feedback',
                    'tag' => false,
                ], false)->label(false); ?>
                <label for="feedback">Есть отзывы</label>

                <?=$form->field($model, 'favorite', ['template' => "{label}\n{input}"])->checkbox([
                    'class' => 'visually-hidden checkbox__input',
                    'id' => 'favorite',
                    'name' => 'favorite',
                    'tag' => false,
                ], false)->label(false); ?>
                <label for="favorite">В избранном</label>

            </fieldset>

            <label class="search-task__name" for="search">Поиск по имени</label>
            <?php $field = new ActiveField([
                'model' => $model,
                'template' => "{input}\n{error}",
                'attribute' => 'search',
                'form' => $form
            ]);
            $field->textInput([
                'class' => 'input-middle input',
                'id' => 'search',
                'name' => 'search'
            ]); ?>
            <?=$field->render(); ?>

            <button class="button" type="submit">Искать</button>

        <?php ActiveForm::end(); ?>

    </div>
</section>
