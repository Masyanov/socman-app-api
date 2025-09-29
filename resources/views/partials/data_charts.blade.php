<canvas id="microcycleChart" width="600px" height="350px"></canvas>

<script>
    (function() {
        const ctx = document.getElementById('microcycleChart').getContext('2d');
        const chartData = @json($resultsCycle);

        const gradient = ctx.createLinearGradient(0, 0, 0, ctx.canvas.height);
        gradient.addColorStop(0, 'rgba(0, 255, 0, 0.4)');
        gradient.addColorStop(1, 'rgba(255, 0, 0, 0.4)');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartData.labels.map((lbl, i) => lbl + '\n' + chartData.dates[i]),
                datasets: [
                    {
                        type: 'bar',
                        label: '{{ __('messages.Нагрузка') }}',
                        data: chartData.load,
                        backgroundColor: 'rgba(255, 206, 86, 0.9)',
                        borderWidth: 1,
                        datalabels: {
                            anchor: 'end',     // Anchors label to end of the element (top of bar)
                            align: 'end',      // Align label to end (just outside the bar)
                            offset: -25,        // Move label down by 20
                            color: '#ffffff',
                            font: {weight: 'bold', size: 13 },
                            formatter: function(v) {return v;}
                        }
                    },
                    {
                        type: 'line',
                        label: '{{ __('messages.Восстановление') }}',
                        data: chartData.recovery,
                        fill: true,
                        backgroundColor: gradient,
                        borderColor: 'rgba(0, 255, 170, 0.6)',
                        pointRadius: 6,
                        pointBackgroundColor: 'rgba(0, 255, 170, 1)',
                        order: 0,
                        datalabels: {
                            anchor: 'end',   // Anchors label to start of element (top side for line)
                            align: 'end',    // Align label upward from point
                            offset: 5,        // Move label up by 20!
                            color: 'rgba(0, 255, 170, 1)',
                            font: {weight: 'bold', size: 13 },
                            formatter: function(v) {return v;}
                        }
                    }
                ]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'bottom', // Важно! размещаем под графиком
                        labels: { color: '#fff' }
                    },
                    title: {
                        display: true,
                        text: '{{ __('messages.Субъективная оценка нагрузки и восстановления в динамике микроцикла') }}',
                        color: '#fff',
                        padding: { top: 10, bottom: 54 },
                        font: { size: 16 }
                    }
                },
                scales: {
                    x: {
                        ticks: { color: '#fff' },
                        grid: { color: '#555' }
                    },
                    y: {
                        beginAtZero: true,
                        max: 10,
                        ticks: { color: '#fff' },
                        grid: { color: '#555' }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    })();
</script>
