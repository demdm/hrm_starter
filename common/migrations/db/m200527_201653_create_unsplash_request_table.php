<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%unsplash_request}}`.
 */
class m200527_201653_create_unsplash_request_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // setting

        $this->createTable('{{%unsplash_search_photo_setting}}', [
            'id' => $this->primaryKey(),
            'social_network_account_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'search' => $this->string()->notNull(), //по какому слову ищем
            'per_page' => $this->integer()->notNull(),
            'orientation' => $this->string()->null(), //"landscape", "portrait", "squarish"
            'collections' => $this->string()->null(), //multiple, comma-separated
            'comment' => $this->text(),
            'is_active' => $this->boolean()->defaultValue(false),
            'is_finished' => $this->boolean()->defaultValue(false),
        ]);

        $this->addForeignKey(
            'fk__unsplash_search_photo_setting__social_network_account_id',
            '{{%unsplash_search_photo_setting}}',
            'social_network_account_id',
            '{{%social_network_account}}',
            'id',
            'cascade',
            'cascade'
        );

        $this->createIndex(
            'idx__search',
            '{{%unsplash_search_photo_setting}}',
            'search'
        );


        // request

        $this->createTable('{{%unsplash_search_photo_request}}', [
            'id' => $this->primaryKey(),
            'setting_id' => $this->integer()->notNull(),
            'page' => $this->integer()->notNull(),
            'count_result' => $this->integer()->defaultValue(0)->notNull(),
            'created_at' => $this->dateTime()->defaultExpression('NOW()')->notNull(),
        ]);

        $this->addForeignKey(
            'fk__unsplash_search_photo_request__setting_id',
            '{{%unsplash_search_photo_request}}',
            'setting_id',
            '{{%unsplash_search_photo_setting}}',
            'id',
            'cascade',
            'cascade'
        );


        // photo

        $this->createTable('{{%unsplash_search_photo}}', [
            'id' => $this->primaryKey(),
            'setting_id' => $this->integer()->notNull(),
            'request_id' => $this->integer()->notNull(),
            'unsplash_id' => $this->string()->unique()->notNull(),
            'raw_url' => $this->text()->notNull(),
            'description' => $this->text()->null(),
            'width' => $this->integer()->null(),
            'height' => $this->integer()->null(),
            'downloaded_at' => $this->dateTime()->null(),
            'created_at' => $this->dateTime()->defaultExpression('NOW()')->notNull(),
        ]);

        $this->createIndex(
            'idx__created_at',
            '{{%unsplash_search_photo}}',
            'created_at'
        );
        $this->createIndex(
            'idx__downloaded_at',
            '{{%unsplash_search_photo}}',
            'downloaded_at'
        );

        $this->addForeignKey(
            'fk__unsplash_search_photo__setting_id',
            '{{%unsplash_search_photo}}',
            'setting_id',
            '{{%unsplash_search_photo_setting}}',
            'id',
            'cascade',
            'cascade'
        );
        $this->addForeignKey(
            'fk__unsplash_search_photo__request_id',
            '{{%unsplash_search_photo}}',
            'request_id',
            '{{%unsplash_search_photo_request}}',
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
            'fk__unsplash_search_photo_setting__social_network_account_id',
            '{{%unsplash_search_photo_setting}}'
        );
        $this->dropForeignKey(
            'fk__unsplash_search_photo__setting_id',
            '{{%unsplash_search_photo}}'
        );
        $this->dropForeignKey(
            'fk__unsplash_search_photo__request_id',
            '{{%unsplash_search_photo}}'
        );
        $this->dropForeignKey(
            'fk__unsplash_search_photo_request__setting_id',
            '{{%unsplash_search_photo_request}}'
        );

        $this->dropIndex('idx__created_at','{{%unsplash_search_photo}}');
        $this->dropIndex('idx__downloaded_at','{{%unsplash_search_photo}}');
        $this->dropIndex('idx__search', '{{%unsplash_search_photo_setting}}');

        $this->dropTable('{{%unsplash_search_photo}}');
        $this->dropTable('{{%unsplash_search_photo_request}}');
        $this->dropTable('{{%unsplash_search_photo_setting}}');
    }
}
