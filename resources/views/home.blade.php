@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="alert alert-success d-flex align-items-center" role="alert">
                    <i class="bi bi-person-check-fill me-3" style="font-size: 2rem;"></i>
                    <div>
                        <h4 class="alert-heading mb-2">Добро пожаловать, {{ Auth::user()->name }}!</h4>
                        <p class="mb-0">Вы успешно вошли в систему. Здесь будет ваша панель управления и полезная
                            информация.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
