<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%category}}`.
 */
class m210525_113018_create_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%category}}', [
            'id' => $this->primaryKey()->comment('Идентификатор'),
            'name' => $this->string(64)->notNull()->comment('Название категории задания'),
            'icon' => $this->string(64)->defaultValue(null)->comment('Значок категории'),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('current_timestamp')->comment('Время создания записи')
        ], "engine innodb character set utf8 comment 'Категории заданий'");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%category}}');
    }
}
