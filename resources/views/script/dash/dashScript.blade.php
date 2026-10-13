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

<script>
    $(function() {
        var ctx = document.getElementById('currcollegevisitBarChart').getContext('2d');

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
        var barColors = collegeAcronymsdaily.map(college => colorMap[college] || 'black');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: collegeAcronymsdaily,
                datasets: [{
                    label: 'Student Patient Visits per College',
                    data: collegeCountsdaily,
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const htmlElement = document.documentElement;
        const dashboardDataUrl = "{{ route('dashboard.data') }}";
        const yearSelect = document.getElementById('yearSelect');
        const yearLoading = document.getElementById('yearLoading');
        const pvisitYearLabel = document.getElementById('pvisitYearLabel');
        const pcatYearLabel = document.getElementById('pcatYearLabel');

        function getChartBarColor() {
            const isDarkMode = htmlElement.getAttribute('data-bs-theme') === 'dark';
            return isDarkMode ? '#aaabac' : '#18181b';
        }

        // --- CHART 1: Single Bar Chart (Total Visits) ---
        const liveChartData = @json($chartData ?? array_fill(0, 12, 0));
        const ctx1 = document.getElementById('pvisitMonthlyChart').getContext('2d');

        window.pvisitMonthlyChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Consultations',
                    data: liveChartData,
                    backgroundColor: getChartBarColor(),
                    borderRadius: 4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false } },
                    y: { 
                        grid: { color: '#f4f4f5' },
                        ticks: { precision: 0 }
                    }
                }
            }
        });

        // --- CHART 2: Multi-Bar Chart by Category (Jan–Dec) ---
        const rawCategoryDatasets = @json($categoryMonthlyDatasets ?? []);
        
        // Assign unique colors to each category bar
        const categoryColors = ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#06b6d4'];
        const categoryLabelMap = {
            '1': 'Student',
            '2': 'Faculty',
            '3': 'Administrative Personnel',
            '4': 'Contractual/Job Order Personnel',
            '5': 'Guest'
        };

        function formatCategoryDatasets(rawDatasets) {
            return (rawDatasets || []).map((dataset, index) => {
                const customLabel = categoryLabelMap[dataset.label] || dataset.label;
                return {
                    label: customLabel,
                    data: dataset.data,
                    backgroundColor: categoryColors[index % categoryColors.length],
                    borderRadius: 4
                };
            });
        }

        const ctx2 = document.getElementById('pcatvisitMonthlyChart').getContext('2d');

        window.pcatvisitMonthlyChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: formatCategoryDatasets(rawCategoryDatasets)
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    x: { grid: { display: false } },
                    y: { 
                        grid: { color: '#f4f4f5' },
                        ticks: { precision: 0 },
                        beginAtZero: true
                    }
                }
            }
        });

        // --- AJAX year filter (no full page reload, data only) ---
        function setYearLoading(isLoading) {
            if (yearLoading) yearLoading.classList.toggle('d-none', !isLoading);
            if (yearSelect) yearSelect.disabled = isLoading;
        }

        async function refreshDashboardYear(year) {
            setYearLoading(true);
            try {
                const response = await fetch(dashboardDataUrl + '?year=' + encodeURIComponent(year), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                });
                if (!response.ok) throw new Error('Failed to load dashboard data.');
                const payload = await response.json();

                if (window.pvisitMonthlyChart) {
                    window.pvisitMonthlyChart.data.datasets[0].data = payload.chartData || [];
                    window.pvisitMonthlyChart.update();
                }

                if (window.pcatvisitMonthlyChart) {
                    window.pcatvisitMonthlyChart.data.datasets = formatCategoryDatasets(payload.categoryMonthlyDatasets);
                    window.pcatvisitMonthlyChart.update();
                }

                if (pvisitYearLabel) pvisitYearLabel.textContent = payload.year;
                if (pcatYearLabel) pcatYearLabel.textContent = payload.year;

                // Keep URL in sync without reloading
                const url = new URL(window.location.href);
                url.searchParams.set('year', payload.year);
                window.history.replaceState({}, '', url);
            } catch (e) {
                if (window.toastr) toastr.error('Could not load data for selected year.');
            } finally {
                setYearLoading(false);
            }
        }

        if (yearSelect) {
            yearSelect.addEventListener('change', function () {
                refreshDashboardYear(this.value);
            });
        }

        // Watch for theme changes (Dark Mode / Light Mode)
        const themeObserver = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.type === 'attributes' && mutation.attributeName === 'data-bs-theme') {
                    if (window.pvisitMonthlyChart) {
                        window.pvisitMonthlyChart.data.datasets[0].backgroundColor = getChartBarColor();
                        window.pvisitMonthlyChart.update();
                    }
                }
            });
        });

        themeObserver.observe(htmlElement, { 
            attributes: true, 
            attributeFilter: ['data-bs-theme'] 
        });
    });
</script>