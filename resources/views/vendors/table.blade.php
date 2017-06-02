@if(count($vendors))
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th style="width: 10%"></th>
            <th style="width: 80%">Vendor</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
     @foreach($vendors as $vendor)
             <td><img src="{{ $vendor->logo_url }}" class="vendor-logo img img-responsive"></td></td>
             <td>{{ $vendor->name }}</td>
             <td>
             <button class="btn btn-info btn-sm update-vendor" data-id="{{ $vendor->id }}"><i class="fa fa-pencil"></i></button>
             <button class="btn btn-danger btn-sm delete-vendor" data-id="{{ $vendor->id }}"><i class="fa fa-trash-o"></i></button>
             </td>
         </tr>
     @endforeach
     </tbody>
 </table>

 <div id="pagination">
    {!! 
        $vendors->render() 
    !!}
</div>
 @else
 <div class="well">
     <p>No vendors added yet</p>
 </div>
 @endif