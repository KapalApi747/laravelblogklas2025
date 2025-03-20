<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    /**
     * Bepaal of de gebruiker ALLE posts mag bekijken.
     * - Admins en Authors mogen alles zien.
     * - Subscribers mogen ook posts bekijken.
     */
    public function viewAny(User $user): bool
    {

        $roles = $user->roles->pluck('name'); // Cache rollen in de variabele

        return $roles->contains('admin') ||
            $roles->contains('author') ||
            $roles->contains('subscriber');
    }

    /**
     * Bepaal of de gebruiker EEN SPECIFIEKE post mag bekijken.
     * - Iedereen mag posts bekijken.
     */
    public function view(User $user, Post $post): bool
    {
        return true;
    }

    /**
     * Bepaal of de gebruiker een post mag AANMAKEN.
     * - Alleen Admins en Authors mogen nieuwe posts maken.
     */
    public function create(User $user): bool
    {
        return $user->roles()->pluck('name')->contains(fn ($role) => in_array($role, ['admin', 'author']));
    }

    /**
     * Bepaal of de gebruiker een post mag BEWERKEN.
     * - Admins mogen ALLE posts bewerken.
     * - Authors mogen ENKEL hun EIGEN posts bewerken.
     */
    public function update(User $user, Post $post): bool
    {
        return $user->roles()->pluck('name')->contains('admin') ||
            $user->id === $post->author_id;
    }

    /**
     * Bepaal of de gebruiker een post mag VERWIJDEREN.
     * - Admins mogen ALLE posts verwijderen.
     * - Authors mogen ENKEL hun EIGEN posts verwijderen.
     */
    public function delete(User $user, Post $post): bool
    {
        return $user->roles()->pluck('name')->contains('admin') ||
            $user->id === $post->author_id;
    }

    /**
     * Bepaal of de gebruiker een VERWIJDERDE post mag HERSTELLEN.
     * - Alleen Admins mogen verwijderde posts herstellen.
     */
    public function restore(User $user, Post $post): bool
    {
        return $user->roles()->pluck('name')->contains('admin');
    }

    /**
     * Bepaal of de gebruiker een post PERMANENT mag verwijderen.
     * - Alleen Admins mogen posts volledig verwijderen.
     */
    public function forceDelete(User $user, Post $post): bool
    {
        return $user->roles()->pluck('name')->contains('admin');
    }
}
