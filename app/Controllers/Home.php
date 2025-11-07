<?php

namespace App\Controllers;

use App\Models\BookModel;
use App\Models\MemberModel;

class Home extends BaseController
{
    protected BookModel $bookModel;
    protected MemberModel $memberModel;

    public function __construct()
    {
        $this->bookModel   = model(BookModel::class);
        $this->memberModel = model(MemberModel::class);
    }

    public function index(): string
    {
        $bookCount   = $this->bookModel->countAll();
        $memberCount = $this->memberModel->countAll();

        $data = [
            'bookCount'   => $bookCount,
            'staffCount'  => 0, // bisa diisi nanti kalau ada model staff
            'memberCount' => $memberCount
        ];

        return view('home/home', $data);
    }

    public function book(): string
    {
        $itemPerPage = 20;
        $keyword     = $this->request->getGet('search');

        $query = $this->bookModel
            ->select('books.*, book_stock.quantity, categories.name as category, racks.name as rack, racks.floor')
            ->join('book_stock', 'books.id = book_stock.book_id', 'LEFT')
            ->join('categories', 'books.category_id = categories.id', 'LEFT')
            ->join('racks', 'books.rack_id = racks.id', 'LEFT');

        if ($keyword) {
            $books = $query
                ->like('title', $keyword, insensitiveSearch: true)
                ->orLike('slug', $keyword, insensitiveSearch: true)
                ->orLike('author', $keyword, insensitiveSearch: true)
                ->orLike('publisher', $keyword, insensitiveSearch: true)
                ->paginate($itemPerPage, 'books');

            $books = array_filter($books, fn($book) => $book['deleted_at'] === null);
        } else {
            $books = $query->paginate($itemPerPage, 'books');
        }

        $data = [
            'books'         => $books,
            'pager'         => $this->bookModel->pager,
            'currentPage'   => $this->request->getVar('page_books') ?? 1,
            'itemPerPage'   => $itemPerPage,
            'search'        => $keyword
        ];

        return view('home/book', $data);
    }
}
