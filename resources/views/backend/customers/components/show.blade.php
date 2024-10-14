  <div class="row">
      <div class="col-md-12">
          <h1 class="mt-4">Tên khách hàng: {{ $user->full_name }}</h1>

          <h2 class="mt-4">Các đơn hàng đã mua</h2>
          <h2>Tổng số tiền của tất cả đơn hàng: {{ $user->orders_sum_final_amount }}</h2>
          <div class="ibox-content">


              @foreach ($user->orders as $order)
                  <div class="card mb-4">
                      <div class="card-header">
                          <h3>Đơn hàng #{{ $order->id }}</h3>
                      </div>
                      <div class="card-body">
                          <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                          <p><strong>Tổng số tiền:</strong> {{ number_format($order->total_amount, 2) }} VNĐ</p>
                          <p><strong>Giảm giá:</strong> {{ number_format($order->discount_amount, 2) }} VNĐ</p>
                          <p><strong>Tiền thực thu:</strong> {{ number_format($order->final_amount, 2) }} VNĐ</p>

                          <h4 class="mt-3">Chi tiết sản phẩm</h4>
                          <table class="table table-bordered">
                              <thead>
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
                  <div class="alert alert-info">
                      <strong>Chưa có đơn hàng nào được mua.</strong>
                  </div>
              @endif

          </div>
      </div>

  </div>
