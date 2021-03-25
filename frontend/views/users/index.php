<?php

/* @var $this yii\web\View */

use frontend\models\Skill;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;
use yii\widgets\LinkPager;

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
            <?php foreach($this->context->sortingRules as $sortId => $sortName): ?>
                <li class="user__search-item<?=($sortId === $sort) ? '  user__search-item--current' : '';?>">
                    <a href="<?=Url::to(['/users/sort/'.$sortId]);?>" class="link-regular"><?=$sortName;?></a>
                </li>
            <?php endforeach; ?>
            </ul>
        </div>

        <?php foreach($users as $user): ?>
            <div class="content-view__feedback-card user__search-wrapper">
                <div class="feedback-card__top">
                    <div class="user__search-icon">
                        <a href="#"><img src="/img/man-blond.jpg" width="65" height="65"></a>
                        <span><?=$user->taskCount();?> заданий</span>
                        <span><?=$user->feedbackCount();?> отзывов</span>
                    </div>
                    <div class="feedback-card__top--name user__search-card">
                        <p class="link-name"><a href="<?=Url::to(['view', 'id' => $user->id]);?>" class="link-regular"><?=$user->name;?></a></p>
                        <?=$user->stars();?>
                        <b><?=sprintf("%0.2f", $user->rating());?></b>
                        <p class="user__search-content"><?=$user->profile->about;?></p>
                    </div>
                    <span class="new-task__time">Был на сайте <?= Yii::$app->formatter->asRelativeTime($user->profile->last_activity); ?></span>
                </div>
                <div class="link-specialization user__search-link--bottom">
                <?php foreach($user->skills as $skill): ?>
                    <a href="#" class="link-regular"><?=$skill->name;?></a>
                <?php endforeach; ?>
                </div>
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

            <fieldset class="search-task__categories  search-task__filter">
                <legend>Категории</legend>
                <?php
                echo $form->field($model, 'skills')->checkboxList(
                    Skill::find()->asArray()->all(),
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
