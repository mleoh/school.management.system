<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function UserView() {
        //  $allData = User::all();
        $data['allData'] = User::all();
         return view('backend.user.view_user',$data);
         
    }

    public function UserAdd() {
        return view('backend.user.add_user');
    }

    public function UserStore(Request $request) {
        $validatedData = $request->validate([
             'email' => 'required|unique:users',
             'name' => 'required'
        ]);

        $data = new User();
        $data->usertype = $request->usertype;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = bcrypt($request->password);

        $data->save();

        $notication = array(
             'message'=> 'User Inserted Successfully',
             'alert-type' => 'success'
        );

        return redirect()->route('user.view')->with($notication);
    }

    public function UserEdit($id) {
       $editData = User::find($id);
       return view('backend.user.edit_user',compact('editData'));
    }

    public function UserUpdate(Request $request,$id) {

       $data = User::find($id);
       $data->usertype = $request->usertype;
       $data->name = $request->name;
       $data->email = $request->email;
    
       $data->save();

       $notication = array(
            'message'=> 'User Updated Successfully',
            'alert-type' => 'info'
       );

       return redirect()->route('user.view')->with($notication);

    }

    public function UserDelete($id) {
        $user_delete = User::find($id);
        $user_delete->delete();

        $notication = array(
            'message'=> 'User Deleted Successfully',
            'alert-type' => 'info'
       );

       return redirect()->route('user.view')->with($notication);

    }
}
