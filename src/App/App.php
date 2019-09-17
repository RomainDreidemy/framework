<?php
namespace App\App;

class App
{
    public static $config;
    public static $db;

    public function __construct()
    {
        $configFile = file_get_contents(__DIR__ . '/../../config/config.json');
        $config = json_decode($configFile);
        self::$config = $config;
    }

    static public function DB_Connect() : void
    {
        $database = self::$config->database;
        try {
            self::$db = new \PDO(
                $database->sgbd . ':host=' . $database->host . ';dbname=' . $database->name . ';charset=utf8;',
                $database->user,
                $database->password,
                [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING
                ]
            );
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    static public function Debug($arg, $mode = 1) :void
    {
        echo '<div style="background: #fda500; padding: 5px; z-index: 1000">';
        $trace = debug_backtrace(); //Fonction prédéfinie qui retourne un array contenant des infos tel que la ligne et le fichier où est éxécuté la fonction

        echo 'Debug demandé dans le fichier ' . $trace[0]['file'] . ' à la ligne ' . $trace[0]['line'];

        if($mode == 1){
            echo '<pre>';
            print_r($arg);
            echo '</pre>';
        } else{
            var_dump($arg);
        }
        echo '</div>';

    }
}