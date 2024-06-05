@extends('layout.app')

@section('body')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                Bem-vindo, Administrador {{ Auth::guard('admin')->user()->name }}!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
