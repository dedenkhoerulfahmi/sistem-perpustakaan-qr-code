<?php

namespace App\Controllers\Books;

use App\Models\BookModel;
use App\Models\BookStockModel;
use App\Models\CategoryModel;
use App\Models\LoanModel;
use App\Models\RackModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\RESTful\ResourceController;
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class BooksController extends ResourceController
{
    protected BookModel $bookModel;
    protected CategoryModel $categoryModel;
    protected RackModel $rackModel;
    protected BookStockModel $bookStockModel;
    protected LoanModel $loanModel;

    public function __construct()
    {
        $this->bookModel = new BookModel;
        $this->categoryModel = new CategoryModel;
        $this->rackModel = new RackModel;
        $this->bookStockModel = new BookStockModel;
        $this->loanModel = new LoanModel;

        helper('upload');
    }

    public function index()
    {
        $itemPerPage = 20;
        $builder = $this->bookModel
            ->select('books.*, book_stock.quantity, categories.name as category, racks.name as rack, racks.floor')
            ->join('book_stock', 'books.id = book_stock.book_id', 'LEFT')
            ->join('categories', 'books.category_id = categories.id', 'LEFT')
            ->join('racks', 'books.rack_id = racks.id', 'LEFT');

        if ($this->request->getGet('search')) {
            $keyword = $this->request->getGet('search');
            $builder->like('title', $keyword, 'both')
                ->orLike('author', $keyword, 'both')
                ->orLike('publisher', $keyword, 'both');
        }

        $books = $builder->paginate($itemPerPage, 'books');

        $data = [
            'books'         => $books,
            'pager'         => $this->bookModel->pager,
            'currentPage'   => $this->request->getVar('page_books') ?? 1,
            'itemPerPage'   => $itemPerPage,
            'search'        => $this->request->getGet('search')
        ];

        return view('books/index', $data);
    }

    // ===================== SHOW BOOK =====================
    public function show($id = null)
    {
        $book = $this->bookModel
            ->select('books.*, book_stock.quantity, categories.name as category, racks.name as rack, racks.floor')
            ->join('book_stock', 'books.id = book_stock.book_id', 'LEFT')
            ->join('categories', 'books.category_id = categories.id', 'LEFT')
            ->join('racks', 'books.rack_id = racks.id', 'LEFT')
            ->where('books.id', $id)
            ->first();

        if (!$book) {
            throw new PageNotFoundException("Book with ID '$id' not found");
        }

        $loans = $this->loanModel->where(['book_id' => $book['id'], 'return_date' => null])->findAll();
        $loanCount = array_sum(array_column($loans, 'quantity'));
        $bookStock = $book['quantity'] - $loanCount;

        return view('books/show', [
            'book'      => $book,
            'loanCount' => $loanCount ?? 0,
            'bookStock' => $bookStock
        ]);
    }

    public function new()
    {
        return view('books/create', [
            'categories' => $this->categoryModel->findAll(),
            'racks'      => $this->rackModel->findAll(),
            'validation' => \Config\Services::validation(),
        ]);
    }

    public function create()
    {
        if (!$this->validate([
            'cover'     => 'is_image[cover]|mime_in[cover,image/jpg,image/jpeg,image/gif,image/png,image/webp]|max_size[cover,5120]',
            'title'     => 'required|string|max_length[127]',
            'author'    => 'required|alpha_numeric_punct|max_length[64]',
            'publisher' => 'required|string|max_length[64]',
            'year'      => 'required|numeric|min_length[4]|max_length[4]|less_than_equal_to[2100]',
            'rack'      => 'required|numeric',
            'category'  => 'required|numeric',
            'stock'     => 'required|numeric|greater_than_equal_to[1]',
            'nomor_induk'   => 'required|string|max_length[50]',
            'tanggal_masuk' => 'required|valid_date',
            'sumber'        => 'permit_empty|string|max_length[100]',
            'harga'         => 'permit_empty|decimal',
            'kondisi'       => 'permit_empty|string|max_length[50]',
        ])) {
            return redirect()->back()->withInput();
        }

        $cover = $this->request->getFile('cover');
        $coverName = $cover->getError() != 4 ? uploadBookCover($cover) : null;

        $this->bookModel->save([
            'slug'          => url_title($this->request->getVar('title') . ' ' . rand(0, 1000), '-', true),
            'title'         => $this->request->getVar('title'),
            'author'        => $this->request->getVar('author'),
            'publisher'     => $this->request->getVar('publisher'),
            'year'          => $this->request->getVar('year'),
            'rack_id'       => $this->request->getVar('rack'),
            'category_id'   => $this->request->getVar('category'),
            'book_cover'    => $coverName,
            'nomor_induk'   => $this->request->getVar('nomor_induk'),
            'tanggal_masuk' => $this->request->getVar('tanggal_masuk'),
            'sumber'        => $this->request->getVar('sumber'),
            'harga'         => $this->request->getVar('harga'),
            'kondisi'       => $this->request->getVar('kondisi'),
        ]);

        $this->bookStockModel->save([
            'book_id'  => $this->bookModel->getInsertID(),
            'quantity' => $this->request->getVar('stock')
        ]);

        session()->setFlashdata('msg', 'Insert new book successful');
        return redirect()->to('admin/books');
    }

    public function edit($slug = null)
{
    $book = $this->bookModel
        ->select('books.*, book_stock.quantity')
        ->join('book_stock', 'books.id = book_stock.book_id', 'LEFT')
        ->where('books.slug', $slug)
        ->first();

    if (!$book) {
        throw new PageNotFoundException("Book with slug '$slug' not found");
    }

    return view('books/edit', [
        'book'       => $book,
        'categories' => $this->categoryModel->findAll(),
        'racks'      => $this->rackModel->findAll(),
        'validation' => \Config\Services::validation(),
    ]);
}

public function update($id = null)
{
    $book = $this->bookModel->where('id', $id)->first();
    if (!$book) {
        throw new PageNotFoundException("Book with ID '$id' not found");
    }

    // Validasi input
    if (!$this->validate([
        'cover'         => 'permit_empty|is_image[cover]|mime_in[cover,image/jpg,image/jpeg,image/png,image/webp]|max_size[cover,5120]',
        'title'         => 'required|string|max_length[127]',
        'author'        => 'required|string|max_length[64]',
        'publisher'     => 'required|string|max_length[64]',
        'year'          => 'required|numeric|exact_length[4]|less_than_equal_to[2100]',
        'rack'          => 'required|numeric',
        'category'      => 'required|numeric',
        'quantity'      => 'required|numeric|greater_than_equal_to[1]',
        'nomor_induk'   => 'required|string|max_length[50]',
        'tanggal_masuk' => 'required|valid_date',
        'sumber'        => 'permit_empty|string|max_length[100]',
        'harga'         => 'permit_empty|decimal',
        'kondisi'       => 'permit_empty|string|max_length[50]',
    ])) {
        return redirect()->back()
            ->withInput()
            ->with('validation', $this->validator)
            ->with('error', true)
            ->with('msg', 'Gagal update data. Periksa input Anda.');
    }

    // Handle cover
    $cover = $this->request->getFile('cover');
    $coverName = ($cover && $cover->getError() !== 4)
        ? updateBookCover($cover, $book['book_cover'])
        : $book['book_cover'];

    // Slug hanya diubah jika judul berubah
    $newTitle = $this->request->getVar('title');
    $slug = ($newTitle !== $book['title'])
        ? url_title($newTitle, '-', true)
        : $book['slug'];

    // Update tabel books
    $this->bookModel->save([
        'id'            => $book['id'],
        'slug'          => $slug,
        'title'         => $newTitle,
        'author'        => $this->request->getVar('author'),
        'publisher'     => $this->request->getVar('publisher'),
        'year'          => $this->request->getVar('year'),
        'rack_id'       => $this->request->getVar('rack'),
        'category_id'   => $this->request->getVar('category'),
        'book_cover'    => $coverName,
        'nomor_induk'   => $this->request->getVar('nomor_induk'),
        'tanggal_masuk' => $this->request->getVar('tanggal_masuk'),
        'sumber'        => $this->request->getVar('sumber'),
        'harga'         => $this->request->getVar('harga'),
        'kondisi'       => $this->request->getVar('kondisi'),
    ]);

    // Update tabel book_stock
    $bookStock = $this->bookStockModel->where('book_id', $book['id'])->first();
    if ($bookStock) {
        $this->bookStockModel->save([
            'id'       => $bookStock['id'],
            'book_id'  => $book['id'],
            'quantity' => $this->request->getVar('quantity'),
        ]);
    }

    // Flash message dan redirect
    session()->setFlashdata('msg', 'Data buku berhasil diupdate');
    return redirect()->to('admin/books');
}


    public function delete($id = null)
    {
        $book = $this->bookModel->where('id', $id)->first();
        if (!$book) throw new PageNotFoundException("Book with ID '$id' not found");

        $bookStock = $this->bookStockModel->where('book_id', $book['id'])->first();

        $this->bookModel->delete($book['id']);
        $this->bookStockModel->delete($bookStock['id']);
        deleteBookCover($book['book_cover']);

        session()->setFlashdata('msg', 'Book deleted successfully');
        return redirect()->to('admin/books');
    }

    // ===================== EXPORT PDF =====================
    public function exportPdf()
    {
        $books = $this->bookModel
            ->select('books.*, book_stock.quantity, categories.name as category, racks.name as rack, racks.floor')
            ->join('book_stock', 'books.id = book_stock.book_id', 'LEFT')
            ->join('categories', 'books.category_id = categories.id', 'LEFT')
            ->join('racks', 'books.rack_id = racks.id', 'LEFT')
            ->findAll();

        $html = view('books/export_pdf', ['books' => $books]);

        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('daftar_buku.pdf', ['Attachment' => 1]);
    }

    // ===================== EXPORT EXCEL =====================
    public function exportExcel()
    {
        $books = $this->bookModel
            ->select('books.*, book_stock.quantity, categories.name as category, racks.name as rack, racks.floor')
            ->join('book_stock', 'books.id = book_stock.book_id', 'LEFT')
            ->join('categories', 'books.category_id = categories.id', 'LEFT')
            ->join('racks', 'books.rack_id = racks.id', 'LEFT')
            ->findAll();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Judul
        $sheet->setCellValue('A1', 'Daftar Buku Perpustakaan');
        $sheet->mergeCells('A1:G1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);

        // Header kolom
        $sheet->setCellValue('A3', 'No');
        $sheet->setCellValue('B3', 'Judul');
        $sheet->setCellValue('C3', 'Penulis');
        $sheet->setCellValue('D3', 'Penerbit');
        $sheet->setCellValue('E3', 'Kategori');
        $sheet->setCellValue('F3', 'Rak');
        $sheet->setCellValue('G3', 'Jumlah');
        $sheet->getStyle('A3:G3')->getFont()->setBold(true);

        // Isi data
        $row = 4;
        $no = 1;
        foreach ($books as $b) {
            $sheet->setCellValue("A{$row}", $no++);
            $sheet->setCellValue("B{$row}", $b['title']);
            $sheet->setCellValue("C{$row}", $b['author']);
            $sheet->setCellValue("D{$row}", $b['publisher']);
            $sheet->setCellValue("E{$row}", $b['category']);
            $sheet->setCellValue("F{$row}", $b['rack'].' (Lt '.$b['floor'].')');
            $sheet->setCellValue("G{$row}", $b['quantity']);
            $row++;
        }

        // Auto-size kolom
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Download file
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'daftar_buku.xlsx';

        // Set header supaya langsung download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
} // ✅ penutup class BooksController
