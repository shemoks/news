<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "news".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property integer $is_deleted
 * @property integer $id_user
 * @property string $date_begin
 * @property string $date_end
 * @property string $place
 * @property integer $latitude
 * @property integer $longitude
 *
 * @property User $idUser
 */
class News extends ActiveRecord
{
    const STATUS_DELETED = 1;
    const STATUS_ACTIVE = 0;

    public static $coordinates;

    /**
     * @param array $coordinates
     */
    public static function setCoordinates($coordinates)
    {
        self::$coordinates[] = $coordinates;
    }

    /**
     * @return mixed
     */
    public static function getCoordinates()
    {
        return self::$coordinates;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => function () {
                    return date('Y-m-d H:i:s');
                }
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'date_begin', 'date_end', 'place'], 'required'],
            [['description'], 'string'],
            [['date_begin', 'date_end', 'place', 'latitude', 'longitude', 'created_at', 'updated_at'], 'safe'],
            ['date_end', 'compare', 'compareAttribute' => 'date_begin', 'operator' => '>', 'message' => 'False dates'],
            [['is_deleted', 'id_user'], 'integer'],
            [['title', 'place', 'latitude', 'longitude'], 'string', 'max' => 255],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => [
                'id_user' => 'id'
            ]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => Yii::t('app', 'ID'),
            'title'       => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'created_at'  => Yii::t('app', 'Created At'),
            'updated_at'  => Yii::t('app', 'Updated At'),
            'is_deleted'  => Yii::t('app', 'Is Deleted'),
            'id_user'     => Yii::t('app', 'Id User'),
            'date_begin'  => Yii::t('app', 'Date Begin'),
            'date_end'    => Yii::t('app', 'Date End'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }
}
