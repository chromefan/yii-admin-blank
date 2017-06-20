<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property string $name
 * @property string $url
 * @property integer $pid
 * @property integer $status
 */
class Menu extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'url', 'pid'], 'required'],
            [['pid', 'status'], 'integer'],
            [['name'], 'string', 'max' => 30],
            [['url'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'url' => 'Url',
            'pid' => 'Pid',
            'status' => 'Status',
        ];
    }

    static public function getMenuList(){
        $condition=['status'=>1,'pid'=>0];

        $root=Menu::find()->where($condition)->asArray()->all();

        foreach($root as $k =>$v){
            $condition=['status'=>1,'pid'=>$v['id']];
            $sub=Menu::find()->where($condition)->asArray()->all();
            $root[$k]['sub']=$sub;
        }
        return $root;
    }
}
