<?php
namespace App\Exportation\Bdd;

use App\App\App;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Bdd
{
    static public function export()
    {
        // Retrouve toutes les tables
        $select = App::$db->query("SHOW TABLES FROM " . App::DB_DATABASE);
        $tables = $select->fetchAll(\PDO::FETCH_NUM);

        $result = [];
        
        foreach($tables as $t){
            // Retrouver les colonnes
            $select = App::$db->query("SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = 'framework' AND TABLE_NAME = '" . $t[0] . "'");
            $colonnes = $select->fetchAll(\PDO::FETCH_NUM);

            foreach($colonnes as $c){
                $col[] = $c[0];
            }

            $select = App::$db->query('SELECT * FROM ' . $t[0]);
            $lignes = $select->fetchAll(\PDO::FETCH_NUM);

            array_unshift($lignes, $col);
            unset($col);

            $result[$t[0]] = $lignes;
        }

        return $result;
    }

    static public function excel()
    {
        $bdd = self::export();
        $spreadsheet = new Spreadsheet();

        foreach($bdd as $name => $b){
            $myWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, $name);
            $workSheet = $spreadsheet->addSheet($myWorkSheet, 0);
            $workSheet->fromArray($b);
        }

        $sheetIndex = $spreadsheet->getIndex(
            $spreadsheet->getSheetByName('Worksheet')
        );
        $spreadsheet->removeSheetByIndex($sheetIndex);


        $writer = new Xlsx($spreadsheet);
        $writer->save(__DIR__ . '/../../../public/assets/export/export-base-de-donnee-' . date("d-m-Y") . '.xlsx');
        App::Debug($bdd);
    }
}
