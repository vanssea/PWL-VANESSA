<?php

// Modifikasi 
namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Tambah data user dengan Eloquent Model
        $data = [
            'nama' => 'Pelanggan Pertama',
        ];
        UserModel::where('username', 'customer-1')->update($data); // Update data user

        // Coba akses model UserModel
        $user = UserModel::all(); // Ambil semua data dari tabel m_user
        return view('user', ['data' => $user]);
    }
}

// namespace App\Http\Controllers;

// use App\Models\UserModel;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Hash;

// class UserController extends Controller
// {
//     public function index()
//     {
//         // Tambah data user dengan Eloquent Model
//         $data = [
//             'username' => 'customer-1',
//             'nama' => 'Pelanggan',
//             'password' => Hash::make('12345'),
//             'level_id' => 4,
//         ];

//         UserModel::insert($data); // Tambahkan data ke tabel m_user

//         // Coba akses model UserModel
//         $user = UserModel::all(); // Ambil semua data dari tabel m_user
//         return view('user', ['data' => $user]);
//     }
// }
