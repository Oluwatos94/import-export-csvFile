<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Imports\UsersImport;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Display a listing of the resource
     *
     * @return \Illuminate\Support\Collection
     */
    public function index()
    {
        $users = User::get();
        return view('users', compact('users'));
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function import(Request $request)
    {
        // validate incoming request data
        $request->validate([
            'file' => 'required|max:2048'
        ]);

        Excel::import(new UsersImport, $request->file('file'));
        return back()->with('success', 'Users imported successfully');
    }
}
