<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Lista todas as tarefas do usuário logado
     */
    public function index(Request $request)
    {
        
        $query = Auth::user()->tasks();

        // Filtro por status
        if ($request->has('status') && $request->status != '') {
            if ($request->status == 'pendente') {
                $query->pendente();
            } elseif ($request->status == 'concluida') {
                $query->concluida();
            }
        }

        // Ordenação
        $tasks = $query->orderBy('data_limite', 'asc')
                       ->orderBy('created_at', 'desc')
                       ->paginate(10);

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Mostra o formulário para criar nova tarefa
     */
    public function create()
    {
        $prioridades = Task::getPrioridades();
        return view('tasks.create', compact('prioridades'));
    }

    /**
     * Armazena uma nova tarefa
     */
    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'prioridade' => 'required|in:baixa,media,alta',
            'data_limite' => 'nullable|date|after_or_equal:today',
        ]);

        // Criar a tarefa
        Auth::user()->tasks()->create([
            'titulo' => $validated['titulo'],
            'descricao' => $validated['descricao'],
            'prioridade' => $validated['prioridade'],
            'data_limite' => $validated['data_limite'] ?? null,
            'status' => false, // Nova tarefa começa como pendente
        ]);

        return redirect()->route('tasks.index')
                         ->with('success', 'Tarefa criada com sucesso!');
    }

    /**
     * Mostra uma tarefa específica
     */
    public function show(Task $task)
    {
        
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado.');
        }

        return view('tasks.show', compact('task'));
    }

    /**
     * Mostra o formulário para editar uma tarefa
     */
    public function edit(Task $task)
    {
        
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado.');
        }

        $prioridades = Task::getPrioridades();
        return view('tasks.edit', compact('task', 'prioridades'));
    }

    /**
     * Atualiza uma tarefa existente
     */
    public function update(Request $request, Task $task)
    {
        
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado.');
        }

        
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'prioridade' => 'required|in:baixa,media,alta',
            'data_limite' => 'nullable|date|after_or_equal:today',
            'status' => 'sometimes|boolean',
        ]);

        // Atualizar a tarefa
        $task->update($validated);

        return redirect()->route('tasks.index')
                         ->with('success', 'Tarefa atualizada com sucesso!');
    }

    /**
     * Remove uma tarefa
     */
    public function destroy(Task $task)
    {
        
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado.');
        }

        $task->delete();

        return redirect()->route('tasks.index')
                         ->with('success', 'Tarefa excluída com sucesso!');
    }

    
    public function toggleStatus(Task $task)
    {
        
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado.');
        }

        $task->status = !$task->status;
        $task->save();

        $status = $task->status ? 'concluída' : 'pendente';
        
        return redirect()->back()
                         ->with('success', "Tarefa marcada como {$status}!");
    }
}