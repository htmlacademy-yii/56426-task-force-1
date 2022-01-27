<?php

/* @var $this yii\web\View */

use yii\widgets\ActiveForm;

$this->title = 'Регистрация аккаунта - TaskForce';

?>

<section class="registration__user">
    <h1>Регистрация аккаунта</h1>
    <div class="registration-wrapper">

        <?php $form = ActiveForm::begin([
            'id' => 'user-signup-form',
            'enableClientValidation' => false,
            'options' => [
                'class' => 'registration__user-form form-create',
                'name' => $model->formName()
            ],
            'fieldConfig' => [
                'options' => [
                    'tag' => false
                ]
            ]
        ]); ?>

            <?=$form->field($model, 'email', ['template' => "{label}\n{input}\n{hint}\n{error}"])
                ->label(null, ['for' => 'email'])
                ->input('textarea', ['class' => 'input textarea', 'rows' => '1', 'id' => 'email'])
                ->hint(null, ['tag' => 'span', 'class' => 'input-hint'])
                ->error(['tag' => 'span', 'class' => 'input-error']);?>

            <?=$form->field($model, 'name', ['template' => "{label}\n{input}\n{hint}\n{error}"])
                ->label(null, ['for' => 'name'])
                ->input('textarea', ['class' => 'input textarea', 'rows' => '1', 'id' => 'name'])
                ->hint(null, ['tag' => 'span', 'class' => 'input-hint'])
                ->error(['tag' => 'span', 'class' => 'input-error']);?>

            <?=$form->field($model, 'city', ['template' => "{label}\n{input}\n{hint}\n{error}"])
                ->label(null, ['for' => 'city'])
                ->dropDownList($cities, ['class' => 'multiple-select input town-select registration-town', 'size' => '1', 'id' => 'city'])
                ->hint(null, ['tag' => 'span', 'class' => 'input-hint'])
                ->error(['tag' => 'span', 'class' => 'input-error']);?>

            <?=$form->field($model, 'password', ['template' => "{label}\n{input}\n{hint}\n{error}"])
                ->label(null, ['for' => 'password'])
                ->input('password', ['class' => 'input textarea', 'rows' => '1', 'id' => 'password'])
                ->hint(null, ['tag' => 'span', 'class' => 'input-hint'])
                ->error(['tag' => 'span', 'class' => 'input-error']);?>

            <button class="button button__registration" type="submit">Cоздать аккаунт</button>

        <?php ActiveForm::end(); ?>

    </div>
</section>
