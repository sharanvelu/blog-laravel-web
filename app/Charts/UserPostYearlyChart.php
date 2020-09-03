<?php

namespace App\Charts;

use App\Post;
use App\User;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;

class UserPostYearlyChart extends BaseChart
{

    public ?string $name = 'user_vs_post_yearly_chart';

    protected $labels = array();
    protected $posts_count = array();
    protected $users_count = array();

    public function __construct()
    {
        for ($i = 3; $i >= 0; $i--) {
            $year = now()->subYears($i);
            array_push($this->labels, $year->format('Y'));
            array_push($this->posts_count, Post::whereYear('created_at', '=', $year)->count());
            array_push($this->users_count, User::whereYear('created_at', '=', $year)->count());
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
