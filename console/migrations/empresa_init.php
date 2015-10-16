<?php

use yii\db\Schema;

class empresa_init extends \yii\db\Migration
{
	public function init()
	{
		$this->db = 'db2';
		parent::init();
	}
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET latin1 COLLATE latin1_swedish_ci ENGINE=InnoDB';
        }

                // osconfemp
        $this->createTable('{{%osconfemp}}', [
            'coe_id' => Schema::TYPE_PK . " COMMENT 'Configuración'",
            'coe_nombre' => Schema::TYPE_STRING . "(45) NULL COMMENT 'Nombre/Variable'",
            'coe_descri' => Schema::TYPE_STRING . "(60) NULL COMMENT 'Descripción'",
            'coe_tipo' => Schema::TYPE_SMALLINT . "(4) NULL COMMENT 'Tipo de Dato'",
            'coe_data' => Schema::TYPE_TEXT . " NULL",
        ], $this->tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%osconfemp}}');
    }
}
