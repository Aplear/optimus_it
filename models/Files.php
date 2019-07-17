<?php

namespace app\models;

use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "files".
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $path
 * @property string $description
 * @property string $extention
 * @property double $size
 * @property int $uploaded_at
 * @property int $downloaded
 *
 * @property User $user
 */
class Files extends \yii\db\ActiveRecord
{
    /**
     * Max file size in a MB
     * @var integer
     */
    const MAX_FILE_SIZE = 1024 * 1024 * 200;

    /**
     * @var $_File
     */
    public $file;

    /**
     * @var string
     */
    public $webroot = '@webroot';

    /**
     * @var string
     */
    public $web = '@web';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['user_id', 'uploaded_at', 'downloaded'], 'integer'],
            [['size'], 'number'],
            [['title', 'description', 'extention', 'path'], 'string', 'max' => 255],
            [['title'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['file'],
                'file',
                'skipOnEmpty' => true,
                'extensions' => 'doc, docx, xls, xlsx, pdf, jpg, png, rar, zip',
                'maxSize' => static::MAX_FILE_SIZE,
                'tooBig' => 'Limit is 200 MB'
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'title' => 'Title',
            'description' => 'Description',
            'extention' => 'Extention',
            'size' => 'Size',
            'uploaded_at' => 'Uploaded At',
            'downloaded' => 'Downloaded',
        ];
    }

    /**
     * Method check server file path
     */
    public function checkPath($path)
    {
        if (!is_dir($path)) {
            FileHelper::createDirectory($path);
        }
        return $path;
    }

    public function upload()
    {
        $this->checkPath(Yii::getAlias($this->webroot.'/uploads/files'));
        $serverPath = Yii::getAlias($this->webroot.'/uploads/files/' . date('d-m-Y', time()));
        $webPath = Yii::getAlias($this->web.'/uploads/files/' . date('d-m-Y', time()));
        $fileObj = UploadedFile::getInstance($this, 'file');

        if ($this->validate()) {
                if($fileObj->error === 0) {
                    $this->user_id = Yii::$app->user->id;
                    //prepare file name
                    $fileName = $this->title. '.' . $fileObj->extension;
                    $this->extention = $fileObj->extension;
                    $this->size = round(($fileObj->size/1024)/1024, 5);
                    //prepare file server path
                    $filePath = $this->checkPath($serverPath) . '/' . $fileName;
                    //prepare file web path
                    $this->path = $webPath . '/' . $fileName;
                    //upload file
                    $result = $fileObj->saveAs($filePath);
                    //check uploaded
                    if(!$result) {
                        Yii::error('Cannot load file');
                        return false;
                    }
                    $this->save();
                } else {
                    return false;
                }
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
