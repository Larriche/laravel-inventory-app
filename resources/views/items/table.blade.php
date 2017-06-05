@if(count($items))
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th style="width: 80%">Item</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
     @foreach($items as $item)
             <td>{{ $item->name }}</td>
             <td>
             <button class="btn btn-info btn-sm update-type" data-id="{{ $item->id }}"><i class="fa fa-pencil"></i></button>
             <button class="btn btn-danger btn-sm delete-type" data-id="{{ $item->id }}"><i class="fa fa-trash-o"></i></button>
             </td>
         </tr>
     @endforeach
     </tbody>
 </table>

 <div id="pagination">
    {!! 
        $items->render() 
    !!}
</div>
 @else
 <div class="well">
     <p>No items added yet</p>
 </div>
 @endif