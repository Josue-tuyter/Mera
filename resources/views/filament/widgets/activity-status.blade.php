<div>
    <canvas id="activityStatusChart"></canvas>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    (function() {
        const ctx = document.getElementById('activityStatusChart').getContext('2d');
        const labels = @json($labels);
        const data = @json($data);
        new Chart(ctx, {
            type: 'doughnut',
            data: { labels: labels, datasets: [{ data: data, backgroundColor: ['#f39c12','#3498db','#2ecc71','#e74c3c'] }] },
            options: { responsive: true }
        });
    })();
</script>