<script>
    $(function() {
        var ctx = document.getElementById('currcollegevisitBarChartMonthh').getContext('2d');

        // Fixed colors for each college
        var colorMap = {
            'CJE': 'gray',
            'CAS': 'red',
            'CBM': 'pink',
            'CAF': 'green',
            'CCS': 'purple',
            'COE': 'orange',
            'CTE': 'blue'
        };

        // Assign fixed color per acronym; fallback to black if not found
        var barColors = collegeAcronymsmonth.map(college => colorMap[college] || 'black');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: collegeAcronymsmonth,
                datasets: [{
                    label: 'Student Patient Visits per College',
                    data: collegeCountsmonth,
                    backgroundColor: barColors
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>