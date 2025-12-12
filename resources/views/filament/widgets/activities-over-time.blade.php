<div>
    <canvas id="activitiesOverTimeChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    (function() {
        const ctx = document.getElementById('activitiesOverTimeChart').getContext('2d');
        const labels = @json($labels);
        const datasets = @json($datasets);
        const chartDatasets = datasets.map((ds, i) => ({
            label: ds.label,
            data: ds.data,
            fill: false,
            borderColor: ['#3366CC','#DC3912','#FF9900','#109618','#990099'][i % 5],
            tension: 0.2,
        }));

        new Chart(ctx, {
            type: 'line',
            data: { labels: labels, datasets: chartDatasets },
            options: { responsive: true, plugins: { legend: { position: 'top' } } }
        });
    })();
</script>