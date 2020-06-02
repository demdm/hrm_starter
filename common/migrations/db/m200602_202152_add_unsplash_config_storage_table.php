<?php

use yii\db\Migration;

/**
 * Class m200602_202152_add_unsplash_config_storage_table
 */
class m200602_202152_add_unsplash_config_storage_table extends Migration
{
    public function up()
    {
        $this->insert('{{%key_storage_item}}', [
            'key' => 'unsplash.access_key',
            'value' => 'Pd6OGMbjrvdxbNctPqTWHVqzfNFXPQ2E-xAhFtad4ME'
        ]);
        $this->insert('{{%key_storage_item}}', [
            'key' => 'unsplash.secret_key',
            'value' => 'aEX1Z-433J6LSXEeNO1QJj5xIikC5wdP6a8WqreKsQM'
        ]);
        $this->insert('{{%key_storage_item}}', [
            'key' => 'unsplash.app_name',
            'value' => 'Insta'
        ]);
    }

    public function down()
    {
        $this->delete('{{%key_storage_item}}', [
            'key' => [
                'unsplash.access_key',
                'unsplash.secret_key',
                'unsplash.app_name',
            ],
        ]);
    }
}
