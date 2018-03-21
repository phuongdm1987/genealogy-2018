@extends('layouts.app')

@section('content')
    <svg width="1000" height="600"></svg>
@endsection

<style>
    .node circle {
        cursor: pointer;
        fill: #fff;
        stroke: steelblue;
        stroke-width: 1.5px;
    }

    .node text {
        font-size: 11px;
    }

    path.link {
        fill: none;
        stroke: #ccc;
        stroke-width: 1.5px;
    }

</style>