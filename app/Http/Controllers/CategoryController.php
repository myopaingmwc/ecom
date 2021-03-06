<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result['data']=Category::all();

        return view('admin.category',$result);
    }

    public function manage_category(Request $request)
    {
        if($request->id>0){
            $arr=Category::where(['id'=>$request->id])->get();

            $result['category_name']=$arr['0']->category_name;
            $result['category_slug']=$arr['0']->category_slug;
            $result['id']=$arr['0']->id;

        }else{
            $result['category_name']='';
            $result['category_slug']='';
            $result['id']=0;
        }

        return view('admin.manage_category', $result);
    }

    public function manage_category_process(Request $request)
    {
        $request->validate([
            'category_name'=>'required',
            'category_slug'=>'required|unique:categories,category_slug,'.$request->post('id'),
        ]);

        if($request->post('id')>0){
            $model=Category::find($request->post('id'));
            $msg="Category Updated";
        }else{
            $model=new Category;
            $msg="Category Inserted";
            $model->status=1;
        }

        $model->category_name=$request->post('category_name');
        $model->category_slug=$request->post('category_slug');
        $model->save();

        $request->session()->flash('message',$msg);

        return redirect('admin/category');
    }

    public function delete(Request $request){

        $model=Category::find($request->id);

        $model->delete();

        $request->session()->flash('message','Category deleted');

        return redirect('admin/category');

    }

    public function status(Request $request, $status, $id){

        $model=Category::find($id);

        $model->status=$status;

        if($status==1){
            $msg=$model->category_name." - Category Active";
        }else{
            $msg=$model->category_name." - Category Deactive";
        }

        $model->save();

        $request->session()->flash('message',$msg);

        return redirect('admin/category');

    }

}
