@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="task-card color-1" style="padding: 40px; text-align: center;">
            <i class="fas fa-smile" style="font-size: 80px; color: #ffa502;"></i>
            <h1 class="mt-3">Olá, {{ Auth::user()->name }}!</h1>
            <p class="text-muted">Bem-vindo ao seu organizador de notas adesivas!</p>
            
            <div class="row mt-5">
                <div class="col-md-4 mb-3">
                    <div class="task-card color-3" style="padding: 20px;">
                        <i class="fas fa-chart-line" style="font-size: 40px;"></i>
                        <h3 class="mt-2">{{ Auth::user()->tasks()->count() }}</h3>
                        <p class="mb-0">Total de Notas</p>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="task-card color-4" style="padding: 20px;">
                        <i class="fas fa-hourglass-half" style="font-size: 40px;"></i>
                        <h3 class="mt-2">{{ Auth::user()->tasks()->pendente()->count() }}</h3>
                        <p class="mb-0">Notas Pendentes</p>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="task-card color-5" style="padding: 20px;">
                        <i class="fas fa-check-circle" style="font-size: 40px; color: #26de81;"></i>
                        <h3 class="mt-2">{{ Auth::user()->tasks()->concluida()->count() }}</h3>
                        <p class="mb-0">Notas Concluídas</p>
                    </div>
                </div>
            </div>
            
            <div class="mt-4 d-flex gap-3 justify-content-center flex-wrap">
                <a href="{{ route('tasks.index') }}" class="btn-task" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-decoration: none; padding: 12px 30px;">
                    <i class="fas fa-sticky-note"></i> Ver Minhas Notas
                </a>
                <a href="{{ route('tasks.create') }}" class="btn-task" style="background: #26de81; color: white; text-decoration: none; padding: 12px 30px;">
                    <i class="fas fa-plus-circle"></i> Criar Nova Nota
                </a>
            </div>
        </div>
    </div>
</div>
@endsection