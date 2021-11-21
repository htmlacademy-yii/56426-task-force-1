<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%feedback}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%contractor}}`
 * - `{{%task}}`
 */
class m210525_165739_create_feedback_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%feedback}}', [
            'id' => $this->primaryKey()->comment('Идентификатор'),
            'contractor_id' => $this->integer()->notNull()->comment('Исполнитель'),
            'task_id' => $this->integer()->notNull()->comment('Задание'),
            'rating' => "enum('1', '2', '3', '4', '5') not null comment 'Оценка'",
            'description' => $this->text()->notNull()->comment('Текст отзыва'),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('current_timestamp')->comment('Время создания записи')
        ], "engine innodb character set utf8 comment 'Отзывы об исполнителях'");

        // creates index for column `contractor_id`
        $this->createIndex(
            '{{%idx-feedback-contractor_id}}',
            '{{%feedback}}',
            'contractor_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-feedback-contractor_id}}',
            '{{%feedback}}',
            'contractor_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `task_id`
        $this->createIndex(
            '{{%idx-feedback-task_id}}',
            '{{%feedback}}',
            'task_id'
        );

        // add foreign key for table `{{%task}}`
        $this->addForeignKey(
            '{{%fk-feedback-task_id}}',
            '{{%feedback}}',
            'task_id',
            '{{%task}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-feedback-contractor_id}}',
            '{{%feedback}}'
        );

        // drops index for column `contractor_id`
        $this->dropIndex(
            '{{%idx-feedback-contractor_id}}',
            '{{%feedback}}'
        );

        // drops foreign key for table `{{%task}}`
        $this->dropForeignKey(
            '{{%fk-feedback-task_id}}',
            '{{%feedback}}'
        );

        // drops index for column `task_id`
        $this->dropIndex(
            '{{%idx-feedback-task_id}}',
            '{{%feedback}}'
        );

        $this->dropTable('{{%feedback}}');
    }
}
