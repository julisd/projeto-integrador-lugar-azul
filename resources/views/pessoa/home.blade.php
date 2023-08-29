@extends('layout.app', ['current' => 'home'])

@section('body')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                Bem-vindo, {{ Auth::guard('pessoa_usuaria')->user()->name }}!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
