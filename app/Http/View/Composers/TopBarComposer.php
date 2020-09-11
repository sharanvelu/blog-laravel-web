<?php

namespace App\Http\View\Composers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use stdClass;

class TopBarComposer
{
    protected $login_data = array();

    /**
     * Create a new profile composer.
     *
     * @return void
     */
    public function __construct()
    {
        if (Auth::check()) {
            $dashboard = new stdClass();
            $dashboard->{'name'} = 'Dashboard';
            $dashboard->{'href'} = '\home';

            $logout = new stdClass();
            $logout->{'name'} = 'Logout';
            $logout->{'href'} = '#';

            array_push($this->login_data, $dashboard);
            array_push($this->login_data, $logout);

            unset($dashboard);
            unset($logout);
        } else {
            $login = new stdClass();
            $login->{'name'} = 'Login';
            $login->{'href'} = '\login';
            array_push($this->login_data, $login);
            unset($login);
        }
    }

    /**
     * Bind data to the view.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with([
            'site_logo' => '\blog/images/topbar_logo.png',
            'login_data' => $this->login_data
        ]);
    }

}
