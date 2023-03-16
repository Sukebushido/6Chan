<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Nigguh
 */
class topbarComponent extends Component
{
    public $boardName;
    public $showReturn;
    public $showCatalog;
    public $showArchive;
    public $showBottom;
    public $showUpdate;
    public $showRefresh;

    /**
     * Create a new component instance.
     */
    public function __construct(
        $boardName,
        $showReturn = false,
        $showCatalog = false,
        $showArchive = false,
        $showBottom = false,
        $showUpdate = false,
        $showRefresh = false
    ) {
        $this->boardName = $boardName;
        $this->showReturn = $showReturn;
        $this->showCatalog = $showCatalog;
        $this->showArchive = $showArchive;
        $this->showBottom = $showBottom;
        $this->showUpdate = $showUpdate;
        $this->showRefresh = $showRefresh;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.topbar-component');
    }
}
