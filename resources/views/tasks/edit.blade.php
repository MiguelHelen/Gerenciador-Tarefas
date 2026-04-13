@extends('layouts.app')

@section('title', 'Editar Nota Adesiva')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="task-card color-2" style="padding: 30px;">
            <div class="text-center mb-4">
                <i class="fas fa-edit" style="font-size: 60px; color: #70a1ff;"></i>
                <h2 class="mt-3">Editar Nota Adesiva</h2>
                <p class="text-muted">Atualize sua tarefa!</p>
            </div>
            
            <form action="{{ route('tasks.update', $task) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label for="titulo" class="form-label fw-bold">
                        <i class="fas fa-heading"></i> Título da Nota
                    </label>
                    <input type="text" 
                           class="form-control @error('titulo') is-invalid @enderror" 
                           id="titulo" 
                           name="titulo" 
                           value="{{ old('titulo', $task->titulo) }}"
                           style="border-radius: 15px; padding: 12px;"
                           required>
                    @error('titulo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="descricao" class="form-label fw-bold">
                        <i class="fas fa-align-left"></i> Descrição
                    </label>
                    <textarea class="form-control @error('descricao') is-invalid @enderror" 
                              id="descricao" 
                              name="descricao" 
                              rows="5"
                              style="border-radius: 15px; padding: 12px;">{{ old('descricao', $task->descricao) }}</textarea>
                    @error('descricao')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="prioridade" class="form-label fw-bold">
                            <i class="fas fa-flag"></i> Prioridade
                        </label>
                        <select class="form-select @error('prioridade') is-invalid @enderror" 
                                id="prioridade" 
                                name="prioridade" 
                                style="border-radius: 15px; padding: 12px;"
                                required>
                            @foreach($prioridades as $value => $label)
                                <option value="{{ $value }}" {{ old('prioridade', $task->prioridade) == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('prioridade')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-4">
                        <label for="data_limite" class="form-label fw-bold">
                            <i class="fas fa-calendar-alt"></i> Data Limite
                        </label>
                        <input type="date" 
                               class="form-control @error('data_limite') is-invalid @enderror" 
                               id="data_limite" 
                               name="data_limite" 
                               value="{{ old('data_limite', $task->data_limite ? date('Y-m-d', strtotime($task->data_limite)) : '') }}"
                               min="{{ date('Y-m-d') }}"
                               style="border-radius: 15px; padding: 12px;">
                        @error('data_limite')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <div class="form-check">
                        <input type="checkbox" 
                               class="form-check-input @error('status') is-invalid @enderror" 
                               id="status" 
                               name="status" 
                               value="1" 
                               {{ old('status', $task->status) ? 'checked' : '' }}
                               style="width: 20px; height: 20px;">
                        <label class="form-check-label ms-2" for="status">
                            <i class="fas fa-check-circle"></i> Marcar como concluída
                        </label>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-between gap-3 mt-4">
                    <a href="{{ route('tasks.index') }}" class="btn-task" style="background: #95a5a6; color: white; text-decoration: none; padding: 12px 24px;">
                        <i class="fas fa-arrow-left"></i> Cancelar
                    </a>
                    <button type="submit" class="btn-task" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 12px 30px;">
                        <i class="fas fa-save"></i> Atualizar Nota
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection