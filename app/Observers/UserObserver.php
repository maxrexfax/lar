<?php
use App\Models\User;

class UserObserver
{
    /**
     * Обработчик для события "created".
     *
     * @param  User  $user
     * @return void
     */
    public function created(User $user)
    {
        //
    }

    /**
     * Обработчик для события deleting.
     *
     * @param  User  $user
     * @return void
     */
    public function deleting(User $user)
    {
        //
    }
}
