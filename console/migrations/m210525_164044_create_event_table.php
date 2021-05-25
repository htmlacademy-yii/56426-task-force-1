<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%event}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 * - `{{%task}}`
 */
class m210525_164044_create_event_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%event}}', [
            'id' => $this->primaryKey()->comment('Идентификатор'),
            'user_id' => $this->integer()->notNull()->comment('Пользователь'),
            'task_id' => $this->integer()->notNull()->comment('Задание'),
            'is_viewed' => $this->boolean()->notNull()->defaultValue(false)->comment('Признак просмотра'),
            'type' => "enum('abandon', 'begin', 'close', 'message', 'reply') not null comment 'Тип события'",
            'text' => $this->string(255)->notNull()->comment('Текст события'),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('current_timestamp')->comment('Время создания записи')
        ], "engine innodb character set utf8 comment 'События'");

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-event-user_id}}',
            '{{%event}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-event-user_id}}',
            '{{%event}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `task_id`
        $this->createIndex(
            '{{%idx-event-task_id}}',
            '{{%event}}',
            'task_id'
        );

        // add foreign key for table `{{%task}}`
        $this->addForeignKey(
            '{{%fk-event-task_id}}',
            '{{%event}}',
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
            '{{%fk-event-user_id}}',
            '{{%event}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-event-user_id}}',
            '{{%event}}'
        );

        // drops foreign key for table `{{%task}}`
        $this->dropForeignKey(
            '{{%fk-event-task_id}}',
            '{{%event}}'
        );

        // drops index for column `task_id`
        $this->dropIndex(
            '{{%idx-event-task_id}}',
            '{{%event}}'
        );

        $this->dropTable('{{%event}}');
    }
}
