<!DOCTYPE html>
<html>
<body>

<p>Click the button to print the current page.</p>

<button onclick="printRaw()">Print this page</button>

<script>
function printRaw() {
  var printWindow = window.open();
  printWindow.document.open('text/plain')
  printWindow.document.write('Aditio Agung Nugroho');
  printWindow.document.close();
  printWindow.focus();
  printWindow.print();
  printWindow.close();
}
</script>

</body>
</html>