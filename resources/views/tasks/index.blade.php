@extends('layouts.app')

@section('title', 'Minhas Notas')

@section('content')
<div class="row mb-4">
    <div class="col-md-6">
        <h2 style="color: white; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
            <i class="fas fa-sticky-note"></i> Minhas Notas Adesivas
        </h2>
        <p style="color: rgba(255,255,255,0.9);">Organize suas tarefas com estilo!</p>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('tasks.create') }}" class="btn-create">
            <i class="fas fa-plus-circle"></i> Criar Nova Nota
        </a>
    </div>
</div>

<!-- Filtros estilizados -->
<div class="filter-section">
    <form method="GET" action="{{ route('tasks.index') }}" class="row g-3 align-items-end">
        <div class="col-md-8">
            <label class="form-label fw-bold">
                <i class="fas fa-filter"></i> Filtrar por status
            </label>
            <select name="status" id="status" class="form-select filter-select">
                <option value="">📋 Todas as notas</option>
                <option value="pendente" {{ request('status') == 'pendente' ? 'selected' : '' }}>📝 Pendentes</option>
                <option value="concluida" {{ request('status') == 'concluida' ? 'selected' : '' }}>✅ Concluídas</option>
            </select>
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn-filter w-100">
                <i class="fas fa-search"></i> Filtrar
            </button>
            @if(request('status'))
                <a href="{{ route('tasks.index') }}" class="btn btn-secondary w-100 mt-2" style="border-radius: 25px;">
                    <i class="fas fa-times"></i> Limpar filtro
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Lista de tarefas estilo post-it -->
@if($tasks->count() > 0)
    <div class="row">
        @foreach($tasks as $index => $task)
            @php
                // Define uma cor diferente para cada tarefa baseado no índice
                $colorClass = 'color-' . (($index % 6) + 1);
            @endphp
            <div class="col-md-6 col-lg-4">
                <div class="task-card {{ $colorClass }}">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-start">
                            <h5 class="task-title {{ $task->status ? 'completed' : '' }}">
                                <i class="fas fa-{{ $task->status ? 'check-circle' : 'circle' }} me-2"></i>
                                {{ $task->titulo }}
                            </h5>
                            <span class="priority-badge priority-{{ $task->prioridade }}">
                                <i class="fas fa-flag"></i> 
                                {{ ucfirst($task->prioridade) }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="task-description {{ $task->status ? 'completed' : '' }}">
                            <i class="fas fa-quote-left me-2"></i>
                            {{ $task->descricao ?: 'Sem descrição...' }}
                        </p>
                        
                        @if($task->data_limite)
                            <div class="task-date">
                                <i class="fas fa-calendar-alt"></i>
                                <strong>Data limite:</strong> 
                                {{ date('d/m/Y', strtotime($task->data_limite)) }}
                                @if(!$task->status && $task->data_limite < now())
                                    <span class="badge bg-danger ms-2">
                                        <i class="fas fa-exclamation-triangle"></i> Atrasada!
                                    </span>
                                @endif
                            </div>
                        @endif
                        
                        <div class="task-date">
                            <i class="fas fa-clock"></i>
                            <strong>Criada em:</strong> 
                            {{ date('d/m/Y', strtotime($task->created_at)) }}
                        </div>
                        
                        <div class="task-actions">
                            @if(!$task->status)
                                <form action="{{ route('tasks.toggle-status', $task) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn-task btn-complete">
                                        <i class="fas fa-check-circle"></i> Concluir
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('tasks.toggle-status', $task) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn-task btn-reopen">
                                        <i class="fas fa-undo-alt"></i> Reabrir
                                    </button>
                                </form>
                            @endif
                            
                            <a href="{{ route('tasks.edit', $task) }}" class="btn-task btn-edit">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            
                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir esta nota?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-task btn-delete">
                                    <i class="fas fa-trash-alt"></i> Excluir
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    <!-- Paginação -->
    <div class="d-flex justify-content-center mt-4">
        {{ $tasks->appends(request()->query())->links() }}
    </div>
@else
    <div class="text-center" style="background: rgba(255,255,255,0.9); border-radius: 20px; padding: 50px;">
        <i class="fas fa-sticky-note" style="font-size: 80px; color: #667eea;"></i>
        <h3 class="mt-3">Nenhuma nota encontrada!</h3>
        <p class="text-muted">Que tal criar sua primeira nota adesiva?</p>
        <a href="{{ route('tasks.create') }}" class="btn-create mt-3">
            <i class="fas fa-plus-circle"></i> Criar minha primeira nota
        </a>
    </div>
@endif
@endsection