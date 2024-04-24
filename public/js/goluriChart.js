const ctx = document.getElementById('goluriChart');

var myElement = document.getElementById("goluriChart");
var data = JSON.parse(myElement.dataset.data);
console.log(data[0]); // outputs "hello"

const goluriChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Careu', 'Distanta', 'Faza fixă', 'Cap', 'Penaly'],
        datasets: [{
        label: 'Goluri',
        data,
        borderWidth: 2
        }]
    },
    options: {
        plugins: {
            legend: {
                labels: {
                    // This more specific font property overrides the global property
                    font: {
                        size: 16
                    },
                    color: 'rgb(0, 0, 0)'
                }
            }
        }
    }
});