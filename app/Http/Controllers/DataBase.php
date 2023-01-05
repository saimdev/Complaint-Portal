<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Complaint;
use Mail;
use Kyslik\ColumnSortable\Sortable;
use Response;

class DataBase extends Controller
{
    public $filepath;
    public $file_name;
    function registration(Request $req){
        try {
            $newuser = new User;
            $newuser->name = $req->name;
            $newuser->email = $req->email;
            $newuser->registration = $req->registration;
            $newuser->password = $req->password;
            $newuser->status = 0;
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
                  foreach($data as $user){
                      if($user->status==0){
                        return redirect('/dashboard/'.$registration);
                      }
                      else{
                        return redirect()->back()->with('phone_email', 'Sorry, your portal is restricted by admin');
                      }
                  }
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
        try {
            if($req->hasFile('file')){
                $file = $req->file('file');
                $this->file_name = $req->filename.'.'.$file->extension();
                $file->move(public_path('/files'),$this->file_name);
                $this->filepath = "files/".$this->file_name;
                // echo "saim";
            }
            DB::insert("insert into `complaints` (`id`, `name`, `registration`, `department`, `filename`, `filepath`, `message`, `status`) VALUES (NULL, '".$req->name."', '".$req->registration."', '".$name."', '".$req->filename."', '".$this->filepath."', '".$req->message."', 0)");
            // echo $this->filepath;
            // echo $this->file_name;
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
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    function updatecomplaint($registration, $department, $message){
        DB::update("UPDATE `complaints` SET `status` = 1 WHERE `registration` = '".$registration."' AND `department` = '".$department."' AND `message` = '".$message."'");
        return redirect()->back();
    }

    function showadmin(){
        $complaints = count(Complaint::all());
        $students = count(User::all());
        $data = Complaint::where('status', '=', 0)->sortable()->paginate(3);
        // echo count($complaints);
        return view('admin', ['collection'=>$data])->with('complaints', $complaints)->with('students', $students);
    }

    function deletecomplaint($registration, $department, $message){
        DB::delete("DELETE FROM `complaints` WHERE `registration` = '".$registration."' AND `department` = '".$department."' AND `message` = '".$message."'");
        return redirect()->back();
    }

    function updateStudent($registration, $value){
        if($value==1){
            DB::update("UPDATE `users` SET `status` = 1 WHERE `registration` = '".$registration."'");
        }
        else{
            DB::update("UPDATE `users` SET `status` = 0 WHERE `registration` = '".$registration."'");
        }
        return redirect()->back();
    }

    function showstudents(){
        $data = User::sortable()->paginate(3);
        return view('studentslist', ['collection'=>$data]);
    }

    function deletestudent($registration){
        DB::delete("DELETE FROM `users` WHERE `registration` = '".$registration."'");
        return redirect()->back();
    }

    function showallcomplaints(){
        $data = Complaint::sortable()->paginate(3);
        return view('allcomplaints', ['collection'=>$data]);
    }

    function showusercomplaints($registration){
        $data = Complaint::where('registration',$registration)->sortable()->paginate(3);
        return view('usercomplaints', ['collection'=>$data])->with('registration', $registration);
    }

    function getDownload($path){
        return response()->download(public_path('files/'.$path));
    }
}
