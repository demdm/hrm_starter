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
            'type' => $this->string()->notNull(),
            'login' => $this->string()->notNull(),
            'password' => $this->string()->notNull(),
            'extra' => $this->json()->null(),
            'count_published' => $this->integer()->defaultValue(0),
            'count_skipped' => $this->integer()->defaultValue(0),
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
