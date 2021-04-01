<?php

/* @var $this yii\web\View */

use yii\widgets\ActiveForm;

$this->title = 'Создать задание - TaskForce';

?>

<section class="create__task">

    <h1>Публикация нового задания</h1>

    <div class="create__task-main">

        <?php $form = ActiveForm::begin([
            'id' => 'task-form',
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

            <?php $options = [
                'class' => 'input textarea',
                'rows' => '1',
                'id' => 'name',
                'tag' => false
            ]; ?>
            <?=$form->field($model, 'name', ['template' => "{label}\n{input}"])->input('textarea', $options)->label(null, ['for' => 'name']);?>
            <span>Кратко опишите суть работы</span>

            <?php $options = [
                'class' => 'input textarea',
                'rows' => '7',
                'id' => 'description',
                'tag' => false
            ]; ?>
            <?=$form->field($model, 'description', ['template' => "{label}\n{input}"])->input('textarea', $options)->label(null, ['for' => 'description']);?>
            <span>Укажите все пожелания и детали, чтобы исполнителям было проще соориентироваться</span>

            <?php $options = [
                'class' => 'multiple-select input multiple-select-big',
                'size' => '1',
                'id' => 'category',
                'tag' => false
            ]; ?>
            <?=$form->field($model, 'category', ['template' => "{label}\n{input}"])->dropDownList($categories, $options)->label(null, ['for' => 'category']);?>
            <span>Выберите категорию</span>

            <label>Файлы</label>
            <span>Загрузите файлы, которые помогут исполнителю лучше выполнить или оценить работу</span>
            <div class="create__file">
                <span>Добавить новый файл</span>
                <!--<input type="file" name="files[]" class="dropzone">-->
            </div>

            <?php $options = [
                'class' => 'input-navigation input-middle input',
                'id' => 'location',
                'tag' => false
            ]; ?>
            <?=$form->field($model, 'location', ['template' => "{label}\n{input}"])->input('search', $options)->label(null, ['for' => 'location']);?>
            <span>Укажите адрес исполнения, если задание требует присутствия</span>

            <div class="create__price-time">
                <div class="create__price-time--wrapper">
                    <?php $options = [
                        'class' => 'input textarea input-money',
                        'rows' => '1',
                        'id' => 'budget',
                        'tag' => false
                    ]; ?>
                    <?=$form->field($model, 'budget', ['template' => "{label}\n{input}"])->input('textarea', $options)->label(null, ['for' => 'budget']);?>
                    <span>Не заполняйте для оценки исполнителем</span>
                </div>
                <div class="create__price-time--wrapper">
                    <?php $options = [
                        'class' => 'input-middle input input-date',
                        'id' => 'expire',
                        'tag' => false
                    ]; ?>
                    <?=$form->field($model, 'expire', ['template' => "{label}\n{input}"])->input('date', $options)->label(null, ['for' => 'expire']);?>
                    <span>Укажите крайний срок исполнения</span>
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
            <?php if (count($model->getErrors())): ?>
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

    <button form="task-form" class="button" type="submit">Опубликовать</button>

</section>
