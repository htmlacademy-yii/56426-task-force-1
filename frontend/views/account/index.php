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
                            'tag' => false
                        ]; ?>
                        <?=$form->field($model, 'password', ['template' => "{label}\n{input}"])->input('password', $options)->label(null, ['for' => 'password']);?>
                </div>
                <div class="account__input">
                <?php $options = [
                            'class' => 'input textarea',
                            'id' => 'password_retype',
                            'tag' => false
                        ]; ?>
                        <?=$form->field($model, 'password_retype', ['template' => "{label}\n{input}"])->input('password', $options)->label(null, ['for' => 'password_retype']);?>
                </div>
            </div>

            <h3 class="div-line">Фото работ</h3>

            <div class="account__redaction-section-wrapper account__redaction">
                <?=$form->field($model, 'image_files[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>
                <span class="dropzone">Выбрать фотографии</span>
            </div>

            <h3 class="div-line">Контакты</h3>

            <div class="account__redaction-section-wrapper account__redaction">
                <div class="account__input">
                    <?php $options = [
                        'class' => 'input textarea',
                        'id' => 'phone',
                        'tag' => false
                    ]; ?>
                    <?=$form->field($model, 'phone', ['template' => "{label}\n{input}"])->input('tel', $options)->label(null, ['for' => 'phone']);?>
                </div>
                <div class="account__input">
                    <?php $options = [
                        'class' => 'input textarea',
                        'id' => 'skype',
                        'tag' => false
                    ]; ?>
                    <?=$form->field($model, 'skype', ['template' => "{label}\n{input}"])->input('text', $options)->label(null, ['for' => 'skype']);?>
                </div>
                <div class="account__input">
                    <?php $options = [
                        'class' => 'input textarea',
                        'id' => 'messenger',
                        'tag' => false
                    ]; ?>
                    <?=$form->field($model, 'messenger', ['template' => "{label}\n{input}"])->input('text', $options)->label(null, ['for' => 'messenger']);?>
                </div>
            </div>

            <h3 class="div-line">Настройки сайта</h3>

            <h4>Уведомления</h4>
            <div class="account__redaction-section-wrapper account_section--bottom">

                <div class="search-task__categories account_checkbox--bottom">

                    <?php $options = [
                        'class' => 'visually-hidden checkbox__input',
                        'id' => 'task_actions',
                        'tag' => false
                    ]; ?>
                    <?=$form->field($model, 'task_actions', ['template' => "{input}\n{label}"])->input('checkbox', $options)->label(null, ['for' => 'task_actions']);?>
    
                    <?php $options = [
                        'class' => 'visually-hidden checkbox__input',
                        'id' => 'new_message',
                        'tag' => false
                    ]; ?>
                    <?=$form->field($model, 'new_message', ['template' => "{input}\n{label}"])->input('checkbox', $options)->label(null, ['for' => 'new_message']);?>

                    <?php $options = [
                        'class' => 'visually-hidden checkbox__input',
                        'id' => 'new_feedback',
                        'tag' => false
                    ]; ?>
                    <?=$form->field($model, 'new_feedback', ['template' => "{input}\n{label}"])->input('checkbox', $options)->label(null, ['for' => 'new_feedback']);?>

                </div>

                <div class="search-task__categories account_checkbox account_checkbox--secrecy">

                    <?php $options = [
                        'class' => 'visually-hidden checkbox__input',
                        'id' => 'show_contacts',
                        'tag' => false
                    ]; ?>
                    <?=$form->field($model, 'show_contacts', ['template' => "{input}\n{label}"])->input('checkbox', $options)->label(null, ['for' => 'show_contacts']);?>
    
                    <?php $options = [
                        'class' => 'visually-hidden checkbox__input',
                        'id' => 'hide_profile',
                        'tag' => false
                    ]; ?>
                    <?=$form->field($model, 'hide_profile', ['template' => "{input}\n{label}"])->input('checkbox', $options)->label(null, ['for' => 'hide_profile']);?>

                </div>

            </div>

        </div>

        <button class="button" type="submit">Сохранить изменения</button>

    <?php ActiveForm::end(); ?>

</section>
