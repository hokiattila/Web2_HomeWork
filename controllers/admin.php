<?php

use models\Admin_Model;
include(SERVER_ROOT.'models/Admin_Model.php');
require_once 'lib/TCPDF-main/tcpdf.php'; 

require_once __DIR__ . '/../vendor/autoload.php';

// A namespace-ek betöltése
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Admin_Controller {
    public string $baseName;
    private Admin_Model $model;

    public function __construct() {
        $this->baseName = "admin";
        $this->model = new Admin_Model();
    }

    public function main(array $vars): void {
        $users = $this->model->fetchAllUsers();
        $view = new View_Loader($this->baseName . "_main");
        $view->assign("users", $users);
        if($vars != null) {
            if ($vars[0] == "export" && $vars[1] == "pdf")
                $this->exportPDF();
            if ($vars[0] == "export" && $vars[1] == "excel")
                $this->exportExcel();
        }
    }

    private function exportExcel(): void {
        $users = $this->model->fetchAllUsers();

        // PhpSpreadsheet példányosítása
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Fejléc
        $sheet->setCellValue('A1', 'Felhasználónév');
        $sheet->setCellValue('B1', 'Keresztnév');
        $sheet->setCellValue('C1', 'Vezetéknév');
        $sheet->setCellValue('D1', 'Születési dátum');
        $sheet->setCellValue('E1', 'Nem');
        $sheet->setCellValue('F1', 'Csatlakozás dátuma');
        $sheet->setCellValue('G1', 'Email');

        // Felhasználói adatok hozzáadása
        $row = 2;
        foreach ($users as $user) {
            $sheet->setCellValue('A' . $row, $user['username']);
            $sheet->setCellValue('B' . $row, $user['first_name']);
            $sheet->setCellValue('C' . $row, $user['last_name']);
            $sheet->setCellValue('D' . $row, $user['birth_date']);
            $sheet->setCellValue('E' . $row, $user['gender']);
            $sheet->setCellValue('F' . $row, $user['join_date']);
            $sheet->setCellValue('G' . $row, $user['email']);
            $row++;
        }

        // Excel fájl exportálása
        $writer = new Xlsx($spreadsheet);
        $filename = 'users.xlsx';
        $spreadsheet->getProperties()
            ->setCreator('Admin') // A fájl készítője
            ->setTitle('Felhasználói lista')
            ->setSubject('Felhasználói adatok')
            ->setDescription('Ez a fájl a felhasználói adatokat tartalmazza');

        // Fejléc beállítása a fájl letöltéséhez
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        // Fájl kiírása a böngészőbe

        $writer->save('php://output');
        exit();

    }



    public function exportPDF(): void {
        // Felhasználói adatok lekérése
        $users = $this->model->fetchAllUsers();

        // TCPDF objektum inicializálása
        $pdf = new \TCPDF();
        $pdf->AddPage(); // Új oldal hozzáadása

        // Cím beállítása
        $pdf->SetFont('helvetica', 'B', 20);
        $pdf->Cell(0, 10, 'Felhasználói lista', 0, 1, 'C'); // Cím középre igazítva
        $pdf->Ln(10); // Új sor

        // Táblázat fejléc
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->Cell(30, 10, 'Felhasználónév', 1);
        $pdf->Cell(30, 10, 'Keresztnév', 1);
        $pdf->Cell(30, 10, 'Vezetéknév', 1);
        $pdf->Cell(25, 10, 'Születés', 1);
        $pdf->Cell(15, 10, 'Nem', 1);
        $pdf->Cell(25, 10, 'Csatlakozás', 1);
        $pdf->Cell(40, 10, 'Email', 1);
        $pdf->Ln(); // Új sor

        // Adatok kiírása
        $pdf->SetFont('helvetica', '', 8);
        foreach ($users as $user) {
            $pdf->Cell(30, 10, $user['username'], 1);
            $pdf->Cell(30, 10, $user['first_name'], 1);
            $pdf->Cell(30, 10, $user['last_name'], 1);
            $pdf->Cell(25, 10, $user['birth_date'], 1);
            $pdf->Cell(15, 10, $user['gender'], 1);
            $pdf->Cell(25, 10, $user['join_date'], 1);
            $pdf->Cell(40, 10, $user['email'], 1);
            $pdf->Ln(); // Új sor
        }

        // PDF fájl generálása és letöltés
        $pdf->Output('users.pdf', 'D'); // 'D' paraméter a letöltéshez
        exit();
    }

}
