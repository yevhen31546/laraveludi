@foreach ($data as $list) 
	<tr>
	    <td>{{ $list['di'] }}</td>
	    <td>{{ $list['deviceName'] }}</td>
	    <td>{{ $list['manufacturingDate'] }}</td>
	    <td>{{ $list['expirationDate'] }}</td>
	    <td>{{ $list['lotNumber'] }}</td>
	    <td>{{ $list['serialNumber'] }}</td>
	    <td>{{ $list['manufacturerName'] }}</td>
	    <td><?php if($list['image']){ ?><image src="{{ url('/di_image/'.$list['image']) }}" width="60" height="60" alt="NO IMAGE"/><?php } ?></td>
	    <td><?php if($list['document']){ ?><a target="_blank" href="{{ url('/di_doc/'.$list['document']) }} "><i class="zmdi zmdi-download material-icons-name"></i></a><?php } ?></td>
	</tr>
@endforeach