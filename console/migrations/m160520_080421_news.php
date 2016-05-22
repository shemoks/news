<?php

use yii\db\Migration;

class m160520_080421_news extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('news', [
            'id'          => $this->primaryKey(),
            'title'       => $this->string()->notNull(),
            'description' => $this->text(),
            'created_at'  => $this->timestamp()->notNull(),
            'updated_at'  => $this->timestamp()->notNull(),
            'is_deleted'  => $this->smallInteger()->defaultValue(0),
            'id_user'     => $this->integer()->notNull(),
            'date_begin'  => $this->timestamp()->notNull(),
            'date_end'    => $this->timestamp()->notNull(),
            'place'       => $this->string()->notNull(),
            'latitude'    => $this->integer()->notNull(),
            'longitude'   => $this->integer()->notNull(),
        ], $tableOptions);
        $this->addForeignKey('FK_news_user', 'news', 'id_user', 'user', 'id');
    }

    public function down()
    {
        $this->dropTable('news');
    }
}
