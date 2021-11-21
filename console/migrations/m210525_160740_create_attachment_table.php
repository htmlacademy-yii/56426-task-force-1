<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%attachment}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%task}}`
 */
class m210525_160740_create_attachment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%attachment}}', [
            'id' => $this->primaryKey()->comment('Идентификатор'),
            'task_id' => $this->integer()->notNull()->comment('Задание'),
            'file' => $this->string(255)->notNull()->comment('Файл'),
            'name' => $this->string(64)->notNull()->comment('Имя файла')
        ], "engine innodb character set utf8 comment 'Вложения к заданиям'");

        // creates index for column `task_id`
        $this->createIndex(
            '{{%idx-attachment-task_id}}',
            '{{%attachment}}',
            'task_id'
        );

        // add foreign key for table `{{%task}}`
        $this->addForeignKey(
            '{{%fk-attachment-task_id}}',
            '{{%attachment}}',
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
        // drops foreign key for table `{{%task}}`
        $this->dropForeignKey(
            '{{%fk-attachment-task_id}}',
            '{{%attachment}}'
        );

        // drops index for column `task_id`
        $this->dropIndex(
            '{{%idx-attachment-task_id}}',
            '{{%attachment}}'
        );

        $this->dropTable('{{%attachment}}');
    }
}
