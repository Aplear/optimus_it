<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%files}}`.
 */
class m190717_191345_create_files_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%files}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'title' => $this->string()->unique(),
            'description' => $this->string(),
            'path' => $this->string()->notNull(),
            'extention' => $this->string(),
            'size' => $this->double(),
            'uploaded_at' => $this->integer()->notNull(),
            'downloaded' => $this->integer()->null(),
        ],$tableOptions);

        $this->addForeignKey(
            'fk-files-user_id',
            'files',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-files-user_id',
            'files'
        );
        $this->dropTable('{{%files}}');
    }
}
