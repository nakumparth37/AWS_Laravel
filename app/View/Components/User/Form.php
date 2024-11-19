<?php

namespace App\View\Components\User;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\User;

class Form extends Component
{
    /**
     * Create a new component instance.
     */
    public $roles;
    public $user;
    public $submitButtonText;
    public $submitButtonId;

    public function __construct(User $user, $submitButtonText, $submitButtonId)
    {
        $this->roles = User::getUserRoles();
        $this->user = $user;
        $this->submitButtonText = $submitButtonText;
        $this->submitButtonId = $submitButtonId;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.user.form');
    }
}
