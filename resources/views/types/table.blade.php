@if(count($types))
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th style="width: 80%">Type</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
     @foreach($types as $type)
             <td>{{ $type->name }}</td>
             <td>
             <button class="btn btn-info btn-sm update-type" data-id="{{ $type->id }}"><i class="fa fa-pencil"></i></button>
             <button class="btn btn-danger btn-sm delete-type" data-id="{{ $type->id }}"><i class="fa fa-trash-o"></i></button>
             </td>
         </tr>
     @endforeach
     </tbody>
 </table>

 <div id="pagination">
    {!! 
        $types->render() 
    !!}
</div>
 @else
 <div class="well">
     <p>No item types added yet</p>
 </div>
 @endif