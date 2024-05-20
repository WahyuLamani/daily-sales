<x-main-layout
    resources="resources/js/jquery.js,resources/js/chart.js"
    title="Home">
    <div class="container-fuild">
        <div class="row g-4 mb-2">
        @foreach ($count as $key => $value)
            <div class="col-6 col-lg-3">
                <x-card-dashboard :$key :$value/>
            </div>
        @endforeach
        </div>
        <!--//row-->
        <div class="row g-4 mb-2">
            <div class="col-12">   
                <div class="my-3">
                    <div class="card">
                        <div class="card-body">
                            <canvas id="chart" width="850" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="module">
        $(document).ready(function(){
            (async function() {
                let transaksiPerMonthByCategory = {{Js::from($datasets)}};
                let months = {{Js::from($months)}}
                console.log(months);

                // var labels = transaksiPerMonthByCategory[Object.keys(transaksiPerMonthByCategory)[0]].data.map(function(item, index) {
                // return index + 1;
                // });
                let labels = Object.values(months);

                var data = Object.keys(transaksiPerMonthByCategory).map(function(key) {
                    return transaksiPerMonthByCategory[key].data;
                });

                var colors = Object.keys(transaksiPerMonthByCategory).map(function(key) {
                    return transaksiPerMonthByCategory[key].backgroundColor;
                });

                new Chart(
                    $('#chart'),
                    {
                        type: 'line',
                        data: {
                        labels: labels,
                        datasets: Object.keys(transaksiPerMonthByCategory).map(function(key, index) {
                            return {
                                label: transaksiPerMonthByCategory[key].label,
                                data: data[index],
                                backgroundColor: colors[index],
                                borderWidth: 1
                                };
                            })
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                title: {
                                    display: true,
                                    text: 'Total penjualan tahun terakhir',
                                    font: {
                                        size: 20,
                                        weight: 'bold',
                                        lineHeight: 1.2,
                                    },
                                    padding: {
                                        top: 3,
                                        bottom: 9
                                    },
                                    align: 'start',
                                    fullSize: true,
                                }
                            }
                        }
                    }
                );
            })();
        })
    </script>
</x-main-layout>