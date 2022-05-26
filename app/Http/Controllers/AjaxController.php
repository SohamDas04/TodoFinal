<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;

class AjaxController extends Controller
{
    //
    public function senddata(Request $req)
    {
        if($req->ajax())
        {
            $todo=new Todo;
            $data=stripslashes(file_get_contents("php://input"));
            $mydata=json_decode($data,true);
            $iden=$mydata['create'];
            $todo->value=$iden;
            $todo->save();
            // $todo->id;
            return response()->json(array('show'=>$iden,'id'=>$todo->id));
        
        }
        
    }
    public function showdata()
    {
        return view('todo');
    }
    public function dnd(Request $req)
    {
        if($req->ajax())
        {
        $data=stripslashes(file_get_contents("php://input"));
        $mydata=json_decode($data,true);
        $iden=$mydata['dnd'];
        $datab=Todo::find($iden);
        if($datab->status==0)
        {
            $datab->status=1;
        }
        else{
            $datab->status=0;
        }
        $datab->save();
        return $iden;  
        }
    }
    public function upval(Request $req)
    {
        if($req->ajax())
        {
            $data=stripslashes(file_get_contents("php://input"));
            $mydata=json_decode($data,true);
            $iden=$mydata['save'];
            $value=$mydata['value'];
            $datab=Todo::find($iden);
            $datab->value=$value;
            $datab->save();
            return $value;
        }
    }
    public function del(Request $req)
    {
        if($req->ajax())
        {
            $data=stripslashes(file_get_contents("php://input"));
            $mydata=json_decode($data,true);
            $iden=$mydata['id'];
            $datab=Todo::find($iden);
            $datab->delete();
            return $iden;
        }
    }
    public function sendview(){
        // $data=Todo::all();   
        $data = Todo::select("*")
        ->orderBy("pos", "asc")
        ->get();
        return view('view',['todo'=>$data]);
    }
    public function prioritize(Request $req){
        if($req->ajax()){
            $data=stripslashes(file_get_contents("php://input"));
            $mydata=json_decode($data,true);
            $value=$mydata['position'];
            // print_r($value);
            $position=1;
            foreach($value as $values){
                $datab=Todo::find($values);
                $datab->pos=$position;
                $position=$position+1;
                $datab->save();
            }
            return $value;
        }
    }
}
