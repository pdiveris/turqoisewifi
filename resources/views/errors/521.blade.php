@extends('errors::minimal')

@section('title', __('Cannot open the data file'))
@section('code', '521')
@section('message', __($exception->getMessage() ?: 'Invalid filename/path specified for data file'))
