<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%lookup}}".
 *
 * @property int $id
 * @property string $name
 * @property int $code
 * @property string $type
 * @property int $position
 */
class Lookup extends \yii\db\ActiveRecord
{
    private static $_items=array();

    public static function items($type)
    {
        if(!isset(self::$_items[$type]))
            self::loadItems($type);
        return self::$_items[$type];
    }

    public static function item($type,$code)
    {
        if(!isset(self::$_items[$type]))
            self::loadItems($type);
        return isset(self::$_items[$type][$code]) ? self::$_items[$type][$code] : false;
    }

    private static function loadItems($type)
    {
        self::$_items[$type]=array();
        $models=self::model()->findAll(array(
            'condition'=>'type=:type',
            'params'=>array(':type'=>$type),
            'order'=>'position',
        ));
        foreach($models as $model)
            self::$_items[$type][$model->code]=$model->name;
    }
}
