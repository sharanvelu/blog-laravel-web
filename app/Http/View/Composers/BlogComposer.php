<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;

class BlogComposer
{

    protected $first_name;
    protected $surname;

    /**
     * Create a new profile composer.
     *
     * @return void
     */
    public function __construct()
    {
        // Dependencies automatically resolved by service container...
        $this->first_name = 'Velu';
        $this->surname = "Sharan";
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with([
            'first_name'=>$this->first_name,
            'surname'=>$this->surname
        ]);
    }
}
