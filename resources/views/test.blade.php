@extends('layouts.app')

@section('content')
    <svg width="1000" height="600"></svg>
@endsection

<style>
    .node circle {
        fill: #999;
    }

    .node text {
        font: 10px sans-serif;
    }

    .node--internal circle {
        fill: #555;
    }

    .node--internal text {
        text-shadow: 0 1px 0 #fff, 0 -1px 0 #fff, 1px 0 0 #fff, -1px 0 0 #fff;
    }

    .link {
        fill: none;
        stroke: #555;
        stroke-opacity: 0.4;
        stroke-width: 1.5px;
    }

</style>