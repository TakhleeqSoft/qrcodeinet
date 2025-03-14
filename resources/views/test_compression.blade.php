@extends('layouts.app')

@section('title', 'اختبار ضغط الصورة')
@section('content')
    <div class="container">
        <h2>اختبار ضغط الصورة</h2>
        <form action="{{ url('/test-image-compression') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="category_image">رفع صورة للاختبار</label>
                <input type="file" name="category_image" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">اختبار ضغط الصورة</button>
        </form>
    </div>
@endsection
