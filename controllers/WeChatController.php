<?php
/**
 * Created by PhpStorm.
 * User: pengboyu
 * Date: 16/12/8
 * Time: 上午9:08
 */

namespace app\controllers;

use app\models\WechatModel;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use Yii;

class WeChatController extends Controller
{
    const OPENID_KEY = 'baby';
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    'youzan' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {

        return $this->redirect(['authorize']);
    }


    /**
     * @微信授权第一步
     */
    public function actionAuthorize()
    {

        $url = 'http://course.babyfs.cn/we-chat/code';
        $redirectUrl = $url;
        $wechat = Yii::$app->wechat;
        $goUrl = $wechat->getOauth2AuthorizeUrl($redirectUrl, $state = 'authorize', $scope = 'snsapi_userinfo');

        $this->redirect($goUrl);
    }

    /**
     * @return string
     * @code
     */
    public function actionCode(){
        $code = Yii::$app->request->get('code');
        if ($code) {
            $wechat = Yii::$app->wechat;
            $newTokenArray = $wechat->getOauth2AccessToken($code, $grantType = 'authorization_code');
            if (!empty($newTokenArray['refresh_token'])) {
                //$newTokenArray = $wechat->refreshOauth2AccessToken($tokenArray['refresh_token'], $grantType = 'refresh_token');
                if (!empty($newTokenArray['openid']) && !empty($newTokenArray['access_token'])) {
                    $isTokenArray = $wechat->checkOauth2AccessToken($newTokenArray['access_token'], $newTokenArray['openid']);
                    if ($isTokenArray) {
                        $userInfoArray = $wechat->getSnsMemberInfo($newTokenArray['openid'], $newTokenArray['access_token'], $lang = 'zh_CN');
                        if (!empty($userInfoArray['openid'])) {
                            $wechatModel = new WechatModel();
                            $wechatModel->web_openid = $userInfoArray['openid'];
                            $wechatModel->nickname = $userInfoArray['nickname'];
                            $wechatModel->sex = $userInfoArray['sex'];
                            $wechatModel->headimgurl = $userInfoArray['headimgurl'];
                            $wechatModel->info = $userInfoArray['info'];

                            if ($wechatModel->save()) {
                                $this->render('/we-chat/info', ['model' => $wechatModel]);
                            } else {
                                return '系统错误';
                            }
                        } else {
                            return '获取用户信息失败';
                        }
                    } else {
                        return '授权凭证（access_token）失效';
                    }
                } else {
                    return '刷新access_token失败';
                }
            } else {
                return '获取access_token失败';
            }
        } else {
            return '获取code失败';
        }
    }



}