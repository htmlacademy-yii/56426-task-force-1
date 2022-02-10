<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Создать задание - TaskForce';

?>

<section class="create__task">

    <h1>Публикация нового задания</h1>

    <div class="create__task-main">

        <?php $form = ActiveForm::begin([
            'id' => 'task-form',
            'enableClientValidation' => false,
            'options' => [
                'class' => 'create__task-form form-create',
                'enctype' => 'multipart/form-data',
                'name' => $model->formName()
            ],
            'fieldConfig' => [
                'options' => [
                    'tag' => false
                ]
            ]
        ]); ?>

            <?=$form->field($model, 'name', ['template' => "{label}\n{input}\n{hint}\n{error}"])
                ->label(null, ['for' => 'name'])
                ->input('textarea', ['class' => 'input textarea', 'rows' => '1', 'id' => 'name'])
                ->hint(null, ['tag' => 'span', 'class' => 'input-hint'])
                ->error(['tag' => 'span', 'class' => 'input-error']);?>

            <?=$form->field($model, 'description', ['template' => "{label}\n{input}\n{hint}\n{error}"])
                ->label(null, ['for' => 'description'])
                ->input('textarea', ['class' => 'input textarea', 'rows' => '7', 'id' => 'description'])
                ->hint(null, ['tag' => 'span', 'class' => 'input-hint'])
                ->error(['tag' => 'span', 'class' => 'input-error']);?>

            <?=$form->field($model, 'category', ['template' => "{label}\n{input}\n{hint}\n{error}"])
                ->label(null, ['for' => 'category'])
                ->dropDownList($categories, ['class' => 'multiple-select input multiple-select-big', 'size' => '1', 'id' => 'category'])
                ->hint(null, ['tag' => 'span', 'class' => 'input-hint'])
                ->error(['tag' => 'span', 'class' => 'input-error']);?>

            <?=$form->field($model, 'task_files[]', ['template' => "{label}\n{input}\n{hint}"])
                ->label(null, ['for' => 'task_files'])
                ->fileInput(['class' => 'input-files', 'id' => 'task_files', 'multiple' => true])
                ->hint(null, ['tag' => 'span', 'class' => 'input-hint']);?>

            <?=$form->field($model, 'location', ['template' => "{label}\n{input}\n{hint}"])
                ->label(null, ['for' => 'location'])
                ->input('search', ['class' => 'input-navigation input-middle input', 'id' => 'location'])
                ->hint(null, ['tag' => 'span', 'class' => 'input-hint']);?>

            <div class="create__price-time">
                <div class="create__price-time--wrapper">
                    <?=$form->field($model, 'budget', ['template' => "{label}\n{input}\n{hint}\n{error}"])
                        ->label(null, ['for' => 'budget'])
                        ->input('textarea', ['class' => 'input textarea input-money', 'rows' => '1', 'id' => 'budget'])
                        ->hint(null, ['tag' => 'span', 'class' => 'input-hint'])
                        ->error(['tag' => 'span', 'class' => 'input-error']);?>
                </div>
                <div class="create__price-time--wrapper">
                    <?=$form->field($model, 'expire', ['template' => "{label}\n{input}\n{hint}\n{error}"])
                        ->label(null, ['for' => 'expire'])
                        ->input('date', ['class' => 'input-middle input input-date', 'id' => 'expire'])
                        ->hint(null, ['tag' => 'span', 'class' => 'input-hint'])
                        ->error(['tag' => 'span', 'class' => 'input-error']);?>
                </div>
            </div>

        <?php ActiveForm::end(); ?>

        <div class="create__warnings">
            <div class="warning-item warning-item--advice">
                <h2>Правила хорошего описания</h2>
                <h3>Подробности</h3>
                <p>Друзья, не используйте случайный<br>контент – ни наш, ни чей-либо еще. Заполняйте свои макеты, вайрфреймы, мокапы и прототипы реальным содержимым.</p>
                <h3>Файлы</h3>
                <p>Если загружаете фотографии объекта, то убедитесь, что всё в фокусе, а фото показывает объект со всех ракурсов.</p>
            </div>
            <?php if ($model->hasErrors()): ?>
                <div class="warning-item warning-item--error">
                    <h2>Ошибки заполнения формы</h2>
                    <?php foreach ($model->getErrors() as $attribute => $messages): ?>
                        <h3><?=$model->attributeLabels()[$attribute];?></h3>
                        <p>
                        <?php for ($i = 0; $i < count($messages); $i++): ?>
                            <?=$messages[$i];?>
                            <?=($i < count($messages) - 1) ? '<br>' : '';?>
                        <?php endfor; ?>
                        </p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

    </div>

    <?= Html::submitButton('Опубликовать', ['class' => 'button', 'form' => 'task-form']); ?>

</section>
