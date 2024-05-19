import DataTable from 'datatables.net-dt';
import 'datatables.net-bs5';
import 'datatables.net-responsive-dt';
import 'datatables.net-responsive-bs5';

new DataTable('#data-table', {
    responsive: true,
    columnDefs: [{ width: '10px', targets: 0 }],
})

