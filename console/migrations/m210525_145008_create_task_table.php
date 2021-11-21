<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%task}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%customer}}`
 * - `{{%category}}`
 * - `{{%city}}`
 * - `{{%contractor}}`
 */
class m210525_145008_create_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%task}}', [
            'id' => $this->primaryKey()->comment('Идентификатор'),
            'customer_id' => $this->integer()->notNull()->comment('Заказчик'),
            'name' => $this->string(64)->notNull()->comment('Мне нужно'),
            'description' => $this->text()->notNull()->comment('Подробности задания'),
            'category_id' => $this->integer()->notNull()->comment('Категория задания'),
            'city_id' => $this->integer()->defaultValue(null)->comment('Город'),
            'address' => $this->string(255)->defaultValue(null)->comment('Адрес'),
            'lat' => $this->decimal(10, 7)->defaultValue(null)->comment('Широта'),
            'long' => $this->decimal(10, 7)->defaultValue(null)->comment('Долгота'),
            'budget' => $this->integer()->defaultValue(null)->comment('Бюджет'),
            'status' => $this->integer()->notNull()->comment('Статус задания'),
            'contractor_id' => $this->integer()->defaultValue(null)->comment('Исполнитель'),
            'expire' => $this->datetime()->defaultValue(null)->comment('Срок завершения работы'),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('current_timestamp')->comment('Время создания записи')
        ], "engine innodb character set utf8 comment 'Задания'");

        // creates index for column `customer_id`
        $this->createIndex(
            '{{%idx-task-customer_id}}',
            '{{%task}}',
            'customer_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-task-customer_id}}',
            '{{%task}}',
            'customer_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `category_id`
        $this->createIndex(
            '{{%idx-task-category_id}}',
            '{{%task}}',
            'category_id'
        );

        // add foreign key for table `{{%category}}`
        $this->addForeignKey(
            '{{%fk-task-category_id}}',
            '{{%task}}',
            'category_id',
            '{{%category}}',
            'id',
            'CASCADE'
        );

        // creates index for column `city_id`
        $this->createIndex(
            '{{%idx-task-city_id}}',
            '{{%task}}',
            'city_id'
        );

        // add foreign key for table `{{%city}}`
        $this->addForeignKey(
            '{{%fk-task-city_id}}',
            '{{%task}}',
            'city_id',
            '{{%city}}',
            'id',
            'CASCADE'
        );

        // creates index for column `contractor_id`
        $this->createIndex(
            '{{%idx-task-contractor_id}}',
            '{{%task}}',
            'contractor_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-task-contractor_id}}',
            '{{%task}}',
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
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-task-customer_id}}',
            '{{%task}}'
        );

        // drops index for column `customer_id`
        $this->dropIndex(
            '{{%idx-task-customer_id}}',
            '{{%task}}'
        );

        // drops foreign key for table `{{%category}}`
        $this->dropForeignKey(
            '{{%fk-task-category_id}}',
            '{{%task}}'
        );

        // drops index for column `category_id`
        $this->dropIndex(
            '{{%idx-task-category_id}}',
            '{{%task}}'
        );

        // drops foreign key for table `{{%city}}`
        $this->dropForeignKey(
            '{{%fk-task-city_id}}',
            '{{%task}}'
        );

        // drops index for column `city_id`
        $this->dropIndex(
            '{{%idx-task-city_id}}',
            '{{%task}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-task-contractor_id}}',
            '{{%task}}'
        );

        // drops index for column `contractor_id`
        $this->dropIndex(
            '{{%idx-task-contractor_id}}',
            '{{%task}}'
        );

        $this->dropTable('{{%task}}');
    }
}
