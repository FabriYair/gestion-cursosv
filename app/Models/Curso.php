<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['docente_id', 'nombre', 'descripcion', 'creditos'])]
class Curso extends Model
{
    use HasFactory;

    public function docente(): BelongsTo
    {
        return $this->belongsTo(Docente::class);
    }

    public function estudiantes(): BelongsToMany
    {
        return $this->belongsToMany(Estudiante::class)
            ->withPivot('nota')
            ->withTimestamps();
    }
}
