<?php


namespace backend\modules\api\classes;


use appxq\sdii\utils\VarDumper;
use common\modules\user\models\Profile;
use mdm\admin\models\User;
use Yii;

class ClsAuth
{
    /**
     * @param $email
     * @return array|Orject user and profile
     */
    public static function getUserByEmail($email)
    {
        $user = \common\modules\user\models\User::find()->where('email=:email', [
            ':email' => $email
        ])->one();
        if ($user) {
            return $user;
        } else {
            return $user;
        }
    }

    public static function checkEmail($email)
    {
        $user = \common\modules\user\models\User::find()->where('email=:email', [
            ':email' => $email
        ])->one();
        if ($user) {
            return true;
        } else {
            return false;
        }
    }

    public static function getUserByToken($token)
    {
        $user = \common\modules\user\models\User::find()->where('auth_key=:token', [
            ':token' => $token
        ])->one();
        return $user;
    }

    public static function Login($username, $password)
    {
        try {
            $user = User::find()
                ->where('username=:username OR email=:email', [
                    ':username' => $username,
                    ':email' => $username
                ])
                ->one();
            if ($user) {
                if (\Yii::$app->getSecurity()->validatePassword($password, $user['password_hash'])) {
                    return ['status' => 'success', 'data' => $user];
                }
            }
        } catch (\Exception $e) {
            return ['status' => 'success', 'message' => $e->getMessage()];
        }
    }

    public static function saveUser($data, $id = null)
    {

        try {
            $user = new \common\modules\user\models\User();


            $user->id = ($id != null) ? $id : time();
            $user->username = date('YmdHis') . rand(0, 10000) . time();
            $user->password = $user->setPassword($data['password']);//\Yii::$app->security->generatePasswordHash($data['password']);
            $user->email = isset($data['email']) ? $data['email'] : '';
            $user->created_at = time();
            $user->confirmed_at = time();
            $user->updated_at = time();
            $user->auth_key = Yii::$app->security->generateRandomString();

            if ($user->save()) {

                try {
                    $statusProfile = self::saveProfile($data, $user->id);

                    if ($statusProfile['status'] == 'success') {
                        $assignData = ['item_name' => 'user', 'user_id' => $user->id, 'created_at' => time()];
                        Yii::$app->db->createCommand()->insert('auth_assignment', $assignData)->execute();
                        //VarDumper::dump($statusProfile);
                    } else {
                        $dataStatus = ['status' => 'error', 'message' => $statusProfile['message']];
                    }
                } catch (\yii\db\Exception $ex) {
                    $dataStatus = ['status' => 'error', 'message' => $ex->getMessage()];
                }
                $dataStatus = ['status' => 'success', 'data' => $user];


            } else {
                $dataStatus = ['status' => 'error', 'message' => $user->errors];
            }
        } catch (\yii\db\Exception $ex) {
            $dataStatus = ['status' => 'error', 'message' => $ex->getMessage()];
        }
        return $dataStatus;
    }

    /**
     *
     * @param type $data array $data=['email'=>'', 'name'=>'']
     * @param type $user_id
     * @return boolean true/false
     */
    public static function saveProfile($data, $user_id)
    {

        $dataProfile = \Yii::$app->db->createCommand("SELECT max(member_id) as member_id FROM profile")->queryOne();
        $member_id = isset($dataProfile['member_id']) ? $dataProfile['member_id'].rand(10,100) : $data['member_id'];


        $profile = Profile::findOne($user_id);
        $profile->user_id = $user_id;
        $profile->name = (string)isset($data['name']) ? $data['name'] : '';
        $profile->public_email = (string)isset($data['email']) ? $data['email'] : '';
        $profile->gravatar_email = (string)isset($data['email']) ? $data['email'] : '';
        $profile->firstname = (string)isset($data['firstname']) ? $data['firstname'] : '';
        $profile->lastname = (string)isset($data['lastname']) ? $data['lastname'] : '';
        $profile->sitecode = (string)isset($data['sitecode']) ? $data['sitecode'] : '';;
        $profile->site = (string)isset($data['sitecode']) ? $data['sitecode'] : '';;
        $profile->tel = (string)isset($data['tel']) ? $data['tel'] : '';
        $profile->link = (string)isset($data['linkCurrent']) ? $data['linkCurrent'] : '';
        $profile->member_type = (string)isset($data['member_type']) ? $data['member_type'] : '';
        $profile->parent_id = (string)isset($data['parent_id']) ? $data['parent_id'] : '';
        $profile->member_id = (string)$member_id;
        $profile->name = (string)isset($data['name']) ? $data['name'] : '';
        if ($profile->save()) {
            return ['status' => 'success'];
        } else {
            //VarDumper::dump($profile->errors);
            return ['status' => 'error', 'message' => $profile->errors];
        }
    }
}