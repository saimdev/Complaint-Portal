<?php

namespace App\Http\Controllers;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;
use App\Models\Teacher;
use App\Models\Task;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;
use Exception;
use Mail;
use Response;
use App\Mail\DemoMail;
use ZipArchive;



class database extends Controller
{
    //teacher sigin or signup
    function addTeachersData(Request $request)
    {
        try{
            $newuser = new Teacher;
        $newuser->fname = $request->input('fname');
        $newuser->lname = $request->input('lname');
        $newuser->department = $request->input('department');
        $newuser->qualification = $request->input('qualification');
        $newuser->email = $request->input('email');
        $newuser->fullname = $request->input('fname').'_'.$request->input('lname');
        $newuser->password = $request->input('password');

        $fullname = $request->input('fname').'_'.$request->input('lname');
        $newuser->save();
        if($request->hasFile('image')){
            $image = $request->file('image');
            $image_name = $fullname.'.jpg';
            $image->move(public_path('/imgs/users'),$image_name);
        }

        Schema::create($request->input('fname').'_'.$request->input('lname'), function (Blueprint $table) {
            $table->increments('id');
            $table->string('fname',20);
            $table->string('fullname',20);
            $table->string('registration',20);
            $table->string('section',20);
            $table->string('email',50);
        });


        Schema::create($request->input('fname').'_'.$request->input('lname').'_projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('projectname',20);
            $table->string('deadline',20);
            $table->string('projectmarks',20);
            $table->string('vd_deadline',20);
            $table->string('vd_marks',20);
            $table->string('fr_deadline',20);
            $table->string('fr_marks',20);
            $table->string('nfr_deadline',20);
            $table->string('nfr_marks',20);
            $table->string('ur_deadline',20);
            $table->string('ur_marks',20);
            $table->string('srs_deadline',20);
            $table->string('srs_marks',20);
            $table->string('p_deadline',20);
            $table->string('p_marks',20);
            $table->string('srds_deadline',20);
            $table->string('srds_marks',20);
            $table->string('code_deadline',20);
            $table->string('code_marks',20);
            $table->string('batch',20);
            $table->string('section',20);
        });

        return $this->index($request->input('email'), $newuser->password = $request->input('password'),$request->input('department'),$request->input('qualification'), 0);
        }catch(Exception $e){
            return redirect('/tsignup')->with('name_email',$e->getMessage());
        }
        return redirect("/tlogin");
    }

    function studentSubmitProject(Request $request, $studentname, $teachername, $projectname){
        $path = public_path('files/Students/'.$studentname."/".$projectname."/");

        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
        }
        if($request->hasFile('vdfile')){
            $file = $request->file('vdfile');
            $file_name = $studentname.'_vd'.'.pdf';
            $file->move(public_path('files/'.'Students/'.$studentname."/".$projectname."/"),$file_name);
            DB::update("update `".$studentname."_stuprojects` set `vd` = 0 where `teachername` = '".$teachername."'");
            // echo 'rehan';
        }
        if($request->hasFile('frfile')){
            $file = $request->file('frfile');
            $file_name = $studentname.'_fr'.'.pdf';
            $file->move(public_path('files/'.'Students/'.$studentname."/".$projectname."/"),$file_name);
            DB::update("update `".$studentname."_stuprojects` set `fr` = 0 where `teachername` = '".$teachername."'");
        }
        if($request->hasFile('nfrfile')){
            $file = $request->file('nfrfile');
            $file_name = $studentname.'_nfr'.'.pdf';
            $file->move(public_path('files/'.'Students/'.$studentname."/".$projectname."/"),$file_name);
            DB::update("update `".$studentname."_stuprojects` set `nfr` = 0 where `teachername` = '".$teachername."'");
        }
        if($request->hasFile('userfile')){
            $file = $request->file('userfile');
            $file_name = $studentname.'_user'.'.pdf';
            $file->move(public_path('files/'.'Students/'.$studentname."/".$projectname."/"),$file_name);
            DB::update("update `".$studentname."_stuprojects` set `ur` = 0 where `teachername` = '".$teachername."'");
        }
        if($request->hasFile('srsfile')){
            $file = $request->file('srsfile');
            $file_name = $studentname.'_srs'.'.pdf';
            $file->move(public_path('files/'.'Students/'.$studentname."/".$projectname."/"),$file_name);
            DB::update("update `".$studentname."_stuprojects` set `srs` = 0 where `teachername` = '".$teachername."'");
        }
        if($request->hasFile('pfile')){
            $file = $request->file('pfile');
            $file_name = $studentname.'_p'.'.pdf';
            $file->move(public_path('files/'.'Students/'.$studentname."/".$projectname."/"),$file_name);
            DB::update("update `".$studentname."_stuprojects` set `p` = 0 where `teachername` = '".$teachername."'");
        }
        if($request->hasFile('srdsfile')){
            $file = $request->file('srdsfile');
            $file_name = $studentname.'_srds'.'.pdf';
            $file->move(public_path('files/'.'Students/'.$studentname."/".$projectname."/"),$file_name);
            DB::update("update `".$studentname."_stuprojects` set `srds` = 0 where `teachername` = '".$teachername."'");
        }
        if($request->hasFile('codefile')){
            $file = $request->file('codefile');
            $file_name = $studentname.'_code'.'.pdf';
            $file->move(public_path('files/'.'Students/'.$studentname."/".$projectname."/"),$file_name);
            DB::update("update `".$studentname."_stuprojects` set `code` = 0 where `teachername` = '".$teachername."'");
        }

        return redirect()->back();


    }

    function addStudentsData(Request $request)
    {
        try{
            $newuser = new Student;
        $newuser->fname = $request->input('fname');
        $newuser->lname = $request->input('lname');
        $newuser->section = $request->input('section');
        $newuser->fullname = $request->input('fname').'_'.$request->input('lname');
        $newuser->registration = $request->input('registeration');
        $newuser->email = $request->input('email');
        $newuser->password = $request->input('password');
        $fullname = $request->input('fname').'_'.$request->input('lname');
        $newuser->save();
        if($request->hasFile('image')){
            $image = $request->file('image');
            $image_name = $fullname.'.jpg';
            $image->move(public_path('/imgs/users'),$image_name);
        }

        Schema::create($request->input('fname').'_'.$request->input('lname'), function (Blueprint $table) {
            $table->increments('id');
            $table->string('teachername',20);
            $table->string('teacherdepartment',20);
            $table->string('teacherqualification',50);
            $table->string('email',50);
        });

        Schema::create($request->input('fname').'_'.$request->input('lname').'_stuprojects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('teachername',20);
            $table->string('projectname',20);
            $table->string('projectmarks',20);
            $table->string('projectdeadline',20);
            $table->string('vd',20);
            $table->string('fr',20);
            $table->string('nfr',20);
            $table->string('ur',20);
            $table->string('srs',20);
            $table->string('p',20);
            $table->string('srds',20);
            $table->string('code',20);
            $table->string('vd_deadline',20);
            $table->string('vd_marks',20);
            $table->string('fr_deadline',20);
            $table->string('fr_marks',20);
            $table->string('nfr_deadline',20);
            $table->string('nfr_marks',20);
            $table->string('ur_deadline',20);
            $table->string('ur_marks',20);
            $table->string('srs_deadline',20);
            $table->string('srs_marks',20);
            $table->string('p_deadline',20);
            $table->string('p_marks',20);
            $table->string('srds_deadline',20);
            $table->string('srds_marks',20);
            $table->string('code_deadline',20);
            $table->string('code_marks',20);
        });

        

        $path = public_path('files/Students/'.$fullname."/");

        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
        }

        return $this->index($request->input('email'), $newuser->password = $request->input('password'),$request->input('registeration'),$request->input('section'), 1);
        
        } catch(Exception $e){
            return redirect('/stuSignup')->with('name_email',$e->getMessage());
        }
        return redirect("/stuLogin");
    }

    public function index($email, $password, $registration, $section, $check)
    {
        
       if($check==1){
        $mailData = [
            'title' => 'Account Registered',
            'body' => 'You are successfully registered on PerTask, Your Email Address: '.$email.' and Password: '.$password.'. Your Registration Number is '.$registration.' and Section: '.$section,
        ];
         
        Mail::to($email)->send(new DemoMail($mailData));
            return redirect("/stuLogin");
       }
       elseif($check==0){
        $mailData = [
            'title' => 'Account Registered',
            'body' => 'You are successfully registered on PerTask, Your Email Address: '.$email.' and Password: '.$password.'. Your Department is '.$registration.' and Qualification: '.$section,
        ];
         
        Mail::to($email)->send(new DemoMail($mailData));
            return redirect("/tlogin");
       }
    }

    public function adminMail($email, $password, $registration, $section, $check)
    {
        
       if($check==1){
        $mailData = [
            'title' => 'Account Registered',
            'body' => 'You are successfully registered on PerTask, Your Email Address: '.$email.' and Password: '.$password.'. Your Registration Number is '.$registration.' and Section: '.$section,
        ];
         
        Mail::to($email)->send(new DemoMail($mailData));
            return redirect("/studentstable");
       }
       elseif($check==0){
        $mailData = [
            'title' => 'Account Registered',
            'body' => 'You are successfully registered on PerTask, Your Email Address: '.$email.' and Password: '.$password.'. Your Department is '.$registration.' and Qualification: '.$section,
        ];
         
        Mail::to($email)->send(new DemoMail($mailData));
            return redirect("/teacherstable");
       }
    }

    function emptyteachers(){
        $data = Teacher::all();
        if($data->count()==0){
            return redirect()->back()->with('message', "No Teachers Data Found");
        }else{
            foreach($data as $user){
                $user->delete();
                Schema::dropIfExists($user->fullname);
                Schema::dropIfExists($user->fullname.'_projects');
                if(File::exists(public_path('imgs/users/'.$user->fullname.'.jpg'))){
                    File::delete(public_path('imgs/users/'.$user->fullname.'.jpg'));
                }
            }
            return redirect()->back()->with('message', "Successfully Deleted All Record Related to Teachers");
        }
    }

    function emptystudents(){
        $data = Student::all();
        if($data->count()==0){
            return redirect()->back()->with('message', "No Students Data Found");
        }else{
            foreach($data as $user){
                $user->delete();
                Schema::dropIfExists($user->fullname);
                Schema::dropIfExists($user->fullname.'_stuprojects');
                if(File::exists(public_path('imgs/users/'.$user->fullname.'.jpg'))){
                    File::delete(public_path('imgs/users/'.$user->fullname.'.jpg'));
                }
            }
            return redirect()->back()->with('message', "Successfully Deleted All Record Related to Students");
        }
        
    }

    function showProjectsTeacher($teachername, $projectname){
        $data = DB::select("select * from `".$teachername."`");
        // dd($files);
        return view('teacherprojectview', ['collection' => $data])->with('teachername', $teachername)->with('projectname', $projectname);
    }

    function projectmarking($teachername, $projectname, $fullname){
        // $data = DB::select("select * from `".$teachername."` where fullname = '".$fullname."'");

        $path = public_path('files/Students/'.$fullname.'/'.$projectname.'/');
        $zip = new ZipArchive;
        $fileName = $fullname.'_'.$projectname.'.zip';
        if(!File::isDirectory($path)){
            return redirect()->back()->with('message', "Student Didn't upload any file");
        }
        else{
            $files = File::allFiles($path);
            // echo $files[0]->pathname;
            // dd($files);
            // dd($files);
            if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE) {
                foreach ($files as $file){
                    $filename = basename($file);
                    $path = public_path('files/Students/'.$fullname.'/'.$projectname.'/'.$filename);
                    $relativeName = basename($path);
                    $zip->addFile($path, $relativeName);
                }
                $zip->close();
            }
            return response()->download(public_path($fileName));
            // return view ('projectmarkings', ['collection' => $files])->with('teachername', $teachername)->with('projectname', $projectname);
        }
        
    }

    
    public function download(Request $request)
    {
        $selected_file_ids = $request->input('selected_file_ids');
        $selected_file_ids_arr = explode(',',$selected_file_ids);

        $files = UploadedFile::whereIn('id',$selected_file_ids_arr)->get();
        $zip      = new ZipArchive;
        $fileName = 'downloads.zip';

        if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE) {
            foreach ($files as $file){
               $path =  public_path('storage/uploads/'.$file->user_id.'/'.$file->file_name);
                $relativeName = basename($path);
                $zip->addFile($path, $relativeName);
            }
            $zip->close();
        }

        return response()->download(public_path($fileName));
    }



    function time(){
        $dt = new DateTime();
echo $dt->format('Y-m-d H:i:s');
    }

    function adminPanel(){
        $teacherData = Teacher::all();
        $countTeachers = $teacherData->count();
        $studentData = Student::all();
        $countStudents = $studentData->count();

        return view('adminpanel')->with('teacherscount', $countTeachers)->with('studentscount', $countStudents);
    }

    function adminTeacherdelete($id){
        $data = Teacher::find($id);
        $name = $data->fullname;
        $data->delete();

        Schema::dropIfExists($name);
        Schema::dropIfExists($name.'_projects');
        if(File::exists(public_path('imgs/users/'.$name.'.jpg'))){
            File::delete(public_path('imgs/users/'.$name.'.jpg'));
        }
        return redirect()->back();
    }

    function adminStudentdelete($id){
        $data = Student::find($id);
        $name = $data->fullname;
        $data->delete();

        Schema::dropIfExists($name);
        Schema::dropIfExists($name.'_stuprojects');
        if(File::exists(public_path('imgs/users/'.$name.'.jpg'))){
            File::delete(public_path('imgs/users/'.$name.'.jpg'));
        }
        return redirect()->back();
    }

    function teacherlogin(Request $request)
    {
        if($request->email=='admin@admin.com' && $request->password=='admin'){
           return $this->adminPanel();
        }else{
            $auth = 0;
            $userEmail = $request->input('email');
            $userPass = $request->input('password');
            $checkData = DB::table("teachers")->where("email", $userEmail)->where("password", $userPass)->get();
            $auth = count($checkData);

            if ($auth == 1) {
                
                foreach ($checkData as $item) {
                    $teachername = $item->fname.'_'.$item->lname; 
                }
                $request->session()->put('teacheremail', $userEmail);
                // return redirect('dashboard/'.$teachername);
                return redirect('dashboard/'.$teachername);
            } else {
                return redirect()->back()->with('message', 'Sorry, your email or password was incorrect. Please double-check your credentials.');
            }
        }


    }

    

    function dashboard($teachername){
        $data = Task::where('teachername', $teachername)->sortable()->paginate(3);
        return view("dashboard", ['collection'=>$data])->with('teachername', $teachername);
    }

    function studashboard($studentname){
        $data = Task::where('teachername', $studentname)->sortable()->paginate(3);
        return view("studashboard", ['collection'=>$data])->with('studentname', $studentname);
    }

    function showteachername($teachername){
        $data = DB::select("select * from ".$teachername);
        return view('studentlist', ['collection' =>$data])->with('teachername', $teachername);
    }

    //ghalatttt hainnn
    function teacherprofile($teachername){
        $data = DB::table($teachername)->get();
        $count = $data->count();
        $projects = DB::table($teachername."_projects")->get();
        $countProjects = $projects->count();
        // echo $countProjects;
        // $totalStudent = $data->count();
        // $project = DB::select("select * from 'fullname'.'_projects'");
        // $totalprojects = $project->count();
        $teacherData = DB::table('teachers')->where('fullname', $teachername)->get();
        // echo $teacherData;

        return view('teacherprofile', ['collection' =>$teacherData], ['countProjects' => $countProjects])->with('teachername', $teachername)->with('count', $count);
    }

    function studentprofile($studentname){
        $data = DB::table($studentname)->get();
        $count = $data->count();
        $projects = DB::table($studentname."_stuprojects")->get();
        $countProjects = $projects->count();
        // echo $countProjects;
        // $totalStudent = $data->count();
        // $project = DB::select("select * from 'fullname'.'_projects'");
        // $totalprojects = $project->count();
        $studentData = DB::table('students')->where('fullname', $studentname)->get();
        // echo $teacherData;

        return view('studentprofile', ['collection' =>$studentData], ['countProjects' => $countProjects])->with('studentname', $studentname)->with('count', $count);
    }

    
    // function settingShowData($teachername){
    //     $data = Teacher::find( );
    //     // return view("setting", ['data'=>$data]);
    // }



    //student

    function studentlogin(Request $request)
    {
        $auth = 0;
        $userEmail = $request->input('email');
        $userPass = $request->input('password');
        $checkData = DB::table("students")->where("email", $userEmail)->where("password", $userPass)->get();
        $auth = count($checkData);

        if ($auth == 1) {
            
            foreach ($checkData as $item) {
                $studentname = $item->fname.'_'.$item->lname; 
            }
            $request->session()->put('studentemail', $userEmail);
            // return redirect('dashboard/'.$teachername);
            return redirect('studentdashboard/'.$studentname);
        } else {
            return redirect()->back()->with('message', 'Sorry, your email or password was incorrect. Please double-check your credentials.');
        }
    }

    function showStudents($teachername){
        $data = DB::select("select * from students");
        // return $data;
        return view("addstudent", ['collection'=>$data])->with('teachername', $teachername);
        // return $data;
        // return $data;
    }

    function adminteacherstable(){
        $data = Teacher::all();
        return view('teachersmanagement', ['collection' => $data]);
    }

    function adminstudentstable(){
        $data = Student::all();
        return view('studentsmanagement', ['collection' => $data]);
    }

    function backproject($teachername){
        return redirect('projects/'.$teachername);
    }
    function backstudent($teachername){
        return redirect('list/'.$teachername);
    }

    function showprojects($teachername){
        $data = DB::select("select * from ".$teachername."_projects");
        return view('projects', ['collection'=>$data])->with('teachername', $teachername);
    }

    function showstudentprojects($studentname){
        $data = DB::select("select * from ".$studentname."_stuprojects");
        return view('studentprojects', ['collection'=>$data])->with('studentname', $studentname);
    }

    function showstuproject($studentname, $projectname){
        $data = DB::select("select * from ".$studentname."_stuprojects where projectname = '".$projectname."'");
        return view('stuprojectview', ['collection'=>$data])->with('studentname', $studentname)->with('projectname', $projectname);
    }

    function assignStudent($registration, $teachername){
        $data = DB::table('students')->where('registration', $registration)->get();
        foreach ($data as $value) {
            $stufName = $value->fname;
            $stuName = $value->fullname;
            $stuReg = $value->registration;
            $stuEmail = $value->email;
            $stuSection = $value->section;
        }
        // return $data;

        $teacherData = DB::table('teachers')->where('fullname', $teachername)->get();
        foreach ($teacherData as $value) {
            $teacherName = $value->fullname;
            $teacherDepar = $value->department;
            $teacherQua = $value->qualification;
            $teacherEmail = $value->email;
        }

        DB::insert("insert into `".$stuName."` (`id`, `teachername`, `teacherdepartment`, `teacherqualification`, `email`) values (NULL, '".$teacherName."', '".$teacherDepar."', '".$teacherQua."', '".$teacherEmail."')");
        
        DB::insert("insert into `".$teachername."` (`id`, `fname`, `fullname`, `registration`, `section`, `email`) values (NULL, '".$stufName."', '".$stuName."', '".$stuReg."', '".$stuSection."', '".$stuEmail."')");
        return redirect('list/'.$teachername);
    }

    function deleteStudent($registration, $teachername){
        $data = DB::table($teachername)->where('registration', $registration)->get();
        DB::delete("delete from ".$teachername." where registration = '".$registration."'");
        return redirect('list/'.$teachername);
    }

    function addprojects($teachername){
        return view('addprojects')->with('teachername', $teachername);
        // echo "saim";
    }

    
    function submitproject(Request $req, $teachername){
        $fullname="Ayesha_Amjad";
        $vd=0;$fr=0;$nfr=0;$ur=0;$srs=0;$srds=0;$code=0;$p=0;
        $studentsData = DB::select("select * from `".$teachername."`");
        foreach($studentsData as $student){
            if($req->has('document')){
                foreach($req->document as $selected){
                    if($selected=='Vision Document'){
                        $vd=1;
                    }
                    elseif($selected=='Functional Requirements'){
                        $fr=1;
                    }
                    elseif($selected=='Non-Functional Requirements'){
                        $nfr=1;
                    }
                    elseif($selected=='User Requirements'){
                        $ur=1;
                    }
                    elseif($selected=='SRS'){
                        $srs=1;
                    }
                    elseif($selected=='Proposal'){
                        $p=1;
                    }
                    elseif($selected=='SRDS'){
                        $srds=1;
                    }
                    elseif($selected=='Code'){
                        $code=1;
                    }
                }
            }
            // $path = public_path('files/Students/Ayesha_Amjad/'.$req->name."/");
            // // echo $path;
            // if(!File::isDirectory($path)){
            //     File::makeDirectory($path, 0777, true, true);
            //     // echo $path;
            // }
            DB::insert("insert into `".$student->fullname."_stuprojects` (`id`, `teachername`, `projectname`, `projectmarks`, `projectdeadline`, `vd`, `fr`, `nfr`, `ur`, `srs`, `p`, `srds`, `code`, `vd_deadline`, `vd_marks`, `fr_deadline`, `fr_marks`, `nfr_deadline`, `nfr_marks`, `ur_deadline`, `ur_marks`, `srs_deadline`, `srs_marks`, `p_deadline`, `p_marks`, `srds_deadline`, `srds_marks`, `code_deadline`, `code_marks`) values (NULL, '".$teachername."', '".$req->name."', '".$req->marks."', '".$req->deadline."', '".$vd."', '".$fr."', '".$nfr."', '".$ur."', '".$srs."', '".$p."', '".$srds."', '".$code."', '".$req->vd_deadline."', '".$req->vd_marks."', '".$req->fr_deadline."', '".$req->fr_marks."', '".$req->nfr_deadline."', '".$req->nfr_marks."', '".$req->ur_deadline."', '".$req->ur_marks."', '".$req->srs_deadline."', '".$req->srs_marks."', '".$req->p_deadline."', '".$req->p_marks."', '".$req->srds_deadline."', '".$req->srds_marks."', '".$req->code_deadline."', '".$req->code_marks."')");
        }
        // $path = public_path('files/Students/'.$fullname.'/'.$req->name."/");
        //     // echo $path;
        //     if(!File::isDirectory($path)){
        //         File::makeDirectory($path, 0777, true, true);
        //         // echo $path;
        //     }
        
        DB::insert("insert into `".$teachername."_projects` (`id`, `projectname`, `deadline`, `projectmarks`, `vd_deadline`, `vd_marks`, `fr_deadline`, `fr_marks`, `nfr_deadline`, `nfr_marks`, `ur_deadline`, `ur_marks`, `srs_deadline`, `srs_marks`, `p_deadline`, `p_marks`, `srds_deadline`, `srds_marks`, `code_deadline`, `code_marks`, `batch`, `section`) values (NULL, '".$req->name."', '".$req->deadline."', '".$req->marks."', '".$req->vd_deadline."', '".$req->vd_marks."', '".$req->fr_deadline."', '".$req->fr_marks."', '".$req->nfr_deadline."', '".$req->nfr_marks."', '".$req->ur_deadline."', '".$req->ur_marks."', '".$req->srs_deadline."', '".$req->srs_marks."', '".$req->p_deadline."', '".$req->p_marks."', '".$req->srds_deadline."', '".$req->srds_marks."', '".$req->code_deadline."', '".$req->code_marks."', '".$req->batch."', '".$req->section."')");
        return redirect()->back();
    }

    function settings($teachername){
        $teacherData = DB::table('teachers')->where('fullname', $teachername)->get();
        return view('settings', ['collection' =>$teacherData])->with('teachername', $teachername);
    }

    function studentSettings($studentname){
        $studentData = DB::table('students')->where('fullname', $studentname)->get();
        return view('studentsettings', ['collection' => $studentData])->with('studentname', $studentname);
    }

    //practiceeeeee
    // function dataFetch(){
    //     $data = DB::select("select * from teachers");
    //      return view("table", ['collection'=>$data]);
    //     // return $data;
    // }

    // function dataDelete($id){
    //     $data = Teacher::find($id);
    //     $data->delete();
    //     // return $data;
    //     return redirect("table");
    // }

    // function showData($id){
    //     $data = Teacher::find($id);
    //     return view("update", ['data'=>$data]);
    // }

    function updateData(Request $req, $teachername){
    $email = $req->email;
    $department = $req->department;
    $qualification = $req->qualification;
    $fullname = $req->fullname;
    DB::update("UPDATE `teachers` SET `department`='".$department."',`qualification`='".$qualification."',`email`='".$email."' WHERE fullname = '".$teachername."'");
    if($req->hasFile('image')){
        $image = $req->file('image');
        $image_name = $fullname.'.jpg';
        $image->move(public_path('/imgs/users'),$image_name);
    }
    return redirect("dashboard/".$teachername);
    }

    function studentUpdateData(Request $req, $studentname){
        $email = $req->email;
        $section = $req->section;
        $registration = $req->registration;
        $fullname = $req->fullname;
        // echo $email;
        // echo $section;
        DB::update("UPDATE `students` SET `section`='".$section."', `registration`='".$registration."', `email` = '".$email."' WHERE fullname = '".$studentname."'");
        if($req->hasFile('image')){
            $image = $req->file('image');
            $image_name = $fullname.'.jpg';
            $image->move(public_path('/imgs/users'),$image_name);
        }
        return redirect("studentdashboard/".$studentname);
    }

    

    function dataFetch()
    {
        $data = DB::select("select * from tasks");
        return view("dashboard", ['collection' => $data])->with('teachername', $teachername);
        // return $data;
    }


    function addnewtask(Request $request, $teachername)
    {
        $newtask = new Task;
        $newtask->teachername = $teachername;
        $newtask->task = $request->input('task');
        $newtask->save();
        return redirect("dashboard/".$teachername);
    }

    function addnewtaskStudent(Request $request, $studentname)
    {
        $newtask = new Task;
        $newtask->teachername = $studentname;
        $newtask->task = $request->input('task');
        $newtask->save();
        return redirect("studentdashboard/".$studentname);
    }

    function deletedata($id, $teachername)
    {
        $delete = Task::find($id);
        $delete->delete();
        return redirect("dashboard/".$teachername);
    }

    function relode(Request $req, $teachername)
    {
        $ids = $req->id;

        Task::whereIn('id', $ids)->delete();

        return redirect()->back()->with('message', 'Record successfully delete');
    }
}
