<?php

/* @var $this yii\web\View */

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
            <li class="pagination__item pagination__item--current"><a>1</a></li>
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
                <?php foreach ($model->attributeLabels()['category'] as $id => $name): ?>
                    <?php $options = [
                        'class' => 'visually-hidden checkbox__input',
                        'id' => $id,
                        'name' => 'category['.$id.']',
                        'tag' => false
                    ];
                    if ($model->category[$id]) {
                        $options['checked'] = "";
                    } ?>
                    <?=$form->field($model, 'category[]', ['template' => "{label}\n{input}"])->checkbox($options, false)->label(false); ?>
                    <label for="<?=$id;?>"><?=$name;?></label>
                <?php endforeach; ?>
            </fieldset>

            <fieldset class="search-task__categories">
                <legend>Дополнительно</legend>
                <?php $attributes = ['city', 'location']; ?>
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

            <label class="search-task__name" for="period"><?=$model->attributeLabels()['period'];?></label>
            <?php $items = [
                'all'   => 'За все время',
                'day'   => 'За день',
                'week'  => 'За неделю',
                'month' => 'За месяц'
            ];
            $options = [
                'class' => 'multiple-select input',
                'id' => 'period',
                'size' => '1',
                'name' => 'time'
            ]; ?>
            <?=$form->field($model,  'period', ['template' => "{label}\n{input}"])->dropDownList($items, $options)->label(false); ?>

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
