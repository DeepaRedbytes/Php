// Call the dataTables jQuery plugin
// $(document).ready(function() {
//   $('#dataTable').DataTable();
// });
$(document).ready(function() {
  $('#dataTable').DataTable({
    "columnDefs": [{
      "targets": [4,5,6],
      "orderable": false
    }]
  });
});
