<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%chat}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%task}}`
 * - `{{%sender}}`
 * - `{{%recipient}}`
 */
class m210525_162140_create_chat_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%chat}}', [
            'id' => $this->primaryKey()->comment('Идентификатор'),
            'task_id' => $this->integer()->notNull()->comment('Задание'),
            'sender_id' => $this->integer()->notNull()->comment('Отправитель'),
            'recipient_id' => $this->integer()->notNull()->comment('Получатель'),
            'message' => $this->string(255)->notNull()->comment('Текст сообщения'),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('current_timestamp')->comment('Время создания записи')
        ], "engine innodb character set utf8 comment 'Внутренняя переписка'");

        // creates index for column `task_id`
        $this->createIndex(
            '{{%idx-chat-task_id}}',
            '{{%chat}}',
            'task_id'
        );

        // add foreign key for table `{{%task}}`
        $this->addForeignKey(
            '{{%fk-chat-task_id}}',
            '{{%chat}}',
            'task_id',
            '{{%task}}',
            'id',
            'CASCADE'
        );

        // creates index for column `sender_id`
        $this->createIndex(
            '{{%idx-chat-sender_id}}',
            '{{%chat}}',
            'sender_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-chat-sender_id}}',
            '{{%chat}}',
            'sender_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `recipient_id`
        $this->createIndex(
            '{{%idx-chat-recipient_id}}',
            '{{%chat}}',
            'recipient_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-chat-recipient_id}}',
            '{{%chat}}',
            'recipient_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%task}}`
        $this->dropForeignKey(
            '{{%fk-chat-task_id}}',
            '{{%chat}}'
        );

        // drops index for column `task_id`
        $this->dropIndex(
            '{{%idx-chat-task_id}}',
            '{{%chat}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-chat-sender_id}}',
            '{{%chat}}'
        );

        // drops index for column `sender_id`
        $this->dropIndex(
            '{{%idx-chat-sender_id}}',
            '{{%chat}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-chat-recipient_id}}',
            '{{%chat}}'
        );

        // drops index for column `recipient_id`
        $this->dropIndex(
            '{{%idx-chat-recipient_id}}',
            '{{%chat}}'
        );

        $this->dropTable('{{%chat}}');
    }
}
