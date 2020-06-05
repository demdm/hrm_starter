<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%social_network_photo}}`.
 */
class m200529_192132_create_social_network_photo_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%social_network_photo}}', [
            'id' => $this->primaryKey(),
            'social_network_account_id' => $this->integer()->notNull(),
            'social_network_photo_id' => $this->string()->null(),
            'filename' => $this->string()->null(),
            'file_caption' => $this->string()->null(),
            'hash_tags' => $this->text(),
            'is_skipped' => $this->boolean()->null()->defaultValue(null),
            'skip_message' => $this->string()->null(),
            'posted_at' => $this->dateTime()->null(),
            'created_at' => $this->dateTime()->defaultExpression('NOW()')->notNull(),
        ]);

        $this->addForeignKey(
            'fk__social_network_photo__social_network_account_id',
            '{{%social_network_photo}}',
            'social_network_account_id',
            '{{%social_network_account}}',
            'id',
            'cascade',
            'cascade'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk__social_network_photo__social_network_account_id',
            '{{%social_network_photo}}'
        );

        $this->dropTable('{{%social_network_photo}}');
    }
}
