<?php

namespace App\Charts;

use App\Post;
use App\User;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;

class UserPostMonthlyChart extends BaseChart
{

    public ?string $name = 'user_vs_post_monthly_chart';

    protected $labels = array();
    protected $posts_count = array();
    protected $users_count = array();

    public function __construct()
    {
        for ($i = now()->month - 1; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            array_push($this->labels, $month->format('F'));
            array_push($this->posts_count, Post::whereMonth('created_at', '=', $month)->count());
            array_push($this->users_count, User::whereMonth('created_at', '=', $month)->count());
        }
    }

    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     *
     * @param Request $request
     * @return Chartisan
     */
    public function handler(Request $request): Chartisan
    {
        return Chartisan::build()
            ->labels($this->labels)
            ->dataset('Posts', $this->posts_count)
            ->dataset('Users', $this->users_count);
    }
}
