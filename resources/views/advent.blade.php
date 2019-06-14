@extends('layouts.master')
@section('content')
    <h3>Top bot</h3>
    <h4>Within its range: {{$inRange}}</h4>
    <h4>x-Pos: {{$nano->getXPos()}}</h4>
    <h4>y-Pos: {{$nano->getYPos()}}</h4>
    <h4>z-Pos: {{$nano->getZPos()}}</h4>
@stop
