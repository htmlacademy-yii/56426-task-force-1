<?php

/* @var $this yii\web\View */

use frontend\models\Category;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveField;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;

$this->title = 'Список заданий - TaskForce';

if ($pages->totalCount == 0) {
    $pages_text = "Список пустой";
} else {
    $startPosition = $pages->offset + 1;
    $endPosition = $pages->offset + $pages->pageSize;
    $endPosition = ($endPosition > $pages->totalCount) ? $pages->totalCount : $endPosition;
    $pages_text = "Записи ".$startPosition." - ".$endPosition." из ".$pages->totalCount;
}

$cityFilterText = '';
if (!is_null($this->context->cityFilter)) {
    $cityFilterText = ' (в городе '.$this->context->cityFilter->name.')';
}

?>

<section class="new-task">
    <div class="new-task__wrapper">
        <div>
            <h1>Новые задания <span class="new-task__city-filter"><?=$cityFilterText;?></span></h1>
            <div class="new-task__pages-text"><?=$pages_text;?></div>
        </div>
        <div class="new-task__clear"></div>
        <?php foreach ($tasks as $task): ?>
            <div class="new-task__card">
                <div class="new-task__title">
                    <a href="<?=Url::to(['view', 'id' => $task->id]);?>" class="link-regular"><h2><?= $task->name; ?></h2></a>
                    <a class="new-task__type link-regular" href="#"><p><?= $task->category->name; ?></p></a>
                </div>
                <div class="new-task__icon new-task__icon--<?= $task->category->icon; ?>"></div>
                <p class="new-task__description"><?= $task->description; ?></p>
                <b class="new-task__price new-task__price--<?= $task->category->icon; ?>"><?= $task->budget; ?><b> ₽</b></b>
                <p class="new-task__place"><?= ($task->address) ? $task->address : "Удаленная работа"; ?></p>
                <span class="new-task__time"><?= Yii::$app->formatter->asRelativeTime($task->created_at); ?></span>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="new-task__pagination">
        <?=LinkPager::widget([
            'pagination' => $pages,
            'pageCssClass' => 'pagination__item',
            'prevPageLabel' => '',
            'prevPageCssClass' => 'pagination__item',
            'nextPageLabel' => '',
            'nextPageCssClass' => 'pagination__item',
            'options' => ['class' => 'new-task__pagination-list'],
            'activePageCssClass' => 'pagination__item--current'
        ]);?>
    </div>
</section>

<section class="search-task">
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

            <fieldset class="search-task__categories  search-task__filter">
                <legend>Категории</legend>
                <?php
                echo $form->field($model, 'categories')->checkboxList(
                    Category::find()->asArray()->all(),
                    [
                        'tag' => false,
                        'item' => function ($index, $label, $name, $checked, $value) {
                            return Html::checkbox($name, $checked, [
                                'value' => $value,
                                'label' => '<label for="'.$label['id'].'">'.$label['name'].'</label>',
                                'labelOptions' => [
                                    'class' => 'control-label'
                                ],
                                'class' => 'visually-hidden checkbox__input',
                                'id' => $label['id']
                            ]);
                        }
                    ])->label(false);
                ?>
            </fieldset>

            <fieldset class="search-task__categories  search-task__filter">
                <legend>Дополнительно</legend>
                <?php foreach ($model->extraFields() as $attribute): ?>
                    <?php $options = [
                        'class' => 'visually-hidden checkbox__input',
                        'id' => $attribute,
                        'tag' => false,
                        'value' => 1
                    ]; ?>
                    <?=$form->field($model, $attribute, ['template' => "{label}\n{input}"])->checkbox($options, false)->label(false); ?>
                    <label for="<?=$attribute;?>"><?=$model->attributeLabels()[$attribute];?></label>
                <?php endforeach; ?>
            </fieldset>

            <label class="search-task__name" for="period">Период</label>
            <?=$form->field($model,  'period', ['template' => "{label}\n{input}"])
                ->dropDownList(
                    ['all' => 'За все время', 'day' => 'За день', 'week' => 'За неделю', 'month' => 'За месяц'],
                    [
                        'class' => 'multiple-select input',
                        'id' => 'period',
                        'size' => '1'
                    ]
                )->label(false); ?>

            <label class="search-task__name" for="search"><?=$model->attributeLabels()['search'];?></label>
            <?php $options = [
                'class' => 'input-middle input',
                'id' => 'search',
                'tag' => false
            ]; ?>
            <?=$form->field($model, 'search', ['template' => "{label}\n{input}"])->input('text', $options)->label(false); ?>

            <button class="button" type="submit">Искать</button>

        <?php ActiveForm::end(); ?>

    </div>
</section>
