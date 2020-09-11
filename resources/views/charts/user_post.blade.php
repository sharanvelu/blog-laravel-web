@extends('layouts.blog')

@section('doc_title', 'Stats - Sharan\'s Blog')

@section('content')
    <!-- Page Heading -->
    <div class="mb-4">
        <h1>Stats</h1>
    </div>

    <div class="border shadow rounded py-5">
        <div id="month_wise_chart" style="height: 300px;"></div>
    </div>

    <div class="border shadow rounded py-5 mt-5">
        <div id="year_wise_chart" style="height: 300px;"></div>
    </div>
@endsection

@section('script')
    <script>
        renderChart('month_wise_chart', "@chart('user_vs_post_monthly_chart')", "User vs Post : Monthly");
        renderChart('year_wise_chart', "@chart('user_vs_post_yearly_chart')", "User vs Post : Yearly");
    </script>
@endsection
