<table id="customers">
    <tr>
        <th>employee name</th>
        <th>total quatity</th>
        <th>product name</th>
        <th>quantity</th>
        <th>price</th>
    </tr>
    @foreach ($data as $value)
        @if ($value->products->count())
            <tr>
                <td rowspan="{{ $value->products->count() }}">{{ $value->name }}
                </td>
                <td rowspan="{{ $value->products->count()  }}">
                    {{ $value->products->sum('pivot.quantity') }}</td>
                    <td rowspan="{{ $value->products->count()  }}">
                        {{ $value->products->count() }}</td>
    


                @foreach ($value->products as $key => $value2)
                    <td>{{ $value2->name }}</td>
                    <td>{{ $value2->pivot->quantity }}</td>
                    <td>{{ $value2->prize }}</td>
                    @if ($value->products->count()-1 > $key)
                                    </tr>
            <tr>
                    @endif

        @endforeach
        </tr>
    @endif
    @endforeach



</table>




{{-- <table id="customers">
    <tr>
        <th>employee name</th>
        <th>total quatity</th>
        <th>product name</th>
        <th>quantity</th>
        <th>price</th>
    </tr>
    @foreach ($data->unique('employee_id') as $item)
        <tr>
            <td rowspan="{{ $data->where('employee_id', $item->employee_id)->count() + 1 }}">{{ $item->employee->name }}
            </td>
            <td rowspan="{{ $data->where('employee_id', $item->employee_id)->count() + 1 }}">
                {{ $data->where('employee_id', $item->employee_id)->sum('quantity') }}</td>

        </tr>

        @foreach ($data->where('employee_id', $item->employee_id) as $item2)
            <tr>
                <td>{{ $item2->product->name }}</td>
                <td>{{ $item2->quantity }}</td>
                <td>{{ $item2->product->prize }}</td>
            </tr>
        @endforeach
    @endforeach



</table> --}}
