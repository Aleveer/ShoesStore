// Revenue Income Chart
const revenueIncome = document.getElementById('Revenue_Income');

new Chart(revenueIncome, {
    type: 'line',
    data: {
        labels: ['Monday', 'Tuesday', 'Wednesdays', 'Thursdays', 'Friday', 'Saturdays', 'Sundays'],
        datasets: [{
            label: 'VNĐ',
            data: [900000, 700000, 900000, 700000, 600000, 1300000, 2500000],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Total Login
const totalIncome = document.getElementById('Total_Login');

new Chart(totalIncome, {
    type: 'bar',
    data: {
        labels: ['Monday', 'Tuesday', 'Wednesdays', 'Thursdays', 'Friday', 'Saturdays', 'Sundays'],
        datasets: [{
            label: 'User Login',
            data: [12, 19, 3, 5, 2, 3, 10],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});