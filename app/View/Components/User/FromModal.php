<?php

namespace App\View\Components\User;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FromModal extends Component
{
    public $title;
    public $id;
    public $fromId;
    public $submitButtonText;
    public $submitButtonId;
    /**
     * Create a new component instance.
     */
    public function __construct($title, $id, $fromId, $submitButtonText, $submitButtonId)
    {
        // echo '<br>parth<br>File: '. __FILE__.'<br>Line: '.__LINE__.'<br><pre>';print_r($fromId);echo '</pre>'; die();
        $this->title = $title;
        $this->id = $id;
        $this->fromId = $fromId;
        $this->submitButtonText = $submitButtonText;
        $this->submitButtonId = $submitButtonId;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.user.from-modal');
    }
}
