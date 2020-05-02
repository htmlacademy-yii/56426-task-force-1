<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\Skill;

$this->title = 'Настройки аккаунта - TaskForce';

?>

<div style="margin-right:20px;width:300px;">
<?php
    if (empty($model->password)) $model->password = null;
    if (empty($model->password_retype)) $model->password_retype = null;
?>
<?php foreach ($model->attributes as $key => $value): ?>
    <span style="padding-right:10px;display:inline-block;width:120px;text-align:right;"><?=$key;?>:</span>
    <?=(isset($value)) ? var_dump($value) : "<i>empty</i>";?><br>
<?php endforeach; ?>

</div>

<section class="account__redaction-wrapper">
    <h1>Редактирование настроек профиля</h1>

    <?php $form = ActiveForm::begin([
        'id' => 'account',
        'options' => [
            'enctype' => 'multipart/form-data',
            'name' => $model->formName()
        ],
        'fieldConfig' => [
            'options' => [
                'tag' => false
            ]
        ]
    ]); ?>

        <div class="account__redaction-section">

            <h3 class="div-line">Настройки аккаунта</h3>

            <div class="account__redaction-section-wrapper">
                <div class="account__redaction-avatar">
                    <img src="img/man-glasses.jpg" width="156" height="156">
                    <input type="file" name="avatar" id="upload-avatar">
                    <label for="upload-avatar" class="link-regular">Сменить аватар</label>
                </div>
                <div class="account__redaction">
                    <div class="account__input account__input--name">
                        <?php $options = [
                            'class' => 'input textarea',
                            'id' => 'name',
                            'disabled' => '',
                            //'placeholder' => 'Input your name',
                            'tag' => false
                        ]; ?>
                        <?=$form->field($model, 'name', ['template' => "{label}\n{input}"])->input('text', $options)->label(null, ['for' => 'name']);?>
                    </div>
                    <div class="account__input account__input--email">
                    <?php $options = [
                            'class' => 'input textarea',
                            'id' => 'email',
                            //'placeholder' => 'Student@htmlacademy.ru',
                            'tag' => false
                        ]; ?>
                        <?=$form->field($model, 'email', ['template' => "{label}\n{input}"])->input('text', $options)->label(null, ['for' => 'email']);?>
                    </div>
                    <div class="account__input account__input--name">
                        <?php $options = [
                            'class' => 'multiple-select input multiple-select-big',
                            'size' => '1',
                            'id' => 'city',
                            'tag' => false
                        ]; ?>
                        <?=$form->field($model, 'city', ['template' => "{label}\n{input}"])->dropDownList($cities, $options)->label(null, ['for' => 'city']);?>
                    </div>
                    <div class="account__input account__input--date">
                        <?php $options = [
                            'class' => 'input-middle input input-date',
                            'id' => 'birthday',
                            //'placeholder' => 'dd.mm.yyyy',
                            'tag' => false
                        ]; ?>
                        <?=$form->field($model, 'birthday', ['template' => "{label}\n{input}"])->input('date', $options)->label(null, ['for' => 'birthday']);?>
                    </div>
                    <div class="account__input account__input--info">
                        <?php $options = [
                            'class' => 'input textarea',
                            'rows' => '7',
                            'id' => 'about',
                            //'placeholder' => 'Place your text',
                            'tag' => false
                        ]; ?>
                        <?=$form->field($model, 'about', ['template' => "{label}\n{input}"])->textarea($options)->label(null, ['for' => 'about']);?>
                    </div>
                </div>
            </div>

            <h3 class="div-line">Выберите свои специализации</h3>

            <div class="account__redaction-section-wrapper">
                <div class="search-task__categories account_checkbox--bottom">
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
                </div>
            </div>

            <h3 class="div-line">Безопасность</h3>

            <div class="account__redaction-section-wrapper account__redaction">
                <div class="account__input">
                        <?php $options = [
                            'class' => 'input textarea',
                            'id' => 'password',
                            //'placeholder' => 'Input new password',
                            'tag' => false
                        ]; ?>
                        <?=$form->field($model, 'password', ['template' => "{label}\n{input}"])->input('password', $options)->label(null, ['for' => 'password']);?>
                </div>
                <div class="account__input">
                <?php $options = [
                            'class' => 'input textarea',
                            'id' => 'password_retype',
                            //'placeholder' => 'Input new password',
                            'tag' => false
                        ]; ?>
                        <?=$form->field($model, 'password_retype', ['template' => "{label}\n{input}"])->input('password', $options)->label(null, ['for' => 'password_retype']);?>
                </div>
            </div>

            <h3 class="div-line">Фото работ</h3>

            <div class="account__redaction-section-wrapper account__redaction">
                <span class="dropzone">Выбрать фотографии</span>
            </div>

            <h3 class="div-line">Контакты</h3>

            <div class="account__redaction-section-wrapper account__redaction">
                <div class="account__input">
                    <?php $options = [
                        'class' => 'input textarea',
                        'id' => 'phone',
                        //'placeholder' => '8 (123) 456-78-90',
                        'tag' => false
                    ]; ?>
                    <?=$form->field($model, 'phone', ['template' => "{label}\n{input}"])->input('tel', $options)->label(null, ['for' => 'phone']);?>
                </div>
                <div class="account__input">
                    <?php $options = [
                        'class' => 'input textarea',
                        'id' => 'skype',
                        //'placeholder' => 'Student',
                        'tag' => false
                    ]; ?>
                    <?=$form->field($model, 'skype', ['template' => "{label}\n{input}"])->input('text', $options)->label(null, ['for' => 'skype']);?>
                </div>
                <div class="account__input">
                    <?php $options = [
                        'class' => 'input textarea',
                        'id' => 'messenger',
                        //'placeholder' => 'Input your name',
                        'tag' => false
                    ]; ?>
                    <?=$form->field($model, 'messenger', ['template' => "{label}\n{input}"])->input('text', $options)->label(null, ['for' => 'messenger']);?>
                </div>
            </div>

            <h3 class="div-line">Настройки сайта</h3>

            <h4>Уведомления</h4>
            <div class="account__redaction-section-wrapper account_section--bottom">
                <div class="search-task__categories account_checkbox--bottom">
                    <input class="visually-hidden checkbox__input" id="216" type="checkbox" name="" value="" checked>
                    <label for="216">Новое сообщение</label>
                    <input class="visually-hidden checkbox__input" id="217" type="checkbox" name="" value="" checked>
                    <label for="217">Действия по заданию</label>
                    <input class="visually-hidden checkbox__input" id="218" type="checkbox" name="" value="" checked>
                    <label for="218">Новый отзыв</label>
                </div>
                <div class="search-task__categories account_checkbox account_checkbox--secrecy">
                    <input class="visually-hidden checkbox__input" id="219" type="checkbox" name="" value="">
                    <label for="219">Показывать мои контакты только заказчику</label>
                    <input class="visually-hidden checkbox__input" id="220" type="checkbox" name="" value="" checked>
                    <label for="220">Не показывать мой профиль</label>
                </div>
            </div>

        </div>

        <button class="button" type="submit">Сохранить изменения</button>

    <?php ActiveForm::end(); ?>

</section>
