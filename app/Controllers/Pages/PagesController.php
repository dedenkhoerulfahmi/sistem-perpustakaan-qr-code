<?php

namespace App\Controllers\Pages;

use App\Controllers\BaseController;

class PagesController extends BaseController
{
    public function profil()
    {
        return view('pages/profil');
    }

    public function about()
    {
        return view('pages/about');
    }
}
