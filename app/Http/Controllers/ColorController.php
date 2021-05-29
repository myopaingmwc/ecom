<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result['data']=Color::all();

        return view('admin.color',$result);
    }

    public function manage_color(Request $request)
    {
        if($request->id>0){
            $arr=Color::where(['id'=>$request->id])->get();

            $result['color']=$arr['0']->color;
            $result['id']=$arr['0']->id;

        }else{
            $result['color']='';
            $result['id']=0;
        }

        return view('admin.manage_color', $result);
    }

    public function manage_color_process(Request $request)
    {
        $request->validate([
            'color'=>'required|unique:colors,color,'.$request->post('id'),
        ]);

        if($request->post('id')>0){
            $model=Color::find($request->post('id'));
            $msg="Color Updated";
        }else{
            $model=new color;
            $msg="Color Inserted";
            $model->status=1;
        }

        $model->color=$request->post('color');
        $model->save();

        $request->session()->flash('message',$msg);

        return redirect('admin/color');
    }

    public function delete(Request $request){

        $model=Color::find($request->id);

        $model->delete();

        $request->session()->flash('message','Color deleted');

        return redirect('admin/color');

    }

    public function status(Request $request, $status, $id){

        $model=Color::find($id);

        $model->status=$status;

        if($status==1){
            $msg=$model->title." - Color Active";
        }else{
            $msg=$model->title." - Color Deactive";
        }

        $model->save();

        $request->session()->flash('message',$msg);

        return redirect('admin/color');

    }
}