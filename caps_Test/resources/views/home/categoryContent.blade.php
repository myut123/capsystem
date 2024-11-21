@extends('headerFooter.HeaderDash')
@section('content')

<head>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Pet List</title>
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Categories</h5>
        </div>
        <div class="card-body">
            <ul class="nav nav-pills" role="tablist">
                @foreach($categories as $category)
                    <li class="nav-item">
                        <a class="nav-link {{ $loop->first ? 'active' : '' }}" id="tab{{ $category->id }}-tab" data-toggle="pill" href="#tab{{ $category->id }}" role="tab" data-category-id="{{ $category->id }}">
                            {{ $category->category_name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>




@endsection
