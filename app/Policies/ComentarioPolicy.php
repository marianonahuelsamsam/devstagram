<?php

namespace App\Policies;

use App\Models\Comentario;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ComentarioPolicy
{
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Comentario $comentario): bool
    {
        return $user->id === $comentario->user_id;
    }


}
