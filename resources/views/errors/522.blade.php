@extends('errors::minimal')

@section('title', __('Invalid entry in data file'))
@section('code', '522')
@section('message', __($exception->getMessage() ?: 'Invalid entry in data file. Please consult the readme.md file for tips and info.'))
