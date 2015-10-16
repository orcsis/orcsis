<?php

use yii\db\Schema;

class orcsis_init extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET latin1 COLLATE latin1_swedish_ci ENGINE=InnoDB';
        }

        // osasignarol
        $this->createTable('{{%osasignarol}}', [
            'item_name' => Schema::TYPE_STRING . "(64) NOT NULL COMMENT 'Nombre del Rol'",
            'user_id' => Schema::TYPE_INTEGER . "(11) NOT NULL COMMENT 'Id del Usuario'",
            'created_at' => Schema::TYPE_INTEGER . "(11) NULL COMMENT 'Fecha de Creación'",
            'PRIMARY KEY (item_name, user_id)',
        ], $this->tableOptions);

        // osempresas
        $this->createTable('{{%osempresas}}', [
            'emp_codigo' => Schema::TYPE_PK . " COMMENT 'Código de Empresa'",
            'emp_nombre' => Schema::TYPE_STRING . "(50) NULL COMMENT 'Nombre de Empresa'",
            'emp_datos' => Schema::TYPE_STRING . "(20) NULL COMMENT 'Base de Datos de la Empresa'",
            'emp_estado' => Schema::TYPE_BOOLEAN . " NULL DEFAULT '1' COMMENT 'Activo'",
        ], $this->tableOptions);

        // osgrupos
        $this->createTable('{{%osgrupos}}', [
            'gru_id' => Schema::TYPE_PK . " COMMENT 'ID de Grupo de Usuarios'",
            'gru_nombre' => Schema::TYPE_STRING . "(45) NULL COMMENT 'Nombre de Grupo'",
        ], $this->tableOptions);

        // osmenu
        $this->createTable('{{%osmenu}}', [
            'men_id' => Schema::TYPE_PK . " COMMENT 'Código de Menú'",
            'men_nombre' => Schema::TYPE_STRING . "(64) NULL COMMENT 'Nombre'",
            'men_parent' => Schema::TYPE_INTEGER . "(11) NULL COMMENT 'Menú padre'",
            'men_descri' => Schema::TYPE_STRING . "(64) NULL COMMENT 'Descripción'",
            'men_modulo' => Schema::TYPE_STRING . "(64) NULL COMMENT 'Modulo'",
            'men_url' => Schema::TYPE_STRING . "(64) NULL COMMENT 'Url'",
            'men_orden' => Schema::TYPE_INTEGER . "(11) NULL",
            'men_data' => Schema::TYPE_TEXT . " NULL",
        ], $this->tableOptions);

        // osopctab
        $this->createTable('{{%osopctab}}', [
            'opt_id' => Schema::TYPE_PK,
            'opt_tabla' => Schema::TYPE_STRING . "(45) NULL COMMENT 'Tabla'",
            'opt_campo' => Schema::TYPE_STRING . "(45) NULL COMMENT 'Campo'",
            'opt_opcion' => Schema::TYPE_SMALLINT . "(4) NULL COMMENT 'Opción'",
            'opt_descri' => Schema::TYPE_STRING . "(60) NULL COMMENT 'Descripción'",
            'opt_dato' => Schema::TYPE_STRING . "(45) NULL COMMENT 'Dato Opcional'",
        ], $this->tableOptions);

        // osreglaneg
        $this->createTable('{{%osreglaneg}}', [
            'name' => Schema::TYPE_STRING . "(64) NOT NULL COMMENT 'Nombre de la Regla de negocio'",
            'data' => Schema::TYPE_TEXT . " NULL COMMENT 'Contenido de la Regla de negocio'",
            'created_at' => Schema::TYPE_INTEGER . "(11) NULL COMMENT 'Creado'",
            'updated_at' => Schema::TYPE_INTEGER . "(11) NULL COMMENT 'Modificado'",
            'PRIMARY KEY (name)',
        ], $this->tableOptions);

    // osrolhijo
        $this->createTable('{{%osrol}}', [
            'name' => Schema::TYPE_STRING . "(64) NOT NULL COMMENT 'Nombre del Rol'",
            'type' => Schema::TYPE_INTEGER . "(11) NOT NULL COMMENT 'Tipo'",
            'description' => Schema::TYPE_TEXT . " NULL COMMENT 'Descripción'",
            'rule_name' => Schema::TYPE_STRING . "(64) NULL COMMENT 'Regla de Negocio'",
            'data' => Schema::TYPE_TEXT . " NULL COMMENT 'Data Adicional'",
            'created_at' => Schema::TYPE_INTEGER . "(11) NULL COMMENT 'Creado'",
            'updated_at' => Schema::TYPE_INTEGER . "(11) NULL COMMENT 'Modificado'",
            'PRIMARY KEY (name)',
        ], $this->tableOptions);

        // osrolhijo
        $this->createTable('{{%osrolhijo}}', [
            'parent' => Schema::TYPE_STRING . "(64) NOT NULL",
            'child' => Schema::TYPE_STRING . "(64) NOT NULL",
            'PRIMARY KEY (parent, child)',
        ], $this->tableOptions);

        // ossession
        $this->createTable('{{%ossession}}', [
            'id' => Schema::TYPE_STRING . "(64) NOT NULL",
            'expire' => Schema::TYPE_INTEGER . "(11) NULL",
            'data' => Schema::TYPE_BINARY . " NULL",
            'PRIMARY KEY (id)',
        ], $this->tableOptions);

        // osusuarios
        $this->createTable('{{%osusuarios}}', [
            'usu_id' => Schema::TYPE_PK . " COMMENT 'Id de Usuario'",
            'usu_nomusu' => Schema::TYPE_STRING . "(64) NOT NULL COMMENT 'Nombre de Usuario'",
            'usu_nombre' => Schema::TYPE_STRING . "(64) NOT NULL DEFAULT '' COMMENT 'Nombre Completo del Usuario'",
            'usu_clave' => Schema::TYPE_STRING . "(64) NOT NULL COMMENT 'Contraseña'",
            'usu_feccre' => Schema::TYPE_DATETIME . " NULL COMMENT 'Fecha de Creación'",
            'usu_ulting' => Schema::TYPE_DATETIME . " NULL COMMENT 'Último Ingreso'",
            'usu_activo' => Schema::TYPE_INTEGER . "(11) NULL COMMENT 'Estado del Usuario'",
            'usu_token' => Schema::TYPE_STRING . "(45) NULL COMMENT 'Token de autenticación API'",
            'usu_ultemp' => Schema::TYPE_INTEGER . "(11) NULL COMMENT 'Última Empresa ingresada'",
            'usu_foto' => Schema::TYPE_BINARY . " NULL COMMENT 'Fotografía del Usuario'",
            'usu_name' => Schema::TYPE_STRING . "(64) NULL COMMENT 'Nombre de la Fotografía'",
            'usu_type' => Schema::TYPE_STRING . "(64) NULL COMMENT 'Tipo de Archivo'",
            'usu_size' => Schema::TYPE_STRING . "(64) NULL COMMENT 'Tamaño del Archivo'",
        ], $this->tableOptions);

        // fk: osasignarol
        $this->addForeignKey('fk_osasignarol_item_name', '{{%osasignarol}}', 'item_name', '{{%osrol}}', 'name');

        // fk: osmenu
        $this->addForeignKey('fk_osmenu_men_parent', '{{%osmenu}}', 'men_parent', '{{%osmenu}}', 'men_id');

        // fk: osrol
        $this->addForeignKey('fk_osrol_rule_name', '{{%osrol}}', 'rule_name', '{{%osreglaneg}}', 'name');

        // fk: osrolhijo
        $this->addForeignKey('fk_osrolhijo_child', '{{%osrolhijo}}', 'child', '{{%osrol}}', 'name');
        $this->addForeignKey('fk_osrolhijo_parent', '{{%osrolhijo}}', 'parent', '{{%osrol}}', 'name');

        // fk: osusuarios
        $this->addForeignKey('fk_osusuarios_usu_ultemp', '{{%osusuarios}}', 'usu_ultemp', '{{%osempresas}}', 'emp_codigo');
    }

    public function down()
    {
        $this->dropTable('{{%osasignarol}}'); // fk: item_name
        $this->dropTable('{{%osempresas}}');
        $this->dropTable('{{%osgrupos}}');
        $this->dropTable('{{%osmenu}}'); // fk: men_parent
        $this->dropTable('{{%osopctab}}');
        $this->dropTable('{{%osreglaneg}}');
        $this->dropTable('{{%osrol}}'); // fk: rule_name
        $this->dropTable('{{%osrolhijo}}'); // fk: child, parent
        $this->dropTable('{{%ossession}}');
        $this->dropTable('{{%osusuarios}}'); // fk: usu_ultemp
    }
}
