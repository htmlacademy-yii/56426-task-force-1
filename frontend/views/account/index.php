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
        'enableClientValidation' => false,
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
                    <img src="<?=User::getAvatar();?>" width="140" height="140">
                    <?=$form->field($model, 'avatar', ['template' => "{label}\n{input}"])
                        ->label(null, ['for' => 'upload-avatar', 'class' => 'link-regular'])
                        ->fileInput(['id' => 'upload-avatar', 'multiple' => false, 'accept' => 'image/jpeg']);?>
                </div>
                <div class="account__redaction">
                    <div class="account__input account__input--name">
                        <?=$form->field($model, 'name', ['template' => "{label}\n{input}"])
                            ->label(null, ['for' => 'name'])
                            ->input('text', ['class' => 'input textarea', 'id' => 'name', 'disabled' => '']);?>
                    </div>
                    <div class="account__input account__input--email">
                        <?=$form->field($model, 'email', ['template' => "{label}\n{input}\n{error}"])
                            ->label(null, ['for' => 'email'])
                            ->input('text', ['class' => 'input textarea', 'id' => 'email'])
                            ->error(['tag' => 'span', 'class' => 'input-error']);?>
                    </div>
                    <div class="account__input account__input--city">
                        <?=$form->field($model, 'city', ['template' => "{label}\n{input}\n{error}"])
                            ->label(null, ['for' => 'city'])
                            ->dropDownList($cities, ['class' => 'multiple-select input multiple-select-big', 'size' => '1', 'id' => 'city'])
                            ->error(['tag' => 'span', 'class' => 'input-error']);?>
                    </div>
                    <div class="account__input account__input--date">
                        <?=$form->field($model, 'birthday', ['template' => "{label}\n{input}\n{error}"])
                            ->label(null, ['for' => 'birthday'])
                            ->input('date', ['class' => 'input-middle input input-date', 'id' => 'birthday'])
                            ->error(['tag' => 'span', 'class' => 'input-error']);?>
                    </div>
                    <div class="account__input account__input--info">
                        <?=$form->field($model, 'about', ['template' => "{label}\n{input}"])
                            ->label(null, ['for' => 'about'])
                            ->textarea(['class' => 'input textarea', 'rows' => '7', 'id' => 'about']);?>
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
                    <?=$form->field($model, 'password', ['template' => "{label}\n{input}\n{error}"])
                        ->label(null, ['for' => 'password'])
                        ->input('password', ['class' => 'input textarea', 'id' => 'password'])
                        ->error(['tag' => 'span', 'class' => 'input-error']);?>
                </div>
                <div class="account__input">
                    <?=$form->field($model, 'password_retype', ['template' => "{label}\n{input}\n{error}"])
                        ->label(null, ['for' => 'password_retype'])
                        ->input('password', ['class' => 'input textarea', 'id' => 'password_retype'])
                        ->error(['tag' => 'span', 'class' => 'input-error']);?>
                </div>
            </div>

            <h3 class="div-line">Фото работ</h3>

            <div class="account__redaction-section-wrapper account__redaction">
                <?=$form->field($model, 'image_files[]', ['template' => "{input}"])
                    ->fileInput(['id' => 'image_files', 'multiple' => true, 'accept' => 'image/jpeg, image/png']);?>
            </div>

            <h3 class="div-line">Контакты</h3>

            <div class="account__redaction-section-wrapper account__redaction">
                <div class="account__input">
                    <?=$form->field($model, 'phone', ['template' => "{label}\n{input}\n{error}"])
                        ->label(null, ['for' => 'phone'])
                        ->input('tel', ['class' => 'input textarea', 'id' => 'phone'])
                        ->error(['tag' => 'span', 'class' => 'input-error']);?>
                </div>
                <div class="account__input">
                    <?=$form->field($model, 'skype', ['template' => "{label}\n{input}\n{error}"])
                        ->label(null, ['for' => 'skype'])
                        ->input('text', ['class' => 'input textarea', 'id' => 'skype'])
                        ->error(['tag' => 'span', 'class' => 'input-error']);?>
                </div>
                <div class="account__input">
                    <?=$form->field($model, 'telegram', ['template' => "{label}\n{input}\n{error}"])
                        ->label(null, ['for' => 'telegram'])
                        ->input('text', ['class' => 'input textarea', 'id' => 'telegram'])
                        ->error(['tag' => 'span', 'class' => 'input-error']);?>
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
                            'value' => true
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
                            'value' => true
                        ];
                        if ($model->task_actions) {
                            $options['checked'] = '';
                        }
                    ?>
                    <?=$form->field($model, 'task_actions', ['template' => "{input}\n{label}"])->input('checkbox', $options)->label(null, ['for' => 'task_actions']);?>

                    <?php
                        $options = [
                            'class' => 'visually-hidden checkbox__input',
                            'id' => 'new_reply',
                            'value' => true
                        ];
                        if ($model->new_reply) {
                            $options['checked'] = '';
                        }
                    ?>
                    <?=$form->field($model, 'new_reply', ['template' => "{input}\n{label}"])->input('checkbox', $options)->label(null, ['for' => 'new_reply']);?>

                </div>

                <div class="search-task__categories account_checkbox account_checkbox--secrecy">

                    <?php
                        $options = [
                            'class' => 'visually-hidden checkbox__input',
                            'id' => 'hide_contacts',
                            'value' => true
                        ];
                        if ($model->hide_contacts) {
                            $options['checked'] = '';
                        }
                    ?>
                    <?=$form->field($model, 'hide_contacts', ['template' => "{input}\n{label}"])->input('checkbox', $options)->label(null, ['for' => 'hide_contacts']);?>

                    <?php
                        $options = [
                            'class' => 'visually-hidden checkbox__input',
                            'id' => 'hide_profile',
                            'value' => true
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
