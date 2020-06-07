<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%social_network_account}}`.
 */
class m200527_201650_create_social_network_account_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%social_network_account}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'comment' => $this->text(),
            'hash_tags' => $this->text(),
            'login' => $this->string()->notNull(),
            'password' => $this->string()->notNull(),
            'count_published' => $this->integer()->defaultValue(0),
            'count_likes' => $this->integer()->defaultValue(0),
            'count_subscribers' => $this->integer()->defaultValue(0),
            'is_active' => $this->boolean()->defaultValue(false),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%social_network_account}}');
    }
}
