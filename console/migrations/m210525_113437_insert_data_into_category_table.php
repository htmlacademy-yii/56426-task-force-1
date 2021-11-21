<?php

use yii\db\Migration;

/**
 * Handles the data insertion into table `{{%category}}`.
 */
class m210525_113437_insert_data_into_category_table extends Migration
{
    public $data = [
        ['1', 'Перевод текстов', 'translate'],
        ['2', 'Уборка', 'clean'],
        ['3', 'Курьерские услуги', 'courier'],
        ['4', 'Грузоперевозки', 'cargo'],
        ['5', 'Компьютерная помощь', 'computer'],
        ['6', 'Ремонт квартирный', 'flat'],
        ['7', 'Ремонт техники', 'repair'],
        ['8', 'Мероприятия', 'event'],
        ['9', 'Красота', 'beauty'],
        ['10', 'Фото', 'photo']
    ];

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('{{%category}}', ['id', 'name', 'icon'], $this->data);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable('{{%category}}');
    }
}
