// Call the dataTables jQuery plugin
$(document).ready(function() {
  $('#dataTable').DataTable({ 
  	"ordering": false, 
  	responsive: true,
     'select': {
       'style': 'multi'
     },
     'order': [[1, 'asc']]
  });
});