function renderChart(selector, charts, title_text) {
    const chart = new Chartisan({
        el: '#' + selector,
        url: charts,
        hooks: new ChartisanHooks()
            .colors(['#ec4b4b', '#4299E1'])
            .legend({bottom: 0})
            .title({
                textAlign: 'center',
                left: '50%',
                text: title_text,
            })
            .tooltip()
            .datasets([
                {
                    type: 'line',
                    smooth: true,
                    lineStyle: {width: 3},
                    symbolSize: 8,
                    animationEasing: 'cubicInOut',
                },
                'bar',
            ]),
    })
}
