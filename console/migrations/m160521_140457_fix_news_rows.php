<?php

use yii\db\Migration;

class m160521_140457_fix_news_rows extends Migration
{
    public function up()
    {
        $this->dropColumn('news', 'latitude');
        $this->dropColumn('news', 'longitude');
        $this->addColumn('news', 'latitude', $this->string());
        $this->addColumn('news', 'longitude', $this->string());
    }

    public function down()
    {
        $this->dropColumn('news', 'latitude');
        $this->dropColumn('news', 'longitude');
        $this->addColumn('news', 'latitude', $this->integer());
        $this->addColumn('news', 'longitude', $this->integer());
    }
}
