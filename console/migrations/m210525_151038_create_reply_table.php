<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%reply}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%task}}`
 * - `{{%contractor}}`
 */
class m210525_151038_create_reply_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%reply}}', [
            'id' => $this->primaryKey()->comment('Идентификатор'),
            'task_id' => $this->integer()->notNull()->comment('Задание'),
            'contractor_id' => $this->integer()->notNull()->comment('Исполнитель'),
            'price' => $this->integer()->defaultValue(null)->comment('Цена'),
            'comment' => $this->text()->comment('Комментарий'),
            'is_active' => $this->boolean()->notNull()->defaultValue(true)->comment('Признак активности'),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('current_timestamp')->comment('Время создания записи')
        ], "engine innodb character set utf8 comment 'Отклики на задания'");

        // creates index for column `task_id`
        $this->createIndex(
            '{{%idx-reply-task_id}}',
            '{{%reply}}',
            'task_id'
        );

        // add foreign key for table `{{%task}}`
        $this->addForeignKey(
            '{{%fk-reply-task_id}}',
            '{{%reply}}',
            'task_id',
            '{{%task}}',
            'id',
            'CASCADE'
        );

        // creates index for column `contractor_id`
        $this->createIndex(
            '{{%idx-reply-contractor_id}}',
            '{{%reply}}',
            'contractor_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-reply-contractor_id}}',
            '{{%reply}}',
            'contractor_id',
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
            '{{%fk-reply-task_id}}',
            '{{%reply}}'
        );

        // drops index for column `task_id`
        $this->dropIndex(
            '{{%idx-reply-task_id}}',
            '{{%reply}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-reply-contractor_id}}',
            '{{%reply}}'
        );

        // drops index for column `contractor_id`
        $this->dropIndex(
            '{{%idx-reply-contractor_id}}',
            '{{%reply}}'
        );

        $this->dropTable('{{%reply}}');
    }
}
