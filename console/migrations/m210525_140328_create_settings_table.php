<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%settings}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m210525_140328_create_settings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%settings}}', [
            'id' => $this->primaryKey()->comment('Идентификатор'),
            'user_id' => $this->integer()->notNull()->comment('Пользователь'),
            'task_actions' => $this->boolean()->notNull()->defaultValue(true)->comment('Действия по заданию'),
            'new_message' => $this->boolean()->notNull()->defaultValue(true)->comment('Новое сообщение'),
            'new_reply' => $this->boolean()->notNull()->defaultValue(true)->comment('Новый отклик'),
            'hide_contacts' => $this->boolean()->notNull()->defaultValue(false)->comment('Показывать мои контакты только заказчику'),
            'hide_profile' => $this->boolean()->notNull()->defaultValue(false)->comment('Не показывать мой профиль')
        ], "engine innodb character set utf8 comment 'Настройки пользователей'");

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-settings-user_id}}',
            '{{%settings}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-settings-user_id}}',
            '{{%settings}}',
            'user_id',
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
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-settings-user_id}}',
            '{{%settings}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-settings-user_id}}',
            '{{%settings}}'
        );

        $this->dropTable('{{%settings}}');
    }
}
