<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%route}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%city}}`
 * - `{{%country}}`
 */
class m190911_140638_create_route_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%route}}', [
            'id' => $this->primaryKey(),
            'city_id' => $this->integer()->notNull(),
            'country_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `city_id`
        $this->createIndex(
            '{{%idx-route-city_id}}',
            '{{%route}}',
            'city_id'
        );

        // add foreign key for table `{{%city}}`
        $this->addForeignKey(
            '{{%fk-route-city_id}}',
            '{{%route}}',
            'city_id',
            '{{%city}}',
            'id',
            'CASCADE'
        );

        // creates index for column `country_id`
        $this->createIndex(
            '{{%idx-route-country_id}}',
            '{{%route}}',
            'country_id'
        );

        // add foreign key for table `{{%country}}`
        $this->addForeignKey(
            '{{%fk-route-country_id}}',
            '{{%route}}',
            'country_id',
            '{{%country}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%city}}`
        $this->dropForeignKey(
            '{{%fk-route-city_id}}',
            '{{%route}}'
        );

        // drops index for column `city_id`
        $this->dropIndex(
            '{{%idx-route-city_id}}',
            '{{%route}}'
        );

        // drops foreign key for table `{{%country}}`
        $this->dropForeignKey(
            '{{%fk-route-country_id}}',
            '{{%route}}'
        );

        // drops index for column `country_id`
        $this->dropIndex(
            '{{%idx-route-country_id}}',
            '{{%route}}'
        );

        $this->dropTable('{{%route}}');
    }
}
