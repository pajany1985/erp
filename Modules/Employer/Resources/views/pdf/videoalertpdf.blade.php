<!DOCTYPE html>
<html>
<head>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</head>
<body>

<h2>List of candidate's videos will be Delete on {{$delete_date}}</h2>
<p>Notify Date: {{$current_date}}</p>
<table>
  <tr>
    <th>Candidate Name</th>
    <th>Position Name</th>
    <th>Candidate Email</th>
    <th>Candidate Status</th>
  </tr>
    @if($candidate->count()>0)
        @foreach($candidate as $key => $candid)
            <tr>
                <td>@if($candid->first_name!='') {{ucfirst($candid->first_name)}} {{ucfirst($candid->last_name)}} @endif</td>
                <td>@if(isset($candid->position) && $candid->position->name) {{ucfirst($candid->position->name)}} @endif</td>
                <td>@if($candid->email!='') {{$candid->email}} @endif</td>
                @php 
                    if($candid->status=='1' || $candid->status=='2'){
                        $status = 'Incomplete';
                        $status_color='badge-light-primary';
                    }elseif($candid->status=='3'){
                        $status = 'Complete';
                        $status_color='badge-light-success';
                    }elseif($candid->status=='4'){
                        $status = 'Hired';
                        $status_color='badge-light-success';
                    }else{
                        $status = 'Archived';
                        $status_color='badge-light-danger';
                    }
                @endphp
                <td>{{$status}}</td>
            </tr>
        @endforeach
    @endif
</table>

</body>
</html>