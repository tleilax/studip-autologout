<?php
class SetupAutologout extends Migration
{
    public function description()
    {
        return 'Creates config entries for automatic logout';
    }
    
    public function up()
    {
        // Add config entries
        $query = "INSERT IGNORE INTO `config`
                    (`config_id`, `field`, `value`, `is_default`, `type`, `range`, `section`,
                     `mkdate`, `chdate`, `description`)
                  VALUES (MD5(:field), :field, :value, 1, :type, :range, :section,
                          UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), :description)";
        $statement = DBManager::get()->prepare($query);
        $statement->execute(array(
            ':field'   => 'AUTOMATIC_LOGOUT_DELAY',
            ':value'   => 60,
            ':type'    => 'integer',
            ':range'   => 'plugin',
            ':section' => 'autologout',
            ':description' => 'Gibt an, nach wieviel Minuten Nutzer automatisch ausgeloggt werden sollen',
        ));        
    }
    
    public function down()
    {
        $query = "DELETE FROM `config` WHERE `field` = 'AUTOMATIC_LOGOUT_DELAY'";
        $statement = DBManager::get()->exec($query);
    }
}
