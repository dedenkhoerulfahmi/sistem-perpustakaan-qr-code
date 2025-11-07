<?php

namespace App\Controllers\Visitors;

use App\Controllers\BaseController;
use App\Models\VisitorsModel;
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class VisitorsController extends BaseController
{
    protected $visitorsModel;

    public function __construct()
    {
        $this->visitorsModel = new VisitorsModel();
    }

    public function index()
    {
        $data['visitors'] = $this->visitorsModel
    ->orderBy('visit_date', 'DESC')
    ->orderBy('visit_time', 'DESC')
    ->findAll();

        return view('visitors/index', $data);
    }

    public function create()
    {
        return view('visitors/create');
    }

    public function store()
    {
        $data = [
            'name'       => $this->request->getPost('name'),
            'kelas'      => $this->request->getPost('kelas'),
            'jurusan'    => $this->request->getPost('jurusan'),
            'visit_date' => $this->request->getPost('visit_date'),
            'visit_time' => $this->request->getPost('visit_time'),
        ];

        $this->visitorsModel->insert($data);
        return redirect()->to('/admin/visitors')->with('success', 'Pengunjung berhasil ditambahkan.');
    }

    public function show($id)
    {
        $visitor = $this->visitorsModel->find($id);
        if (!$visitor) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Pengunjung dengan ID $id tidak ditemukan.");
        }

        return view('visitors/show', ['visitor' => $visitor]);
    }

    public function exportForm()
    {
        return view('visitors/export_form');
    }

    public function export()
    {
        $month  = $this->request->getPost('month');
        $format = $this->request->getPost('format');

        if (!$month || !$format) {
            return redirect()->back()->with('error', 'Semua field harus diisi.');
        }

        $startDate = "$month-01";
        $endDate   = date('Y-m-t', strtotime($month));

        $visitors = $this->visitorsModel
            ->where("visit_date >=", $startDate)
            ->where("visit_date <=", $endDate)
            ->findAll();

        if ($format === 'pdf') {
            $dompdf = new Dompdf();

            $html = view('visitors/pdf_template', [
                'visitors'    => $visitors,
                'selected_month' => $month
            ], ['saveData' => false]);

            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            while (ob_get_level()) {
                ob_end_clean();
            }

            $dompdf->stream("kunjungan_{$month}.pdf", ['Attachment' => true]);
            exit;
        }

        if ($format === 'excel') {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->setCellValue('A1', 'Nama');
            $sheet->setCellValue('B1', 'Kelas');
            $sheet->setCellValue('C1', 'Jurusan');
            $sheet->setCellValue('D1', 'Tanggal');
            $sheet->setCellValue('E1', 'Jam');

            $row = 2;
            foreach ($visitors as $v) {
                $sheet->setCellValue("A$row", $v['name']);
                $sheet->setCellValue("B$row", $v['kelas']);
                $sheet->setCellValue("C$row", $v['jurusan']);
                $sheet->setCellValue("D$row", $v['visit_date']);
                $sheet->setCellValue("E$row", $v['visit_time']);
                $row++;
            }

            $sheet->setCellValue("D$row", 'Total Pengunjung:');
            $sheet->setCellValue("E$row", count($visitors));

            $writer = new Xlsx($spreadsheet);
            $filename = "kunjungan_{$month}.xlsx";

            while (ob_get_level()) {
                ob_end_clean();
            }

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header("Content-Disposition: attachment; filename=\"$filename\"");
            $writer->save('php://output');
            exit;
        }

        return redirect()->back()->with('error', 'Format tidak dikenali.');
    }
}
