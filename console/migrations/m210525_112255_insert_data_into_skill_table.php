<?php

use yii\db\Migration;

/**
 * Handles the data insertion into table `{{%skill}}`.
 */
class m210525_112255_insert_data_into_skill_table extends Migration
{
    public $data = [
        ['1', 'Курьерские услуги'],
        ['2', 'Грузоперевозки'],
        ['3', 'Перевод текстов'],
        ['4', 'Строительство и ремонт'],
        ['5', 'Уборка помещений'],
        ['6', 'Ремонт транспорта'],
        ['7', 'Программирование']
    ];

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('{{%skill}}', ['id', 'name'], $this->data);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable('{{%skill}}');
    }
}
