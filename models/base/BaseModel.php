<?php

/**
 * Created by PhpStorm.
 * User: pengboyu
 * Date: 16/11/18
 * Time: 下午12:01
 */

namespace app\models\base;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class BaseModel extends ActiveRecord
{


    const STATUS_DELETED = -2;
    const STATUS_INACTIVE = 1;
    const STATUS_ACTIVE = 2;


    /**
     * @状态
     * @var array
     */
    public static $statusAll = array(
        self::STATUS_ACTIVE => '正常',
        self::STATUS_DELETED => '删除',
        self::STATUS_INACTIVE => '关闭'
    );

    public static function getStatus(){

        return array(
            self::STATUS_ACTIVE => self::$statusAll[self::STATUS_ACTIVE],
            self::STATUS_INACTIVE => self::$statusAll[self::STATUS_INACTIVE],
            self::STATUS_DELETED => self::$statusAll[self::STATUS_DELETED],

        );
    }

    /**
     * Deletes the table row corresponding to this active record.
     *
     * This method performs the following steps in order:
     *
     * 1. call [[beforeDelete()]]. If the method returns false, it will skip the
     *    rest of the steps;
     * 2. delete the record from the database;
     * 3. call [[afterDelete()]].
     *
     * In the above step 1 and 3, events named [[EVENT_BEFORE_DELETE]] and [[EVENT_AFTER_DELETE]]
     * will be raised by the corresponding methods.
     *
     * @return integer|false the number of rows deleted, or false if the deletion is unsuccessful for some reason.
     * Note that it is possible the number of rows deleted is 0, even though the deletion execution is successful.
     * @throws StaleObjectException if [[optimisticLock|optimistic locking]] is enabled and the data
     * being deleted is outdated.
     * @throws \Exception in case delete failed.
     */
    public function delete()
    {


        if (!isset($this->status)) {
            return false;
        }

        $this->status = self::STATUS_DELETED;

        if (!$this->isTransactional(self::OP_DELETE)) {
            if ($this->validate()) {

                $this->save();
            }

        }

        $transaction = static::getDb()->beginTransaction();
        try {
            $result = $this->save();
            if ($result === false) {
                $transaction->rollBack();
            } else {
                $transaction->commit();
            }
            return $result;
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
//    public function save($runValidation = true, $attributeNames = null)
//    {
//        $isSave = parent::save($runValidation, $attributeNames);
//        if (empty($isSave)) {
//            foreach ($this->errors as $errors) {
//
//                foreach ($errors as $error) {
//                    Yii::$app->session->addFlash('error', $error);
//                }
//
//            }
//        }
//        return $isSave;
//    }
}