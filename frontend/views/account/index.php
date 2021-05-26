<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\User;
use frontend\models\Skill;

$this->title = 'Настройки аккаунта - TaskForce';

?>

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

        <?=$form->errorSummary($model);?>

        <div class="account__redaction-section">

            <h3 class="div-line">Настройки аккаунта</h3>

            <div class="account__redaction-section-wrapper">
                <div class="account__redaction-avatar">
                    <img src="<?=User::getAvatar();?>" width="140" height="140">
                    <?php $options = [
                        'id' => 'upload-avatar',
                        'multiple' => false,
                        'accept' => 'image/jpeg'
                    ]; ?>
                    <?=$form->field($model, 'avatar', ['template' => "{label}\n{input}"])->fileInput($options)->label(null, ['for' => 'upload-avatar', 'class' => 'link-regular']);?>
                </div>
                <div class="account__redaction">
                    <div class="account__input account__input--name">
                        <?php $options = [
                            'class' => 'input textarea',
                            'id' => 'name',
                            'disabled' => '',
                            'tag' => false
                        ]; ?>
                        <?=$form->field($model, 'name', ['template' => "{label}\n{input}"])->input('text', $options)->label(null, ['for' => 'name']);?>
                    </div>
                    <div class="account__input account__input--email">
                    <?php $options = [
                            'class' => 'input textarea',
                            'id' => 'email',
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
                            'tag' => false
                        ]; ?>
                        <?=$form->field($model, 'birthday', ['template' => "{label}\n{input}"])->input('date', $options)->label(null, ['for' => 'birthday']);?>
                    </div>
                    <div class="account__input account__input--info">
                        <?php $options = [
                            'class' => 'input textarea',
                            'rows' => '7',
                            'id' => 'about',
                            'tag' => false
                        ]; ?>
                        <?=$form->field($model, 'about', ['template' => "{label}\n{input}"])->textarea($options)->label(null, ['for' => 'about']);?>
                    </div>
                </div>
            </div>

            <h3 class="div-line">Выберите свои специализации</h3>

            <div class="account__redaction-section-wrapper">
                <div class="search-task__categories  search-task__filter  search-task__account  account_checkbox--bottom">
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
                <?php $options = [
                    'id' => 'image_files',
                    'multiple' => true,
                    'accept' => 'image/jpeg, image/png'
                ]; ?>
                <?=$form->field($model, 'image_files[]', ['template' => "{input}"])->fileInput($options);?>
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
                        'id' => 'telegram',
                        'tag' => false
                    ]; ?>
                    <?=$form->field($model, 'telegram', ['template' => "{label}\n{input}"])->input('text', $options)->label(null, ['for' => 'telegram']);?>
                </div>
            </div>

            <h3 class="div-line">Настройки сайта</h3>

            <h4>Уведомления</h4>
            <div class="account__redaction-section-wrapper account_section--bottom">

                <div class="search-task__categories account_checkbox--bottom">

                    <?php
                        $options = [
                            'class' => 'visually-hidden checkbox__input',
                            'id' => 'new_message',
                            'value' => true,
                            'tag' => false
                        ];
                        if ($model->new_message) {
                            $options['checked'] = '';
                        }
                    ?>
                    <?=$form->field($model, 'new_message', ['template' => "{input}\n{label}"])->input('checkbox', $options)->label(null, ['for' => 'new_message']);?>

                    <?php
                        $options = [
                            'class' => 'visually-hidden checkbox__input',
                            'id' => 'task_actions',
                            'value' => true,
                            'tag' => false
                        ];
                        if ($model->task_actions) {
                            $options['checked'] = '';
                        }
                    ?>
                    <?=$form->field($model, 'task_actions', ['template' => "{input}\n{label}"])->input('checkbox', $options)->label(null, ['for' => 'task_actions']);?>

                    <?php
                        $options = [
                            'class' => 'visually-hidden checkbox__input',
                            'id' => 'new_feedback',
                            'value' => true,
                            'tag' => false
                        ];
                        if ($model->new_feedback) {
                            $options['checked'] = '';
                        }
                    ?>
                    <?=$form->field($model, 'new_feedback', ['template' => "{input}\n{label}"])->input('checkbox', $options)->label(null, ['for' => 'new_feedback']);?>

                </div>

                <div class="search-task__categories account_checkbox account_checkbox--secrecy">

                    <?php
                        $options = [
                            'class' => 'visually-hidden checkbox__input',
                            'id' => 'show_contacts',
                            'value' => true,
                            'tag' => false
                        ];
                        if ($model->show_contacts) {
                            $options['checked'] = '';
                        }
                    ?>
                    <?=$form->field($model, 'show_contacts', ['template' => "{input}\n{label}"])->input('checkbox', $options)->label(null, ['for' => 'show_contacts']);?>
    
                    <?php
                        $options = [
                            'class' => 'visually-hidden checkbox__input',
                            'id' => 'hide_profile',
                            'value' => true,
                            'tag' => false
                        ];
                        if ($model->hide_profile) {
                            $options['checked'] = '';
                        }
                    ?>
                    <?=$form->field($model, 'hide_profile', ['template' => "{input}\n{label}"])->input('checkbox', $options)->label(null, ['for' => 'hide_profile']);?>

                </div>

            </div>

        </div>

        <button class="button" type="submit">Сохранить изменения</button>

    <?php ActiveForm::end(); ?>

</section>
