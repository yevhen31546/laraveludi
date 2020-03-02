<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.20/datatables.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		var table = $("#ListTable").DataTable({
            "searching": true,
            "processing": true,
            "serverSide": true,
            "ajax" : {
                "url" : "getListAjax",
                "type" : "POST",
            },
            "columns": [
                {data : 'deviceId'},
                {data : 'publicDeviceRecordKey'},
                {data : 'brandName'},
                {data : 'creationDate'},
            ]
        });
	});

</script>