<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    /**
     * Os atributos que podem ser preenchidos em massa
     */
    protected $fillable = [
        'titulo',
        'descricao',
        'status',
        'prioridade',
        'data_limite',
        'user_id'
    ];

    /**
     * Os atributos que devem ser convertidos para tipos nativos
     */
    protected $casts = [
        'data_limite' => 'date',
        'status' => 'boolean'
    ];

    /**
     * Constantes para prioridades
     */
    const PRIORIDADE_BAIXA = 'baixa';
    const PRIORIDADE_MEDIA = 'media';
    const PRIORIDADE_ALTA = 'alta';

    /**
     * Retorna todas as prioridades disponíveis
     */
    public static function getPrioridades()
    {
        return [
            self::PRIORIDADE_BAIXA => 'Baixa',
            self::PRIORIDADE_MEDIA => 'Média',
            self::PRIORIDADE_ALTA => 'Alta',
        ];
    }

    /**
     * Relacionamento: Tarefa pertence a um usuário
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope para filtrar tarefas pendentes
     */
    public function scopePendente($query)
    {
        return $query->where('status', false);
    }

    /**
     * Scope para filtrar tarefas concluídas
     */
    public function scopeConcluida($query)
    {
        return $query->where('status', true);
    }

    /**
     * Acessor para retornar a classe CSS baseada na prioridade
     */
    public function getPrioridadeClassAttribute()
    {
        return [
            'baixa' => 'success',
            'media' => 'warning',
            'alta' => 'danger',
        ][$this->prioridade] ?? 'secondary';
    }
}