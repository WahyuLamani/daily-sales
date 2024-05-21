<x-main-layout resources="resources/js/jquery.js,resources/js/chart.js,resources/js/regression.js" title="Analisis">
    <div class="container-fuild">
        <h1 class="app-page-title">Analisis</h1>
        <div class="card">
            <div class="card-body">
                <form id="transaksiForm">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="start_date">Tanggal Mulai</label>
                                <input type="date" name="start_date" id="start_date" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="end_date">Tanggal Akhir</label>
                                <input type="date" name="end_date" id="end_date" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="kategori">Kategori</label>
                                <select name="kategori" id="kategori" class="form-control" required>
                                    <option disabled selected>Pilih kategori</option>
                                    @foreach($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3 pt-4">
                            <button type="submit" class="btn btn-primary">Buat analisa</button>
                        </div>
                    </div>
                </form> 
            </div>
        </div>
        <div class="row" id="showAfter">
            <div class="col-md-5">
                <div class="card mt-2">
                    <div class="card-body">
                        <div class="card-title d-flex justify-content-between">
                            <h5>Hasil Analisis</h5>
                            <button id="predictNextMonth" class="btn app-btn-primary">Prediksi bulan selanjutnya</button>
                        </div>
                        <table class="table table-bordered" id="hasilAnalisisTable">
                            <thead>
                                <tr>
                                    <th>Bulan</th>
                                    <th>Total</th>
                                    <th>Prediksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Hasil Analisis akan ditambahkan di sini -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-7 mt-2">
                <div class="card app-card">
                    <div class="card-body">
                        <canvas id="chart" width="470" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="module">
        $("#showAfter").hide();
        $(document).ready(function(){
            let chartInstance = null;
            let x = [];
            let y = [];
            let analisisData = [];
            let labels = [];
            let result;
            let gradient;
            let intercept;
            let futureDateIndex = 0;
            function getMonthName(monthNumber) {
                const monthNames = [
                    "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                    "Juli", "Agustus", "September", "Oktober", "November", "Desember"
                ];
                return monthNames[monthNumber - 1];
            }

            $('#transaksiForm').submit(function(event){
                event.preventDefault();
                let startDate = $('#start_date').val();
                let endDate = $('#end_date').val();
                let kategoriId = $('#kategori').val();
                x = [];
                y = [];
                analisisData = [];
                labels = [];
                result;
                gradient;
                intercept;

                $.ajax({
                    url: '{{ route("transaksi.data") }}',
                    type: 'GET',
                    data: {
                        start_date: startDate,
                        end_date: endDate,
                        kategori: kategoriId
                    },
                    success: function(data) {
                        console.log(data);  // Periksa struktur data di console

                        

                        data.forEach(function(item, index) {
                            let monthYear = getMonthName(item.month);
                            labels.push(monthYear);
                            x.push(index + 1);
                            y.push(item.total);

                            analisisData.push({
                                kategori: item.nama_kategori,
                                year: item.year,
                                month: monthYear,
                                total: item.total,
                                prediksi: 0 // Placeholder for prediction value
                            });
                        });

                        // Least Square Calculation using regression package
                        result = regression.linear(x.map((value, index) => [value, y[index]]));
                        gradient = result.equation[0];
                        intercept = result.equation[1];

                        x.forEach(function(value, index) {
                            analisisData[index].prediksi = gradient * value + intercept;
                        });
                        let Xpredict = x.length + 1

                        // Update Table
                        let tableBody = $('#hasilAnalisisTable tbody');
                        tableBody.empty();
                        analisisData.forEach(function(entry) {
                            tableBody.append('<tr>' +
                                '<td>' + entry.month + ' ' + entry.year + '</td>' +
                                '<td>' + entry.total + '</td>' +
                                '<td>' + entry.prediksi.toFixed(2) + '</td>' +
                                '</tr>');
                        });
                        $("#showAfter").show();

                        if (chartInstance !== null) {
                            chartInstance.destroy();
                        }
                        chartInstance = new Chart(
                            $('#chart'),
                            {
                                type: 'line',
                                data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Total',
                                    data: y,
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1,
                                    fill: false
                                },
                                {
                                    label: 'Prediksi',
                                    data: analisisData.map(item => item.prediksi),
                                    borderColor: 'rgba(153, 102, 255, 1)',
                                    borderWidth: 1,
                                    fill: false
                                }]
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
                                            text: 'Least Square',
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
                    }
                });
            })
            $('#predictNextMonth').click(function() {
                futureDateIndex++;
                let lastIndex = labels.length;
                let futureDate = new Date();
                futureDate.setMonth(futureDate.getMonth() + futureDateIndex);
                let prediksiMonth = getMonthName(futureDate.getMonth() + 1) + ' ' + futureDate.getFullYear();
                let prediksiNilai = gradient * (lastIndex + 1) + intercept;

                labels.push(prediksiMonth);
                y.push(null); // Tidak ada data total untuk bulan prediksi
                analisisData.push({
                    kategori: '',
                    year: futureDate.getFullYear(),
                    month: prediksiMonth,
                    total: 0,
                    prediksi: prediksiNilai
                });

                // Update Table
                let tableBody = $('#hasilAnalisisTable tbody');
                tableBody.append('<tr>' +
                    '<td>' + prediksiMonth + '</td>' +
                    '<td>0</td>' +
                    '<td>' + prediksiNilai.toFixed(2) + '</td>' +
                    '</tr>');

                // Update Chart
                chartInstance.data.labels = labels;
                chartInstance.data.datasets[1].data = analisisData.map(item => item.prediksi);
                chartInstance.update();
            });

        });
    </script>
</x-main-layout>