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
        ['3', 'Переезды', 'cargo'],
        ['4', 'Компьютерная помощь', 'computer'],
        ['5', 'Ремонт квартирный', 'roller'],
        ['6', 'Ремонт техники', 'repair'],
        ['7', 'Красота', 'hairdryer'],
        ['8', 'Фото', 'camera']
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
