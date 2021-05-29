@extends('admin.layout')

@section('page_title','color')

@section('color_select','active')

@section('container')

{{ session('message') }}

<h1 class="mb10">Color</h1>

<a href="color/manage_color">
	<button type="button" class="btn btn-success">Add Color</button>
</a>

<div class="row m-t-30">
    <div class="col-md-12">
        <!-- DATA TABLE-->
        <div class="table-responsive m-b-40">
            <table class="table table-borderless table-data3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Color</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $list)
                    <tr>
                        <td>{{ $list->id }}</td>
                        <td>{{ $list->color }}</td>
                        <td>
                            @if ($list->status==1)
                            <a href="{{ url('admin/color/status/0/') }}/{{ $list->id }}"><button type="button" class="btn btn-primary">Active</button></a>
                            @else
                            <a href="{{ url('admin/color/status/1/') }}/{{ $list->id }}"><button type="button" class="btn btn-warning">Deactive</button></a>
                            @endif
                            <a href="{{ url('admin/color/manage_color/') }}/{{ $list->id }}"><button type="button" class="btn btn-success">Edit</button></a>
                            <a href="{{ url('admin/color/delete/') }}/{{ $list->id }}"><button type="button" class="btn btn-danger">Delete</button></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- END DATA TABLE-->
    </div>
</div>


@endsection