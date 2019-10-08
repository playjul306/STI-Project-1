// Call the dataTables jQuery plugin
$(document).ready(function() {
  $('#dataTable').dataTable({
    olanguage: {
      url: "French.json"
    }
  });
});
