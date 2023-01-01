<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Complaint;
use Mail;

class DataBase extends Controller
{
    function registration(Request $req){
        try {
            $newuser = new User;
            $newuser->name = $req->name;
            $newuser->email = $req->email;
            $newuser->registration = $req->registration;
            $newuser->password = $req->password;
            $newuser->save();
        }catch(Exception $e){
            return redirect()->back()->with('phone_email',$e->getMessage());
        }
        return redirect('/signin');
    }
    function login(Request $req){
          $check=0;
          $registration = $req->registration;
          $password = $req->password;
          if ($registration=="admin@admin.com" && $password = "admin@123") {
              return redirect('/admin');
          } else {
              $data = DB::table('users')->where('registration', $registration)->where('password', $password)->get();
              $check = count($data);
              if($check!=0){
                  return redirect('/dashboard/'.$registration);
              }
              else{
                  return redirect()->back()->with('phone_email', 'Sorry, your email or password was incorrect. Please double-check your credentials.');
              }
          }
    }

    function dashboard($registration){
        return view('dashboard')->with('registration', $registration);
    }

    function form($name, $registration){
        $data = DB::select("select * from `users` where `registration` = '".$registration."'");
        return view('form', ['collection' => $data])->with('name', $name);
    }

    function registercomplaint($name, Request $req){
        DB::insert("insert into `complaints` (`id`, `name`, `registration`, `department`, `message`) VALUES (NULL, '".$req->name."', '".$req->registration."', '".$name."', '".$req->message."')");
        $details = [
            'title' => 'Mail from Complaint Portal',
            'body' => 'Your Complaint is successfully submitted to admin'
        ];
        $data = DB::select("select * from `users` where `registration` = '".$req->registration."'");
        foreach($data as $user){
            $email = $user->email;
        }
        Mail::to($email)->send(new \App\Mail\SendMail($details));
        return redirect('/dashboard/'.$req->registration);
    }

    function deletecomplaint($registration, $department, $message){
        DB::delete("DELETE FROM `complaints` WHERE `registration` = '".$registration."' AND `department` = '".$department."' AND `message` = '".$message."'");
        return redirect()->back();
    }

    function showadmin(){
        $data = Complaint::all();
        return view('admin', ['collection'=>$data]);
    }

    function showstudents(){
        $data = User::all();
        return view('studentslist', ['collection'=>$data]);
    }

    function deletestudent($registration){
        DB::delete("DELETE FROM `users` WHERE `registration` = '".$registration."'");
        return redirect()->back();
    }
}
