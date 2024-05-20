<x-main-layout
    resources="resources/js/jquery.js,'resources/css/dataTables.bootstrap5.css',resources/js/datatables.js,resources/js/chart.js"
    title="Home">
    <div class="container-fuild">
        <h1 class="app-page-title">Overview</h1>
        <div class="row g-4 mb-4">
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
                            <canvas id="chart" width="400" height="400"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <table class="table table-striped nowrap" style="width: 100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Office</th>
                            <th>Age</th>
                            <th>Start date</th>
                            <th>Salary</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Tiger Nixon</td>
                            <td>System Architect</td>
                            <td>Edinburgh</td>
                            <td>61</td>
                            <td>2011-04-25</td>
                            <td>$320,800</td>
                        </tr>
                        <tr>
                            <td>Garrett Winters</td>
                            <td>Accountant</td>
                            <td>Tokyo</td>
                            <td>63</td>
                            <td>2011-07-25</td>
                            <td>$170,750</td>
                        </tr>
                        <tr>
                            <td>Ashton Cox</td>
                            <td>Junior Technical Author</td>
                            <td>San Francisco</td>
                            <td>66</td>
                            <td>2009-01-12</td>
                            <td>$86,000</td>
                        </tr>
                        <tr>
                            <td>Cedric Kelly</td>
                            <td>Senior Javascript Developer</td>
                            <td>Edinburgh</td>
                            <td>22</td>
                            <td>2012-03-29</td>
                            <td>$433,060</td>
                        </tr>
                        <tr>
                            <td>Airi Satou</td>
                            <td>Accountant</td>
                            <td>Tokyo</td>
                            <td>33</td>
                            <td>2008-11-28</td>
                            <td>$162,700</td>
                        </tr>
                        <tr>
                            <td>Brielle Williamson</td>
                            <td>Integration Specialist</td>
                            <td>New York</td>
                            <td>61</td>
                            <td>2012-12-02</td>
                            <td>$372,000</td>
                        </tr>
                        <tr>
                            <td>Herrod Chandler</td>
                            <td>Sales Assistant</td>
                            <td>San Francisco</td>
                            <td>59</td>
                            <td>2012-08-06</td>
                            <td>$137,500</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script type="module">
        $(document).ready(function(){
            (async function() {
            let transaksiPerMonthByCategory = {{Js::from($datasets)}};
                console.log(transaksiPerMonthByCategory);

                var labels = transaksiPerMonthByCategory[Object.keys(transaksiPerMonthByCategory)[0]].data.map(function(item, index) {
                return index + 1;
                });

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
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                }
            );
            })();
        })
    </script>
</x-main-layout>