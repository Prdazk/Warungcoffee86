@extends('admin.layout.app') 
@section('title', 'Kelola Menu') 

@section('content') 

@if(session('success')) 
  <div class="alert alert-success">{{ session('success') }}</div>
@endif 

<div class="menu-actions"> 
  <a href="{{ route('admin.menu.create') }}" class="btn btn-tambah">
    <i class="fas fa-plus"></i> Tambah Menu
  </a>
</div> 

@include('admin.menu.partials.table')

@endsection