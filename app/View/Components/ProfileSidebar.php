<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class ProfileSidebar extends Component
{
    public $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function render()
    {
        return view('components.profile-sidebar');
    }

}
