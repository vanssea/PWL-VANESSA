<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;

//Jobsheet 4 - Praktikum 2.6
class UserController extends Controller
{
    public function index()
    {
        $user = UserModel::all();
        return view('user', ['data' => $user]);
    }

    public function tambah()
    {
        return view('user_tambah');
    }

    public function tambah_simpan(Request $request)
    {
        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => Hash::make($request->password),
            'level_id' => $request->level_id
        ]);

        return redirect('/user');
    }

    public function ubah ($id)
    {
        $user = UserModel::find($id);
        return view('user_ubah', ['data' => $user]);
    }

    public function ubah_simpan($id, Request $request)
    {
        $user = UserModel::find($id);

        $user->username = $request->username;
        $user->nama = $request->nama;
        $user->password = Hash::make($request->password);
        $user->level_id = $request->level_id;

        $user->save();

        return redirect('/user');
    }

    public function hapus($id)
    {
        $user = UserModel::find($id);
        $user -> delete();

        return redirect('/user');
    }




}


// // Jobsheet 4 - Praktikum 2.6
// class UserController extends Controller
// {
//     public function index()
//     {
//         $user = UserModel::all();
//         return view('user', ['data' => $user]);
//     }
// }


// Jobsheet 4 - Praktikum 2.5 - No.3
// class UserController extends Controller
// {
//     public function index()
//     {
//         $user = UserModel::create([
//             'username' => 'manager11',
//             'nama' => 'Manager11',
//             'password' => Hash::make('12345'),
//             'level_id' => 2,
//         ]);

//         $user->username = 'manager12';

//         $user->save();

//         $user->wasChanged(); // true
//         $user->wasChanged('username'); // true
//         $user->wasChanged(['username', 'level_id']); // true
//         $user->wasChanged('nama'); // false
//         dd($user->wasChanged(['nama', 'username'])); // true
//     }
// }


// Jobsheet 4 - Praktikum 2.5
// class UserController extends Controller
// {
//     public function index()
//     {
//         $user = UserModel::create([
//             'username' => 'manager55',
//             'nama' => 'Manager55',
//             'password' => Hash::make('12345'),
//             'level_id' => 2,
//         ]);

//         $user->username = 'manager56';

//         $user->isDirty(); // true
//         $user->isDirty('username'); // true
//         $user->isDirty('nama'); // false
//         $user->isDirty(['nama', 'username']); // true

//         $user->isClean(); // false
//         $user->isClean('username'); // false
//         $user->isClean('nama'); // true
//         $user->isClean(['nama', 'username']); // false

//         $user->save();

//         $user->isDirty(); // false
//         $user->isClean(); // true

//         dd($user->isDirty());
//     }
// }


// // // Jobsheet 4 - Praktikum 2.4 - No. 11
// class UserController extends Controller 
// {
//     public function index()
//     {
//         $user = UserModel::firstOrNew( 
//             [
//                 'username' => 'manager33',
//                 'nama' => 'Manager Tiga Tiga',
//                 'password' => Hash::make ('12345'),
//                 'level_id' => 2
//             ],
//         );
//         $user->save();
      
//         return view('user', ['data' => $user]);
        
//     }
// }

// // // Jobsheet 4 - Praktikum 2.4 - No. 8 
// class UserController extends Controller 
// {
//     public function index()
//     {
//         $user = UserModel::firstOrNew( 
//             [
//                 'username' => 'manager33',
//                 'nama' => 'Manager Tiga Tiga',
//                 'password' => Hash::make ('12345'),
//                 'level_id' => 2
//             ],
//         );
      
//         return view('user', ['data' => $user]);
        
//     }
// }

// // Jobsheet 4 - Praktikum 2.4 - No. 6 
// class UserController extends Controller 
// {
//     public function index()
//     {
//         $user = UserModel::firstOrNew( 
//             [
//                 'username' => 'manager',
//                 'nama' => 'Manager',
//             ],
//         );
      
//         return view('user', ['data' => $user]);
        
//     }
// }

// // Jobsheet 4 - Praktikum 2.4 - No. 4 
// class UserController extends Controller 
// {
//     public function index()
//     {
//         $user = UserModel::firstOrCreate( 
//             [
//                 'username' => 'manager22',
//                 'nama' => 'Manager Dua Dua',
//                 'password' => Hash::make ('12345'),
//                 'level_id' => 2
//             ],
//         );
      
//         return view('user', ['data' => $user]);
        
//     }
// }

// // Jobsheet 4 - Praktikum 2.4 
// class UserController extends Controller 
// {
//     public function index()
//     {
//         $user = UserModel::firstOrCreate( 
//             [
//                 'username' => 'manager',
//                 'nama' => 'Manager',
//             ],
//         );
      
//         return view('user', ['data' => $user]);
        
//     }
// }
// // Jobsheet 4 - Praktikum 2.3 
// class UserController extends Controller 
// {
//     public function index()
//     {
        
//         $user = UserModel::where('level_id', 2)->count();
//         // dd($user);
//         return view('user', ['data' => $user]);
        
//     }
// }

// // Jobsheet 4 - Praktikum 2.2 - No. 10
// class UserController extends Controller 
// {
//     public function index()
//     {
        
//         $user = UserModel::where('username', 'manager9')->firstOrFail();
//         return view('user', ['data' => $user]);
        
//     }
// }

// // Jobsheet 4 - Praktikum 2.2
// class UserController extends Controller 
// {
//     public function index()
//     {
        
//         $user = UserModel::findOrFail(1);
//         return view('user', ['data' => $user]);
        
//     }
// }
// // Jobsheet 4 - Praktikum 2.1 - No 10
// class UserController extends Controller 
// {
//     public function index()
//     {
        
//         $user = UserModel::findOr (20,['username', 'nama'], function () {
//             abort(404);
//         });

//         return view ('user', ['data' => $user]);
        
//     }
// }

// Jobsheet 4 - Praktikum 2.1
// class UserController extends Controller 
// {
//     public function index()
//     {
        
//         $user = UserModel::findOr (1,['username', 'nama'], function () {
//             abort(404);
//         });

//         return view ('user', ['data' => $user]);
        
//     }
// }

// Jobsheet 4 - Praktikum 2
// class UserController extends Controller 
// {
//     public function index()
//     {
        
//         $user = UserModel::where ('level_id', 1) -> first();
//         return view ('user', ['data' => $user]);
        
//     }
// }
// Jobsheet 4 - Praktikum 1
// class UserController extends Controller 
// {
//     public function index()
//     {
//         $data = [
//             'level_id' => 2,
//             'username' => 'manager_tiga',
//             'nama' => 'Manager 3',
//             // 'username' => 'manager_dua',
//             // 'nama' => 'Manager 2',
//             'password' => Hash::make('12345')
//         ];
//         UserModel::create($data);

//         $user = UserModel::all();
//         return view ('user', ['data' => $user]);
//     }
// }


// Jobsheet 3
// class UserController extends Controller
// {
//     public function index()
//     {
//         // Tambah data user dengan Eloquent Model
//         $data = [
//             'nama' => 'Pelanggan Pertama',
//         ];
//         UserModel::where('username', 'customer-1')->update($data); // Update data user

//         // Coba akses model UserModel
//         $user = UserModel::all(); // Ambil semua data dari tabel m_user
//         return view('user', ['data' => $user]);
//     }
// }

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
