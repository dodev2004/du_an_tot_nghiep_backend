<table class="table table-bordered">
    <thead>
        <tr>
            <!-- <th>STT</th> -->
            <th>Tên phương thức thanh toán</th>
            <th>Mô tả phương thức thanh toán</th>
            <th class="text-center">Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($paymentMethods as $index => $item)
        <tr>
            <!-- <td>{{ $index + 1 }}</td> -->
            <td>
                <p style="margin-bottom: 0;font-weight: 600;font-size: 14px;">
                    {{ $item->name }}
                </p>
            </td>
            <td>
                <p style="margin-bottom: 0;font-weight: 600;font-size: 14px;">
                    {{ $item->description }}
                </p>
            </td>
            <td class="text-center">
                <div style="display: inline-flex; align-items: center;">
                    <a class="btn btn-sm btn-info" href="{{ route('admin.payment_methods.edit', $item->id) }}"
                        style="margin-right: 5px;">
                        <i class="fa fa-pencil"></i>
                    </a>
                    <form action="{{ route('admin.payment_methods.delete', $item->id) }}" method="POST"
                        class="d-inline delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-sm btn-warning delete-button">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
