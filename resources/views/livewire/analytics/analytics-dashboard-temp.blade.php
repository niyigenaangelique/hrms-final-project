

    function drawHireExit(id) {
        var el = document.getElementById(id);
        if (!el) return;
        safeDestroy(id);
        new Chart(el, {
            type: 'bar',
            data: {
                labels: hireExit.map(function(d) { return d.label; }),
                datasets: [
                    {
                        label: 'Hires',
                        data: hireExit.map(function(d) { return d.hires; }),
                        backgroundColor: 'rgba(59,111,232,0.75)',
                        borderRadius: 6, borderSkipped: false,
                    },
                    {
                        label: 'Exits',
                        data: hireExit.map(function(d) { return d.exits; }),
                        backgroundColor: 'rgba(244,63,94,0.65)',
                        borderRadius: 6, borderSkipped: false,
                    }
                ]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: {
                    legend: { display: true, position: 'top', labels: { usePointStyle: true, pointStyle: 'circle', padding: 16, font: { weight: '600' } } },
                    tooltip: { mode: 'index', intersect: false }
                },
                scales: {
                    x: { grid: { display: false }, ticks: { maxRotation: 0, font: { size: 11 } } },
                    y: { grid: { color: 'rgba(59,111,232,0.06)' }, ticks: { precision: 0 }, beginAtZero: true }
                }
            }
        });
    }

    // ── 2. Dept bar chart ────────────────────────────────
    function drawDept(id) {
        var el = document.getElementById(id);
        if (!el) return;
        safeDestroy(id);
        var colors = [INDIGO,VIOLET,TEAL,AMBER,GREEN,ROSE,PURPLE,BLUE];
        new Chart(el, {
            type: 'bar',
            data: {
                labels: deptData.map(function(d) { return d.label; }),
                datasets: [{
                    data: deptData.map(function(d) { return d.value; }),
                    backgroundColor: deptData.map(function(_,i) { return colors[i % colors.length]; }),
                    borderRadius: 6, borderSkipped: false,
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true, maintainAspectRatio: false,
                plugins: { tooltip: { callbacks: { label: function(c) { return ' ' + c.raw + ' employees'; } } } },
                scales: {
                    x: { grid: { color: 'rgba(59,111,232,0.06)' }, ticks: { precision: 0 }, beginAtZero: true },
                    y: { grid: { display: false }, ticks: { font: { size: 11, weight: '600' } } }
                }
            }
        });
    }

    // ── 3. Gender donut ──────────────────────────────────
    function drawGender(id) {
        var el = document.getElementById(id);
        if (!el) return;
        safeDestroy(id);
        new Chart(el, {
            type: 'doughnut',
            data: {
                labels: genderData.map(function(d) { return d.label; }),
                datasets: [{
                    data: genderData.map(function(d) { return d.value; }),
                    backgroundColor: [INDIGO, TEAL, ROSE],
                    borderWidth: 0,
                    hoverOffset: 6,
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false, cutout: '68%',
                plugins: { tooltip: { callbacks: { label: function(c) { return ' ' + c.label + ': ' + c.raw + ' (' + genderData[c.dataIndex].percent + '%)'; } } } }
            }
        });
    }

    // ── 4. Age bar ───────────────────────────────────────
    function drawAge(id) {
        var el = document.getElementById(id);
        if (!el) return;
        safeDestroy(id);
        var total = ageData.reduce(function(s,d) { return s + d.value; }, 0);
        new Chart(el, {
            type: 'bar',
            data: {
                labels: ageData.map(function(d) { return d.label; }),
                datasets: [{
                    data: ageData.map(function(d) { return d.value; }),
                    backgroundColor: [
                        'rgba(59,111,232,0.65)','rgba(59,111,232,0.75)','rgba(59,111,232,0.85)',
                        'rgba(59,111,232,0.65)','rgba(59,111,232,0.50)'
                    ],
                    borderRadius: 6, borderSkipped: false,
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { tooltip: { callbacks: { label: function(c) {
                    return ' ' + c.raw + ' (' + Math.round(c.raw/total*100) + '%)';
                } } } },
                scales: {
                    x: { grid: { display: false } },
                    y: { grid: { color: 'rgba(59,111,232,0.06)' }, ticks: { precision: 0 }, beginAtZero: true }
                }
            }
        });
    }

    // ── 5. Turnover line ─────────────────────────────────
    function drawTurnover(id) {
        var el = document.getElementById(id);
        if (!el) return;
        safeDestroy(id);
        new Chart(el, {
            type: 'line',
            data: {
                labels: turnData.map(function(d) { return d.label; }),
                datasets: [
                    {
                        label: 'Turnover %',
                        data: turnData.map(function(d) { return d.rate; }),
                        borderColor: ROSE, backgroundColor: 'rgba(244,63,94,0.10)',
                        tension: 0.4, fill: true, pointRadius: 4, pointBackgroundColor: ROSE,
                        borderWidth: 2.5,
                    },
                    {
                        label: '15% Threshold',
                        data: turnData.map(function() { return 15; }),
                        borderColor: AMBER, borderDash: [6,4], borderWidth: 2,
                        pointRadius: 0, fill: false,
                    }
                ]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: {
                    legend: { display: true, position: 'top', labels: { usePointStyle: true, pointStyle: 'circle', padding: 16 } },
                    tooltip: { mode: 'index', intersect: false, callbacks: { label: function(c) { return ' ' + c.dataset.label + ': ' + c.raw + '%'; } } }
                },
                scales: {
                    x: { grid: { display: false } },
                    y: { grid: { color: 'rgba(15,22,41,0.06)' }, ticks: { callback: function(v) { return v + '%'; } }, beginAtZero: true }
                }
            }
        });
    }

    // ── 6. Dept Turnover (simulated) ─────────────────────
    function drawDeptTurnover(id) {
        var el = document.getElementById(id);
        if (!el) return;
        safeDestroy(id);
        var depts  = deptData.slice(0, 6);
        var rates  = [18.2, 14.5, 9.8, 12.1, 7.4, 11.6];
        var colors = depts.map(function(_,i) { return i === 0 ? ROSE : (rates[i] > 12 ? AMBER : GREEN); });
        new Chart(el, {
            type: 'bar',
            data: {
                labels: depts.map(function(d) { return d.label; }),
                datasets: [{
                    data: rates.slice(0, depts.length),
                    backgroundColor: colors,
                    borderRadius: 6, borderSkipped: false,
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { tooltip: { callbacks: { label: function(c) { return ' ' + c.raw + '% turnover'; } } } },
                scales: {
                    x: { grid: { display: false } },
                    y: { grid: { color: 'rgba(15,22,41,0.06)' }, ticks: { callback: function(v) { return v + '%'; } }, beginAtZero: true }
                }
            }
        });
    }

    // ── 7. Nationality distribution ──────────────────────
    function drawNationality(id) {
        var el = document.getElementById(id);
        if (!el) return;
        safeDestroy(id);
        new Chart(el, {
            type: 'doughnut',
            data: {
                labels: nationalityData.map(function(d) { return d.label; }),
                datasets: [{
                    data: nationalityData.map(function(d) { return d.value; }),
                    backgroundColor: [INDIGO, TEAL, ROSE, AMBER, GREEN, PURPLE],
                    borderWidth: 0,
                    cutout: '65%'
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: {
                    legend: { display: true, position: 'bottom', labels: { usePointStyle: true, boxWidth: 8, padding: 12 } }
                }
            }
        });
    }

    // ── 8. Skill gap radar / bar ──────────────────────────
    function drawSkillGap(id) {
        var el = document.getElementById(id);
        if (!el) return;
        safeDestroy(id);
        var top5 = skillGap.sort(function(a,b) { return b.gap - a.gap; }).slice(0,5);
        new Chart(el, {
            type: 'bar',
            data: {
                labels: top5.map(function(s) { return s.skill; }),
                datasets: [
                    {
                        label: 'Have',
                        data: top5.map(function(s) { return s.have; }),
                        backgroundColor: 'rgba(59,111,232,0.75)',
                        borderRadius: 5,
                    },
                    {
                        label: 'Gap',
                        data: top5.map(function(s) { return s.gap; }),
                        backgroundColor: 'rgba(244,63,94,0.55)',
                        borderRadius: 5,
                    }
                ]
            },
            options: {
                indexAxis: 'y',
                responsive: true, maintainAspectRatio: false,
                plugins: {
                    legend: { display: true, position: 'top', labels: { usePointStyle: true, pointStyle: 'circle' } }
                },
                scales: {
                    x: { stacked: true, grid: { color: 'rgba(59,111,232,0.06)' }, ticks: { precision: 0 } },
                    y: { stacked: true, grid: { display: false }, ticks: { font: { size: 11 } } }
                }
            }
        });
    }

    // ── 8. Prediction line ───────────────────────────────
    function drawPredict(id) {
        var el = document.getElementById(id);
        if (!el) return;
        safeDestroy(id);
        new Chart(el, {
            type: 'line',
            data: {
                labels: predicted.map(function(d) { return d.label; }),
                datasets: [
                    {
                        label: 'Optimistic',
                        data: predicted.map(function(d) { return d.optimistic; }),
                        borderColor: GREEN, backgroundColor: 'rgba(16,185,129,0.08)',
                        tension: 0.4, fill: true, pointRadius: 4, borderWidth: 2,
                    },
                    {
                        label: 'Base',
                        data: predicted.map(function(d) { return d.projected; }),
                        borderColor: INDIGO, backgroundColor: 'rgba(59,111,232,0.06)',
                        tension: 0.4, fill: true, pointRadius: 4, borderWidth: 2.5,
                    },
                    {
                        label: 'Conservative',
                        data: predicted.map(function(d) { return d.conservative; }),
                        borderColor: ROSE, backgroundColor: 'rgba(244,63,94,0.06)',
                        tension: 0.4, fill: true, pointRadius: 4, borderWidth: 2,
                    }
                ]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: {
                    legend: { display: true, position: 'top', labels: { usePointStyle: true, pointStyle: 'circle', padding: 16 } },
                    tooltip: { mode: 'index', intersect: false }
                },
                scales: {
                    x: { grid: { display: false } },
                    y: { grid: { color: 'rgba(59,111,232,0.06)' }, ticks: { precision: 0 } }
                }
            }
        });
    }

    // ── Init all charts ─────────────────────────────────
    function initCharts() {
        drawHireExit('hireExitChart');
        drawHireExit('hireExitChart2');
        drawDept('deptChart');
        drawGender('genderChart');
        drawGender('genderChart2');
        drawAge('ageChart');
        drawAge('ageChart2');
        drawTurnover('turnoverChart');
        drawDeptTurnover('deptTurnoverChart');
        drawSkillGap('skillGapChart');
        drawNationality('nationalityChart');
        drawPredict('predictChart');
    }

    // Wait for DOM + Chart.js
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCharts);
    } else {
        initCharts();
    }

    // Re-init after Livewire re-renders
    document.addEventListener('livewire:navigated', () => {
        setTimeout(initCharts, 200); // More generous for initial page load
    });

    document.addEventListener('livewire:updated', function() {
        // Use requestAnimationFrame to wait for the DOM to be fully patched
        requestAnimationFrame(() => {
            setTimeout(initCharts, 100);
        });
    });

    // Handle Alpine init if used
    window.initAnalyticsCharts = initCharts;
})();
</script>

</div>
