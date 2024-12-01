<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Models\MenuModel;
use App\Models\TransactionDetailModel;
use App\Models\TransactionModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Exceptions\PageNotFoundException;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Html;
use TCPDF;
use Carbon\Carbon;

class AdminTransactionController extends BaseController
{
    protected $menuModel;
    protected $categoryModel;
    protected $transactionModel;

    public function __construct()
    {
        $this->menuModel = new MenuModel();
        $this->categoryModel = new CategoryModel();
        $this->transactionModel = new TransactionModel();
    }

    public function index()
    {
        if (auth()->loggedIn()) {
            $user = auth()->user();
            $user->role = $user->getGroups()[0];
        }

        $data = [
            'title'         => 'Transaction',
            'menuTitle'     => 'Transaction',
            'user'          => $user,
        ];

        return view('dashboard/transaction/index', $data);
    }

    public function get()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'transactions'    => $this->transactionModel->orderBy('transactions.created_at', 'DESC')->findAll(),
            ];

            return $this->response->setJSON([
                'data' => view('dashboard/transaction/data', $data)
            ]);
        } else {
            throw new PageNotFoundException('Sorry, we cannot access the requested page.');
        }
    }

    public function editForm()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            $status = $this->transactionModel->getStatus($id);
            $data = [
                'id'        => $id,
                'status'    => $status['status'],
            ];

            return $this->response->setJSON([
                'success' => view('dashboard/transaction/modal/edit', $data),
            ]);
        } else {
            throw new PageNotFoundException('Sorry, we cannot access the requested page.');
        }
    }

    public function detail($id)
    {
        if (auth()->loggedIn()) {
            $user = auth()->user();
            $user->role = $user->getGroups()[0];
        }

        $transactionDetailModel = new TransactionDetailModel();

        $details = $transactionDetailModel->getById($id);

        $data = [
            'title'         => 'Transaction',
            'menuTitle'     => 'Transaction',
            'user'          => $user,
            'details'       => $details
        ];

        return view('dashboard/transaction/detail', $data);
    }

    public function getDetail()
    {
        if ($this->request->isAJAX()) {
            $data = $this->request->getPost('data');
            $transaction = $this->transactionModel->getById($data[0]['transaction_id']);

            $data = [
                'details'    =>  $data,
                'transaction' => $transaction
            ];

            return $this->response->setJSON([
                'data' => view('dashboard/transaction/detailData', $data)
            ]);
        } else {
            throw new PageNotFoundException('Sorry, we cannot access the requested page.');
        }
    }

    public function update()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getPost('id');
            $status = $this->request->getPost('status');

            if ($this->transactionModel->updateStatus($id, $status)) {
                return $this->response->setJSON(['success' => 'Transaction status has been updated successfully.']);
            } else {
                return $this->response->setJSON(['error' => 'Failed tp update transaction status.']);
            }
        } else {
            throw new PageNotFoundException('Sorry, we cannot access the requested page.');
        }
    }

    public function report()
    {
        $data = [
            'transactions'    => $this->transactionModel->getAllData(),
        ];

        return view('dashboard/transaction/report', $data);
    }

    public function reportPdf()
    {
        $date = date("Ymd");

        $spreadsheet = new Spreadsheet();
        $this->_createTable($spreadsheet);

        // Menghasilkan HTML dari Spreadsheet
        $htmlWriter = new Html($spreadsheet);
        ob_start();
        $htmlWriter->save('php://output');
        $htmlContent = ob_get_clean();

        // Mengatur TCPDF dengan orientasi Landscape
        $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Waroeng Rindu');
        $pdf->SetTitle('Laporan Transaksi');
        $pdf->SetSubject('Transaksi');

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->SetMargins(10, 10, 10);
        $pdf->AddPage('L');

        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 10, 'Transaction Report', 0, 1, 'C');
        $pdf->Ln(5);

        $pdf->SetFont('helvetica', '', 10);
        $pdf->writeHTML($htmlContent, true, false, true, false, '');

        $pdf->Output('Laporan_Penjualan_' . $date . '.pdf', 'I');
        exit();
    }

    public function reportExcel()
    {
        $date = date("Ymd");
        $spreadsheet = new Spreadsheet();
        $this->_createTable($spreadsheet);

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Laporan_Penjualan_' . $date . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();
    }

    private function _createTable($spreadsheet)
    {
        $transactions = $this->transactionModel->getAllData();
        $activeWorksheet = $spreadsheet->getActiveSheet();

        // Header
        $activeWorksheet->setCellValue('A1', 'No');
        $activeWorksheet->setCellValue('B1', 'Order ID');
        $activeWorksheet->setCellValue('C1', 'Customer');
        $activeWorksheet->setCellValue('D1', 'Order Time');
        $activeWorksheet->setCellValue('E1', 'Payment Method');
        $activeWorksheet->setCellValue('F1', 'Courier');
        $activeWorksheet->setCellValue('G1', 'Delivery Fee');
        $activeWorksheet->setCellValue('H1', 'Total Price');
        $activeWorksheet->setCellValue('I1', 'Status');

        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFF']],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => '257180']],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ];
        $activeWorksheet->getStyle('A1:I1')->applyFromArray($headerStyle);

        $row = 2;
        foreach ($transactions as $index => $item) {
            $status = strtolower($item['status']);
            $bgColor = 'FFEB9C'; // Default Kuning
            if (strpos($status, 'finish') !== false) $bgColor = 'C6EFCE'; // Hijau
            if (strpos($status, 'cancel') !== false || strpos($status, 'fail') !== false) $bgColor = 'FFC7CE'; // Merah

            $activeWorksheet->setCellValue("A{$row}", $index + 1);
            $activeWorksheet->setCellValue("B{$row}", $item['id']);
            $activeWorksheet->setCellValue("C{$row}", $item['fullname']);
            $activeWorksheet->setCellValue("D{$row}", Carbon::parse($item['created_at'])->format('d M Y, h:i'));
            $activeWorksheet->setCellValue("E{$row}", strtoupper(str_replace('_', ' ', $item['payment_method'])));
            $activeWorksheet->setCellValue("F{$row}", strtoupper($item['courier']) . ' - ' . $item['courier_service']);
            $activeWorksheet->setCellValue("G{$row}", number_to_currency($item['delivery_fee'], 'IDR', 'id_ID'));
            $activeWorksheet->setCellValue("H{$row}", number_to_currency($item['total_price'], 'IDR', 'id_ID'));
            $activeWorksheet->setCellValue("I{$row}", ucfirst($item['status']));

            $activeWorksheet->getStyle("I{$row}")->applyFromArray([
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => $bgColor]],
                'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
            ]);

            $rowStyle = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ];
            $activeWorksheet->getStyle('A' . $row . ':I' . $row)->applyFromArray($rowStyle);

            $row++;
        }

        foreach (range('A', 'I') as $col) {
            $activeWorksheet->getColumnDimension($col)->setAutoSize(true);
        }
    }
}
