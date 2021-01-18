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

            <label for="email"><?=$model->attributeLabels()['email'];?></label>
            <?php $options = [
                'class' => 'input textarea',
                'rows' => '1',
                'id' => 'email',
                'tag' => false
            ]; ?>
            <?=$form->field($model, 'email', ['template' => "{label}\n{input}"])->input('textarea', $options)->label(false);?>
            <span>Введите валидный адрес электронной почты</span>

            <label for="name"><?=$model->attributeLabels()['name'];?></label>
            <?php $options = [
                'class' => 'input textarea',
                'rows' => '1',
                'id' => 'name',
                'tag' => false
            ]; ?>
            <?=$form->field($model, 'name', ['template' => "{label}\n{input}"])->input('textarea', $options)->label(false);?>
            <span>Введите ваше имя и фамилию</span>

            <label for="city"><?=$model->attributeLabels()['city'];?></label>
            <?php $options = [
                'class' => 'multiple-select input town-select registration-town',
                'size' => '1',
                'id' => 'city',
                'tag' => false
            ]; ?>
            <?=$form->field($model, 'city', ['template' => "{label}\n{input}"])->dropDownList($cities, $options)->label(false); ?>
            <span>Укажите город, чтобы находить подходящие задачи</span>

            <label class="input-danger" for="password"><?=$model->attributeLabels()['password'];?></label>
            <?php $options = [
                'class' => 'input textarea',
                'rows' => '1',
                'id' => 'password',
                'tag' => false
            ]; ?>
            <?=$form->field($model, 'password', ['template' => "{label}\n{input}"])->input('password', $options)->label(false);?>
            <span>Длина пароля от 8 символов</span>

            <button class="button button__registration" type="submit">Cоздать аккаунт</button>

        <?php ActiveForm::end(); ?>

    </div>
</section>
