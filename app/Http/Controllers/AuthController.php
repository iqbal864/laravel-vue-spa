<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AuthController extends Controller
{
    public function index()
    {
        // $user = User::all();
        $user = DB::table('users')->select('id', 'name', 'email')->get();

        $data = array();
        $no = 1;
        foreach ($user as $usr) {
            $row = array();
            $row['no'] = $no;
            $row['id'] = $usr->id;
            $row['name'] = $usr->name;
            $row['action'] = '<a href="" data-id="' . $usr->id . '" class="lihatuser">Lihat</a>
            <a href="" data-id="' . $usr->id . '" class="handleedit">Edit</a>
            <a href="" data-id="' . $usr->id . '" data-name="' . $usr->name . '" class="handledelete">Hapus</a>';
            $data[] = $row;
            $no++;
        }

        // return response()->json($data);
        return DataTables::of($data)->make();
    }

    public function get_detail($id)
    {
        // $user = DB::table('users')->where('id', $id)->first();
        $user = User::find($id);
        return response()->json($user);
    }

    public function store(Request $request)
    {

        // $validated = $request->validate([
        //     'name' => 'required',
        //     'email' => 'required|email',
        //     'password' => 'required',
        // ]);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors(),
            ], 403);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        // $user = new User;
        // $user->name = $request->name;
        // $user->email = $request->email;
        // $user->password = Hash::make($request->password);
        // $user->save();

        return response()->json([
            'status' => true,
            'message' => "Data user berhasil ditambahkan",
            'data' => $user
        ]);
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors(),
            ], 403);
        }

        $user = User::where('id', $id)->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // $user =  User::find($id);
        // return $user;

        return response()->json([
            'status' => true,
            'message' => "Data user berhasil diedit",
            'data' => $user
        ]);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        $userAll = User::all();
        return response()->json([
            'status' => true,
            'message' => "Data user berhasil dihapus",
            'data' => $userAll
        ]);
    }
}
