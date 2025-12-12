<div>
    <canvas id="materialsConsumptionChart"></canvas>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    (function() {
        const ctx = document.getElementById('materialsConsumptionChart').getContext('2d');
        const labels = @json($labels);
        const data = @json($data);
        new Chart(ctx, {
            type: 'bar',
            data: { labels: labels, datasets: [{ label: 'Consumo total', data: data, backgroundColor: '#4caf50' }] },
            options: { responsive: true, plugins: { legend: { display: false } } }
        });
    })();
</script>