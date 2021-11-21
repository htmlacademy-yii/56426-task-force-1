<?php

use yii\db\Migration;

/**
 * Handles the data insertion into table `{{%city}}`.
 */
class m210525_103257_insert_data_into_city_table extends Migration
{
    public $data = [
        ['1', 'Абакан', '53.721152', '91.442396'],
        ['2', 'Анадырь', '64.735814', '177.518913'],
        ['3', 'Архангельск', '64.539911', '40.515762'],
        ['4', 'Астрахань', '46.347614', '48.030178'],
        ['5', 'Барнаул', '53.346785', '83.776856'],
        ['6', 'Белгород', '50.595414', '36.587277'],
        ['7', 'Биробиджан', '48.78992', '132.924746'],
        ['8', 'Благовещенск', '50.257456', '127.534611'],
        ['9', 'Брянск', '53.243562', '34.363425'],
        ['10', 'Великий Новгород', '58.522857', '31.269816'],
        ['11', 'Владивосток', '43.115542', '131.885494'],
        ['12', 'Владикавказ', '43.024616', '44.681771'],
        ['13', 'Владимир', '56.129057', '40.406635'],
        ['14', 'Волгоград', '48.707067', '44.516975'],
        ['15', 'Вологда', '59.220501', '39.891523'],
        ['16', 'Воронеж', '51.660786', '39.200269'],
        ['17', 'Горно-Алтайск', '51.957804', '85.960634'],
        ['18', 'Грозный', '43.31851', '45.69428'],
        ['19', 'Екатеринбург', '56.838011', '60.597474'],
        ['20', 'Иваново', '57.000353', '40.97393'],
        ['21', 'Ижевск', '56.852676', '53.2069'],
        ['22', 'Иркутск', '52.289588', '104.280606'],
        ['23', 'Йошкар-Ола', '56.6316', '47.886178'],
        ['24', 'Казань', '55.796127', '49.106414'],
        ['25', 'Калининград', '54.710162', '20.510137'],
        ['26', 'Калуга', '54.513845', '36.261224'],
        ['27', 'Кемерово', '55.355198', '86.086847'],
        ['28', 'Киров', '58.603595', '49.668023'],
        ['29', 'Кострома', '57.767966', '40.926858'],
        ['30', 'Красногорск', '55.831003', '37.330399'],
        ['31', 'Краснодар', '45.03547', '38.975313'],
        ['32', 'Красноярск', '56.010569', '92.852572'],
        ['33', 'Курган', '55.441004', '65.341118'],
        ['34', 'Курск', '51.730846', '36.193015'],
        ['35', 'Кызыл', '51.71989', '94.43799'],
        ['36', 'Липецк', '52.608826', '39.599229'],
        ['37', 'Магадан', '59.565155', '150.808586'],
        ['38', 'Магас', '43.166787', '44.803574'],
        ['39', 'Майкоп', '44.606683', '40.105852'],
        ['40', 'Махачкала', '42.983555', '47.504044'],
        ['41', 'Москва', '55.75322', '37.622513'],
        ['42', 'Мурманск', '68.970663', '33.074918'],
        ['43', 'Нальчик', '43.485259', '43.607081'],
        ['44', 'Нарьян-Мар', '67.63805', '53.006926'],
        ['45', 'Нижний Новгород', '56.326797', '44.006516'],
        ['46', 'Новосибирск', '55.030204', '82.92043'],
        ['47', 'Омск', '54.989347', '73.368221'],
        ['48', 'Орёл', '52.970756', '36.064358'],
        ['49', 'Оренбург', '51.768205', '55.096964'],
        ['50', 'Пенза', '53.195042', '45.018316'],
        ['51', 'Пермь', '58.010455', '56.229443'],
        ['52', 'Петрозаводск', '61.785021', '34.346878'],
        ['53', 'Петропавловск-Камчатский', '53.024265', '158.643503'],
        ['54', 'Псков', '57.819274', '28.33246'],
        ['55', 'Ростов-на-Дону', '47.222078', '39.720358'],
        ['56', 'Рязань', '54.629565', '39.741917'],
        ['57', 'Салехард', '66.529866', '66.614507'],
        ['58', 'Самара', '53.195878', '50.100202'],
        ['59', 'Санкт-Петербург', '59.938955', '30.315644'],
        ['60', 'Саранск', '54.187433', '45.183938'],
        ['61', 'Саратов', '51.533562', '46.034266'],
        ['62', 'Севастополь', '44.556972', '33.526402'],
        ['63', 'Симферополь', '44.948237', '34.100327'],
        ['64', 'Смоленск', '54.782635', '32.045287'],
        ['65', 'Ставрополь', '45.043317', '41.96911'],
        ['66', 'Сыктывкар', '61.668797', '50.836497'],
        ['67', 'Тамбов', '52.721295', '41.45275'],
        ['68', 'Тверь', '56.859625', '35.91186'],
        ['69', 'Томск', '56.484645', '84.947649'],
        ['70', 'Тула', '54.193122', '37.617348'],
        ['71', 'Тюмень', '57.152985', '65.541227'],
        ['72', 'Улан-Удэ', '51.834809', '107.584547'],
        ['73', 'Ульяновск', '54.314192', '48.403132'],
        ['74', 'Уфа', '54.735152', '55.958736'],
        ['75', 'Хабаровск', '48.480229', '135.071917'],
        ['76', 'Ханты-Мансийск', '61.003184', '69.018911'],
        ['77', 'Чебоксары', '56.139787', '47.248734'],
        ['78', 'Челябинск', '55.159902', '61.402554'],
        ['79', 'Черкесск', '44.228374', '42.048279'],
        ['80', 'Чита', '52.033635', '113.501049'],
        ['81', 'Элиста', '46.307743', '44.269759'],
        ['82', 'Южно-Сахалинск', '46.957771', '142.729587'],
        ['83', 'Якутск', '62.027221', '129.732178'],
        ['84', 'Ярославль', '57.626559', '39.893813']
    ];

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('{{%city}}', ['id', 'name', 'lat', 'long'], $this->data);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable('{{%city}}');
    }
}
