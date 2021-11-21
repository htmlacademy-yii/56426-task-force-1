<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%photo}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m210525_161306_create_photo_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%photo}}', [
            'id' => $this->primaryKey()->comment('Идентификатор'),
            'user_id' => $this->integer()->notNull()->comment('Пользователь'),
            'file' => $this->string(255)->notNull()->comment('Файл'),
            'name' => $this->string(64)->notNull()->comment('Имя файла')
        ], "engine innodb character set utf8 comment 'Фото работ исполнителей'");

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-photo-user_id}}',
            '{{%photo}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-photo-user_id}}',
            '{{%photo}}',
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
            '{{%fk-photo-user_id}}',
            '{{%photo}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-photo-user_id}}',
            '{{%photo}}'
        );

        $this->dropTable('{{%photo}}');
    }
}
