<script>
    // Shared college color map
    var collegeColorMap = {
        'CJE': 'gray',
        'CAS': 'red',
        'CBM': 'pink',
        'CAF': 'green',
        'CCS': 'purple',
        'COE': 'orange',
        'CTE': 'blue'
    };

    function collegeBarColors(acronyms) {
        return (acronyms || []).map(function (college) {
            return collegeColorMap[college] || 'black';
        });
    }
</script>

<script>
    $(function() {
        var acronyms = (typeof collegeAcronymsmonth !== 'undefined') ? collegeAcronymsmonth : [];
        var counts = (typeof collegeCountsmonth !== 'undefined') ? collegeCountsmonth : [];
        var ctx = document.getElementById('currcollegevisitBarChartMonthh').getContext('2d');

        window.collegeMonthChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: acronyms.slice(),
                datasets: [{
                    label: 'Student Patient Visits per College',
                    data: counts.slice(),
                    backgroundColor: collegeBarColors(acronyms)
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
        var acronyms = (typeof collegeAcronymsdaily !== 'undefined') ? collegeAcronymsdaily : [];
        var counts = (typeof collegeCountsdaily !== 'undefined') ? collegeCountsdaily : [];
        var ctx = document.getElementById('currcollegevisitBarChart').getContext('2d');

        window.collegeDailyChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: acronyms.slice(),
                datasets: [{
                    label: 'Student Patient Visits per College',
                    data: counts.slice(),
                    backgroundColor: collegeBarColors(acronyms)
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

        function getChartBarColor() {
            const isDarkMode = htmlElement.getAttribute('data-bs-theme') === 'dark';
            return isDarkMode ? '#aaabac' : '#18181b';
        }

        // --- CHART 3: Single Bar Chart (Total Visits, Jan-Dec) ---
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

        // --- CHART 4: Multi-Bar Chart by Category (Jan–Dec) ---
        const rawCategoryDatasets = @json($categoryMonthlyDatasets ?? []);

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

        window.formatCategoryDatasets = formatCategoryDatasets;

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

        // --- AJAX year filter: updates EVERYTHING date-based, no page reload ---
        function setYearLoading(isLoading) {
            if (yearLoading) yearLoading.classList.toggle('d-none', !isLoading);
            if (yearSelect) yearSelect.disabled = isLoading;
        }

        function setText(id, value) {
            const el = document.getElementById(id);
            if (el && typeof value !== 'undefined') el.textContent = value;
        }

        async function refreshDashboardYear(year) {
            setYearLoading(true);
            try {
                const response = await fetch(dashboardDataUrl + '?year=' + encodeURIComponent(year), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                });
                if (!response.ok) throw new Error('Failed to load dashboard data.');
                const p = await response.json();

                // 1. Top count cards
                setText('ptodayCount', Number(p.ptodayvisits || 0).toLocaleString());
                setText('pthismonthCount', Number(p.pthismonthvisits || 0).toLocaleString());
                setText('ptodayLabel', p.dayLabel);
                setText('pthismonthLabel', p.monthLabel);

                // 2. College charts
                if (window.collegeMonthChart && p.collegeAcronymsmonth) {
                    window.collegeMonthChart.data.labels = p.collegeAcronymsmonth;
                    window.collegeMonthChart.data.datasets[0].data = p.collegeCountsmonth || [];
                    window.collegeMonthChart.data.datasets[0].backgroundColor = collegeBarColors(p.collegeAcronymsmonth);
                    window.collegeMonthChart.update();
                }
                if (window.collegeDailyChart && p.collegeAcronymsdaily) {
                    window.collegeDailyChart.data.labels = p.collegeAcronymsdaily;
                    window.collegeDailyChart.data.datasets[0].data = p.collegeCountsdaily || [];
                    window.collegeDailyChart.data.datasets[0].backgroundColor = collegeBarColors(p.collegeAcronymsdaily);
                    window.collegeDailyChart.update();
                }
                setText('collegeMonthLabel', p.monthLabel);
                setText('collegeDailyLabel', p.dayLabel);

                // 3. Yearly charts
                if (window.pvisitMonthlyChart) {
                    window.pvisitMonthlyChart.data.datasets[0].data = p.chartData || [];
                    window.pvisitMonthlyChart.update();
                }
                if (window.pcatvisitMonthlyChart) {
                    window.pcatvisitMonthlyChart.data.datasets = formatCategoryDatasets(p.categoryMonthlyDatasets);
                    window.pcatvisitMonthlyChart.update();
                }
                setText('pvisitYearLabel', p.year);
                setText('pcatYearLabel', p.year);

                // Keep URL in sync without reloading
                const url = new URL(window.location.href);
                url.searchParams.set('year', p.year);
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
