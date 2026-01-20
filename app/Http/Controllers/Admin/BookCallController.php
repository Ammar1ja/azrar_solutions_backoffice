<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\BookCallDatatable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookCallController extends Controller
{
    public function index(BookCallDatatable $dataTable)
    {
        return $dataTable->render('admin.book_call.index');

   
    }
}
