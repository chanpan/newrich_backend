<?php
namespace common\modules\user\models;
use dektrium\user\models\Profile as BaseProfile;
use trntv\filekit\behaviors\UploadBehavior;
use Yii;
class Profile extends BaseProfile{
    public $image;
    public function behaviors()
    {
        return [
            'picture' => [
                'class' => UploadBehavior::className(),
                'attribute' => 'image',
                'pathAttribute' => 'avatar_path',
                'baseUrlAttribute' => 'avatar_base_url'
            ],
 
        ];
    }
    public function rules()
    {
        $rules = [
            'bioString' => ['bio', 'string'],
            'sitecodeString' => ['sitecode', 'string'],
            'publicEmailPattern' => ['public_email', 'email'],
            'gravatarEmailPattern' => ['gravatar_email', 'email'],
            'websiteUrl' => ['website', 'url'],
            'nameLength' => ['name', 'string', 'max' => 255],
            'publicEmailLength' => ['public_email', 'string', 'max' => 255],
            'gravatarEmailLength' => ['gravatar_email', 'string', 'max' => 255],
            'locationLength' => ['location', 'string', 'max' => 255],
            'websiteLength' => ['website', 'string', 'max' => 255],

            'member_type' => ['member_type', 'string', 'max' => 255],
            'member_id' => ['member_id', 'string', 'max' => 255],
            'link' => ['link', 'string', 'max' => 255],
            'parent_id' => ['parent_id', 'safe'],
            'avatar_path' => ['avatar_path', 'safe'],
            'create_date'=>  ['create_date', 'safe'],
            'profile'=>  ['profile', 'safe'],
            'site'=>  ['site', 'safe'],
            'link'=>  ['site', 'safe'],

            
        ];
        $addon = [
            //[['firstname'],'required','message'=> \Yii::t('chanpan','Firstname cannot be blank.')],
            ['firstname','required', 'on' => ['create', 'connect', 'update','update-profile'],'message'=> \Yii::t('chanpan','Firstname cannot be blank.')],
            [['lastname'],'required','on' => ['create', 'connect', 'update','update-profile'],'message'=> \Yii::t('chanpan','Lastname cannot be blank.')],
            [['avatar_path', 'avatar_base_url'], 'string'],
            [['image','tel','firstname','lastname','image2'], 'safe']
        ];
        
        return \yii\helpers\ArrayHelper::merge($rules, $addon);
    }
    public function attributeLabels()
    {
	$labels = [             
            'tel'            => Yii::t('_user', 'Telephone number'),
            'sitecode'       => Yii::t('_user','Sitecode'),
            'name'           => Yii::t('_user', 'Nickname'),
            'firstname'      => Yii::t('_user', 'First name'),
            'lastname'       => Yii::t('_user', 'Last name'),
            'public_email'   => Yii::t('_user', 'Email (public)'),
            'gravatar_email' => Yii::t('_user', 'Gravatar email'),
            'location'       => Yii::t('_user', 'Location'),
            'website'        => Yii::t('_user', 'Website'),
            'bio'            => Yii::t('_user', 'Birth date'),

            'public_email'   => Yii::t('_user', 'Email'),
            'location'      => Yii::t('_user', 'Location'),
            'timezone'      => Yii::t('_user', 'Timezone'),
            'image'         => Yii::t('_user', 'My Picture'),
        ];
	
	 
        return $labels;
    }
}
