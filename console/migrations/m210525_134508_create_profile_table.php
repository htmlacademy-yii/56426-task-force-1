<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%profile}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 * - `{{%city}}`
 */
class m210525_134508_create_profile_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%profile}}', [
            'id' => $this->primaryKey()->comment('Идентификатор'),
            'user_id' => $this->integer()->notNull()->comment('Пользователь'),
            'city_id' => $this->integer()->defaultValue(null)->comment('Город'),
            'address' => $this->string(255)->defaultValue(null)->comment('Адрес'),
            'birthday' => $this->date()->defaultValue(null)->comment('День рождения'),
            'about' => $this->text()->defaultValue(null)->comment('Информация о себе'),
            'phone' => $this->string(64)->defaultValue(null)->comment('Номер телефона'),
            'skype' => $this->string(64)->defaultValue(null)->comment('Скайп'),
            'telegram' => $this->string(64)->defaultValue(null)->comment('Телеграм'),
            'last_activity' => $this->dateTime()->notNull()->defaultExpression('current_timestamp')->comment('Время последней активности')
        ], "engine innodb character set utf8 comment 'Профили пользователей'");

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-profile-user_id}}',
            '{{%profile}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-profile-user_id}}',
            '{{%profile}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `city_id`
        $this->createIndex(
            '{{%idx-profile-city_id}}',
            '{{%profile}}',
            'city_id'
        );

        // add foreign key for table `{{%city}}`
        $this->addForeignKey(
            '{{%fk-profile-city_id}}',
            '{{%profile}}',
            'city_id',
            '{{%city}}',
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
            '{{%fk-profile-user_id}}',
            '{{%profile}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-profile-user_id}}',
            '{{%profile}}'
        );

        // drops foreign key for table `{{%city}}`
        $this->dropForeignKey(
            '{{%fk-profile-city_id}}',
            '{{%profile}}'
        );

        // drops index for column `city_id`
        $this->dropIndex(
            '{{%idx-profile-city_id}}',
            '{{%profile}}'
        );

        $this->dropTable('{{%profile}}');
    }
}
