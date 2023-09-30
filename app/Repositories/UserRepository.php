<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;

class UserRepository
{
    public function all()
    {
        $users = User::whereDoesntHave('roles')
        ->union(
            User::whereHas('roles')
                ->orderBy('name')
        );
        return QueryBuilder::for($users)
        ->allowedFilters('email')
        ->paginate()->appends(request()->query());
    }
}
