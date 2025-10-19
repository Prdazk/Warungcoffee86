@extends('user.layout.app')

@section('content')
  @include('user.layout.header')
  @include('user.sections.menu')
  @include('user.sections.reservasi')
  @include('user.sections.lokasi')
  @include('user.sections.about')
@endsection
