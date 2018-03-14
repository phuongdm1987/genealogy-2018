@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            @include('includes.sidebar')
        </div>
        <div class="col-md-9">
            @include('includes.tree_map')
        </div>
    </div>
</div>
@endsection
