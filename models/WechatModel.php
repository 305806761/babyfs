<?php
/**
 * Created by PhpStorm.
 * User: pengboyu
 * Date: 16/12/8
 * Time: 下午2:51
 */

namespace app\models;


use app\models\base\BaseModel;

class WechatModel extends BaseModel
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['web_openid'], 'required'],
            ['web_openid', 'string', 'min' => 1, 'max' => 255],

            [['nickname'], 'required'],
            ['nickname', 'string', 'min' => 1, 'max' => 255],

            ['sex', 'integer', 'min' => 0, 'max' => 2147483647],
            ['sex', 'default', 'value' => 0],

            ['headimgurl', 'default', 'value' => ''],
            ['headimgurl', 'string', 'min' => 1, 'max' => 255],

            ['info', 'default', 'value' => ''],

            [['info', 'headimgurl', 'nickname', 'web_openid'],'safe'],

            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wechat_main';
    }

}