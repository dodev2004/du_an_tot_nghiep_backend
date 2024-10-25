<div class="row">
    <div class="col-md-12">
        <!-- Thông tin khách hàng -->
        <div class="card mb-4 shadow-sm" style="border: 1px solid #ced4da;">
            <div class="row">
                <div class="col-md-12">
                    <div class="card-header" style="background-color: #7acfe9; color: white; width: 100%; height:100%">
                        <h1 class="mb-0 text-center">Thông tin khách hàng</h1>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="ibox-content mt-4">

                        <div class="card-body">
                            <h4 class="text-center">Tên đăng nhập: <strong>{{ $user->username ?? 'Chưa có thông tin' }}</strong></h4>
                            <h4 class="text-center">Tên khách hàng: <strong>{{ $user->full_name ?? 'Chưa có thông tin' }}</strong></h4>
                            <h5 class="text-center">Email: <strong>{{ $user->email ?? 'Chưa có thông tin' }}</strong></h5>
                            <h5 class="text-center">Số điện thoại: <strong>{{ $user->phone ?? 'Chưa có thông tin' }}</strong></h5>
                            <h5 class="text-center">
                                Địa chỉ: <strong>
                                    {{ $user->address ?? 'Chưa có thông tin' }},
                                    {{ $user->ward->name ?? 'Chưa có thông tin' }},
                                    {{ $user->district->name ?? 'Chưa có thông tin' }},
                                    {{ $user->province->name ?? 'Chưa có thông tin' }}
                                </strong>
                            </h5>
                            <h5 class="text-center">
                                Ngày sinh:
                                <strong>
                                    {{ $user->birthday ? \Carbon\Carbon::parse($user->birthday)->format('d/m/Y') : 'Chưa có thông tin' }}
                                </strong>
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="ibox-content mt-4">
                        <div class="text-center">
                            <img src="{{ $user->avatar ?? 'default-avatar.png' }}" alt="Avatar" class="rounded-circle" width="150" height="150">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thông tin đơn hàng -->
        <div class="ibox-content mt-4">
            <h2 class="text-center" style="color: #4682B4;">Các đơn hàng đã mua</h2>
            <h3 class="text-center" style="color: #006400;">Tổng số tiền của tất cả đơn hàng:
                <strong>{{ number_format($user->orders_sum_final_amount, 2) }} VNĐ</strong>
            </h3>

            @foreach ($user->orders as $order)
                <div class="card mb-4 shadow-sm" style="background-color: #e0f7fa;">
                    <div class="card-header" style="background-color: #7acfe9; color: white;">
                        <h3 class="mb-0">Đơn hàng #{{ $order->id }}</h3>
                    </div>
                    <div class="card-body">
                        <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                        <p><strong>Tổng số tiền:</strong> {{ number_format($order->total_amount, 2) }} VNĐ</p>
                        <p><strong>Giảm giá:</strong> {{ number_format($order->discount_amount, 2) }} VNĐ</p>
                        <p><strong>Tiền thực thu:</strong> {{ number_format($order->final_amount, 2) }} VNĐ</p>

                        <h4 class="mt-3">Chi tiết sản phẩm</h4>
                        <table class="table table-striped table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>Tên sản phẩm</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Tổng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->orderItems as $item)
                                    <tr>
                                        <td>{{ $item->product_name }}</td>
                                        <td>{{ number_format($item->price, 2) }} VNĐ</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ number_format($item->total, 2) }} VNĐ</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach

            @if ($user->orders->isEmpty())
                <div class="alert alert-info text-center">
                    <strong>Chưa có đơn hàng nào được mua.</strong>
                </div>
            @endif
        </div>
    </div>
</div>
