<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%city}}`.
 */
class m210525_080751_create_city_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%city}}', [
            'id' => $this->primaryKey()->comment('Идентификатор'),
            'name' => $this->string(64)->notNull()->comment('Название города'),
            'lat' => $this->decimal(10, 7)->defaultValue(null)->comment('Широта'),
            'long' => $this->decimal(10, 7)->defaultValue(null)->comment('Долгота'),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('current_timestamp')->comment('Время создания записи')
        ], "engine innodb character set utf8 comment 'Города'");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%city}}');
    }
}
