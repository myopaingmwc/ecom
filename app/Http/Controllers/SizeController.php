<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result['data']=Size::all();

        return view('admin.size',$result);
    }

    public function manage_size(Request $request)
    {
        if($request->id>0){
            $arr=Size::where(['id'=>$request->id])->get();

            $result['size']=$arr['0']->size;
            $result['id']=$arr['0']->id;

        }else{
            $result['size']='';
            $result['id']=0;
        }

        return view('admin.manage_size', $result);
    }

    public function manage_size_process(Request $request)
    {
        $request->validate([
            'size'=>'required|unique:sizes,size,'.$request->post('id'),
        ]);

        if($request->post('id')>0){
            $model=Size::find($request->post('id'));
            $msg="Size Updated";
        }else{
            $model=new Size;
            $msg="Size Inserted";
            $model->status=1;
        }

        $model->size=$request->post('size');
        $model->save();

        $request->session()->flash('message',$msg);

        return redirect('admin/size');
    }

    public function delete(Request $request){

        $model=Size::find($request->id);

        $model->delete();

        $request->session()->flash('message','Size deleted');

        return redirect('admin/size');

    }

    public function status(Request $request, $status, $id){

        $model=Size::find($id);

        $model->status=$status;

        if($status==1){
            $msg=$model->title." - Size Active";
        }else{
            $msg=$model->title." - Size Deactive";
        }

        $model->save();

        $request->session()->flash('message',$msg);

        return redirect('admin/size');

    }
}