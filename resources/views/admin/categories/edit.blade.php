@extends('layouts.admin')

@section('title')
    <title>Danh mục</title>
@endsection

@section('content')
    <div class="row container-fluid ml-0 pt-2">
        <div class="col-4">
            <div class="card">
                @include('partials.admin.title-form',['name'=>'Chỉnh sửa danh mục'])
                <div class="card-body">
                    <form action="{{ route('categories.update',['id'=> $category['id']]) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Tên danh mục :</label>
                            <input class="form-control" type="text" name="cate_name" id="name"
                                   placeholder="Nhập tên danh mục" value="{{ $category['cate_name'] }}">
                        </div>
                        <div class="form-group">
                            <label for="parent_id">Danh mục cha :</label>
                            <select class="form-control" name="parent_id" id="parent_id">
                                <option value="0">Chọn danh mục</option>
                                {!! $htmlOption !!}
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Trạng thái</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1"
                                       value="option1" checked>
                                <label class="form-check-label" for="exampleRadios1">Chờ duyệt</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2"
                                       value="option2">
                                <label class="form-check-label" for="exampleRadios2">Công khai</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Danh mục
                </div>
                <div class="card-body pb-0">
                    <table class="table table-striped mb-4">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tên danh mục</th>
                            <th scope="col">Slug</th>
                            <th scope="col">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $key => $category)
                            <tr>
                                <th scope="row">{{$key + 1}}</th>
                                <td>{{ $category['cate_name'] }}</td>
                                <td>{{ $category['slug'] }}</td>
                                <td class="pl-4">
                                    <a href="{{ route('categories.edit',['id' => $category['id']]) }}"
                                       class="btn-edit text-success" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="#" data-url="{{ route('categories.delete',['id' => $category['id']]) }}"
                                       data-id="{{ $category->id }}"
                                       class="btn-delete text-danger" type="button" title="Delete">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/admin/js/category/index.js') }}"></script>
@endsection
