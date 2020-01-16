<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;

$this->title = 'Список заданий - TaskForce';

?>

<section class="new-task">
    <div class="new-task__wrapper">
        <h1>Новые задания</h1>
        <?php foreach($tasks as $task): ?>
            <div class="new-task__card">
                <div class="new-task__title">
                    <a href="#" class="link-regular"><h2><?=$task->name; ?></h2></a>
                    <a  class="new-task__type link-regular" href="#"><p><?=$task->category->name; ?></p></a>
                </div>
                <div class="new-task__icon new-task__icon--<?=$task->category->icon; ?>"></div>
                <p class="new-task_description"><?=$task->description; ?></p>
                <b class="new-task__price new-task__price--<?=$task->category->icon; ?>"><?=$task->budget; ?><b> ₽</b></b>
                <p class="new-task__place"><?=$task->address; ?></p>
                <span class="new-task__time"><?= Yii::$app->formatter->asRelativeTime($task->dt_add); ?></span>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="new-task__pagination">
        <ul class="new-task__pagination-list">
            <li class="pagination__item"><a href="#"></a></li>
            <li class="pagination__item pagination__item--current">
                <a>1</a></li>
            <li class="pagination__item"><a href="#">2</a></li>
            <li class="pagination__item"><a href="#">3</a></li>
            <li class="pagination__item"><a href="#"></a></li>
        </ul>
    </div>
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
                    'tag' => false,
                ],
            ],
        ]); ?>

            <fieldset class="search-task__categories">
                <legend>Категории</legend>
                    <?= $form->field($model,  'category[]')->checkboxList($model->category, [//->template
                        'tag' => false,
                        'itemOptions' => [

                        ],
                        'item'=>function ($index, $label, $name, $checked, $value){
                            return Html::checkbox($name, $checked, [
                                'value' => $value,
                                'label' => '<label for="' . $value . '">' . $label . '</label>',
                                'class' => 'visually-hidden checkbox__input',
                                'id' => $value
                            ]);
                        },
                    ])->label(false);
                    ?>
            </fieldset>

            <fieldset class="search-task__categories">
                <legend>Дополнительно</legend>
                <?=$form->field($model,  'city', ['template' => "{label}\n{input}"])->checkbox([
                    'class' => 'visually-hidden checkbox__input',
                    'id' => 'city',
                    'name' => 'city',
                    'tag' => false,
                ], false)->label(false); ?>

                <label for="city">Мой город</label>
                <?= $form->field($model,  'location', ['template' => "{label}\n{input}"])->checkbox([
                    'class' => 'visually-hidden checkbox__input',
                    'id' => 'location',
                    'name' => 'location'
                ], false)->label(false); ?>
                <label for="location">Удаленная работа</label>
            </fieldset>

            <label class="search-task__name" for="period">Период</label>
            <?=$form->field($model,  'period', ['template' => "{label}\n{input}"])
                ->dropDownList(
                    ['day' => 'За день', 'week' => 'За неделю', 'month' => 'За месяц'],
                    [
                        'class' => 'multiple-select input',
                        'id' => 'period',
                        'size' => '1',
                        'name' => 'time[]'
                    ]
                )->label(false); ?>
            <label class="search-task__name" for="search">Поиск по названию</label>
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
