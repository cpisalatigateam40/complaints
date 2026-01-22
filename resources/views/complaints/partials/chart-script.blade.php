<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('monthlyComplaintsChart');

    const months = @json(array_column($months, 'month'));
    const totals = @json(array_column($months, 'total'));
    const lastYearTotals = @json(array_column($months, 'last_year'));

    const totalThisYear = {{ $currentYearTotal }};
    const totalLastYear = {{ $previousYearTotal }};

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [...months, '{{ $year }}', '{{ $year - 1 }}'],
            datasets: [
                {
                    label: 'Data Bulanan',
                    data: [...totals, 0, 0],
                    backgroundColor: '#3b82f6'
                },
                {
                    label: 'Total Tahun Ini',
                    data: [...Array(12).fill(0), totalThisYear, 0],
                    backgroundColor: '#22c55e'
                },
                {
                    label: 'Total Tahun Lalu',
                    data: [...Array(12).fill(0), 0, totalLastYear],
                    backgroundColor: '#f97316'
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 }}
            },
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>
