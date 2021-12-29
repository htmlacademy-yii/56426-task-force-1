<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;

$this->title = 'Список исполнителей - TaskForce';

if ($pages->totalCount == 0) {
    $pagesText = "Список пустой";
} else {
    $startPosition = $pages->offset + 1;
    $endPosition = $pages->offset + $pages->pageSize;
    $endPosition = ($endPosition > $pages->totalCount) ? $pages->totalCount : $endPosition;
    $pagesText = "Записи ".$startPosition." - ".$endPosition." из ".$pages->totalCount;
}

?>

<section class="new-task">
    <div class="new-task__wrapper">
        <div>
            <h1>Исполнители</h1>
            <div class="new-task__pages-text"><?=$pagesText;?></div>
        </div>
        <div class="new-task__clear"></div>
        <div class="user__search-link">
            <p>Сортировать по:</p>
            <ul class="user__search-list">
            <?php foreach($sortingRules as $sortId => $sortName): ?>
                <li class="user__search-item<?=($sortId === $sort) ? '  user__search-item--current' : '';?>">
                    <a href="<?=Url::to(['/users/sort/'.$sortId]);?>" class="link-regular"><?=$sortName;?></a>
                </li>
            <?php endforeach; ?>
            </ul>
        </div>
        <?=ListView::widget([
            'dataProvider' => $users,
            'options' => ['tag' => false],
            'layout' => "{items}\n{pager}",
            'itemView' => '_list_item',
            'itemOptions' => ['tag' => false],
            'pager' => ['options' => ['class' => 'pagination__hidden']],
            'emptyText' => false
        ]);?>
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

<section  class="search-task">
    <div class="search-task__wrapper">

        <?php $form = ActiveForm::begin([
            'id' => 'search-task-form',
            'options' => [
                'class' => 'search-task__form',
                'name' => $model->formName()
            ],
            'action' => ['users/index'],
            'fieldConfig' => [
                'options' => [
                    'tag' => false
                ]
            ]
        ]); ?>

            <fieldset class="search-task__categories  search-task__filter">
                <legend>Категории</legend>
                <?php
                echo $form->field($model, 'skills')->checkboxList(
                    $model->skillsData,
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
