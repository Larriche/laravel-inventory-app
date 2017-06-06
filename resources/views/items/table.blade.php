@if(count($items))
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th style="width: 8%"></th>
            <th>Serial Number</th>
            <th style="width: 20%">Item</th>
            <th>Color</th>
            <th>Type</th>
            <th>Vendor</th>
            <th>Price</th>
            <th style="width: 12%">Actions</th>
        </tr>
    </thead>

    <tbody>
     @foreach($items as $item)
             <td><img src="{{ $item->image_url }}" class="img img-responsive item-image"></td>
             <td>{{ $item->serial_number }}</td>
             <td>{{ $item->name }}</td>
             <td>{{ $item->color }}</td>
             <td>{{ $item->type->name }}</td>
             <td>{{ $item->vendor->name }}</td>
             <td>${{ $item->price }}</td>
             <td>
             <button class="btn btn-info btn-sm update-item" data-id="{{ $item->id }}"><i class="fa fa-pencil"></i></button>
             <button class="btn btn-danger btn-sm delete-item" data-id="{{ $item->id }}"><i class="fa fa-trash-o"></i></button>
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