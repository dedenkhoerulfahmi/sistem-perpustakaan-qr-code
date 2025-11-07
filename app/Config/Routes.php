<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;
use Config\Services;

/**
 * @var RouteCollection $routes
 */
$routes = Services::routes();

// Default setup
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();

// Default route
$routes->get('/', 'Home::index');
$routes->get('/book', 'Home::book');

// Halaman publik tambahan
$routes->get('profil', 'Pages\PagesController::profil');
$routes->get('about', 'Pages\PagesController::about');

// Auth routes
service('auth')->routes($routes);

// Admin routes
$routes->group('admin', ['filter' => 'session'], static function ($routes) {

    // Dashboard
    $routes->get('/', 'Dashboard\DashboardController');
    $routes->get('dashboard', 'Dashboard\DashboardController::dashboard');

    // Members (Siswa)
    $routes->resource('members', ['controller' => 'Members\MembersController']);
    $routes->get('members/(:any)/edit', 'Members\MembersController::edit/$1');
    $routes->put('members/(:any)', 'Members\MembersController::update/$1');

    // Teachers (Guru)
    $routes->get('teachers/new', 'Teachers\TeachersController::new');
    $routes->post('teachers', 'Teachers\TeachersController::store');
    $routes->get('teachers/(:num)/edit', 'Teachers\TeachersController::edit/$1');
    $routes->put('teachers/(:num)', 'Teachers\TeachersController::update/$1');
    $routes->delete('teachers/(:num)', 'Teachers\TeachersController::delete/$1');

    // Books
// 👇 letakkan export di atas resource
$routes->get('books/export-pdf', 'Books\BooksController::exportPdf');
$routes->get('books/export-excel', 'Books\BooksController::exportExcel');
$routes->put('books/(:num)', 'Books\BooksController::update/$1');
$routes->resource('books', ['controller' => 'Books\BooksController']);
$routes->resource('categories', ['controller' => 'Books\CategoriesController']);
$routes->resource('racks', ['controller' => 'Books\RacksController']);


    // Loans
    $routes->get('loans/new/members/search', 'Loans\LoansController::searchMember');
    $routes->get('loans/new/books/search', 'Loans\LoansController::searchBook');
    $routes->get('loans/new', 'Loans\LoansController::new');       // Tampilkan form
    $routes->post('loans/new', 'Loans\LoansController::create');   // Simpan data
    $routes->resource('loans', ['controller' => 'Loans\LoansController']);

    // Returns
    $routes->get('returns/new/search', 'Loans\ReturnsController::searchLoan');
    $routes->resource('returns', ['controller' => 'Loans\ReturnsController']);

    // Fines
    $routes->get('fines/returns/search', 'Loans\FinesController::searchReturn');
    $routes->get('fines/pay/(:any)', 'Loans\FinesController::pay/$1');
    $routes->resource('fines/settings', [
        'controller' => 'Loans\FineSettingsController',
        'filter' => 'group:superadmin'
    ]);
    $routes->resource('fines', ['controller' => 'Loans\FinesController']);

    // Users
    $routes->group('users', ['filter' => 'group:superadmin'], static function ($routes) {
        $routes->get('new', 'Users\RegisterController::index');
        $routes->post('', 'Users\RegisterController::registerAction');
    });
    $routes->resource('users', [
        'controller' => 'Users\UsersController',
        'filter' => 'group:superadmin'
    ]);

    // Visitors
    $routes->get('visitors', 'Visitors\VisitorsController::index');
    $routes->get('visitors/create', 'Visitors\VisitorsController::create');
    $routes->post('visitors/store', 'Visitors\VisitorsController::store');
    $routes->get('visitors/show/(:num)', 'Visitors\VisitorsController::show/$1');
    $routes->get('visitors/export', 'Visitors\VisitorsController::exportForm');
    $routes->post('visitors/export', 'Visitors\VisitorsController::export');
    $routes->resource('visitors', ['controller' => 'Visitors\VisitorsController']);
});

// Additional environment routes
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
