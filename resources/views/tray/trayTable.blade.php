<table class=" table table-striped table-bordered mt-3" id="trayTable">
    <thead>
    <tr>
        <th scope="col">Product Name</th>
        <th scope="col">UDI</th>
        <th scope="col">GTIN</th>
        <th scope="col">Batch</th>
        <th scope="col">Expiration Date</th>
    </tr>
    </thead>
    <tbody>
    @if(count($data_array) > 0)
        @foreach ($data_array as $list)
            <tr>
                <td>{{ $list['deviceName'] }}</td>
                <td>{{ $list['udi'] }}</td>
                <td>{{ $list['gtin'] }}</td>
                <td>{{ $list['batch'] }}</td>
                <td>{{ $list['expirydate'] }}</td>
            </tr>
        @endforeach
    @else
        <tr><td colspan="5">There is no result.</td></tr>
    @endif
    </tbody>
</table>
<div class="row">
    <div class="col-12 d-flex justify-content-center pt-2">
        {{ $skus->links() }}
    </div>
</div>

