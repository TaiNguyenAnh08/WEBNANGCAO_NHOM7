@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng')

@section('content')
<div class="max-w-4xl mx-auto px-8 py-12">
  <!-- Header -->
  <div class="mb-8 animate-fade-in">
    <h2 class="text-4xl font-bold text-gray-800 mb-2">📋 {{ $order->order_number }}</h2>
    <p class="text-gray-600">Ngày đặt: {{ $order->created_at->format('d/m/Y H:i') }}</p>
  </div>

  <!-- Order Info -->
  <div class="bg-white rounded-xl shadow-lg p-8 mb-6 animate-fade-in" style="animation-delay: 0.1s;">
    <div class="grid grid-cols-2 gap-6 mb-6">
      <div>
        <h3 class="text-sm font-semibold text-gray-600 mb-1">👤 Khách hàng</h3>
        <p class="text-lg font-bold text-gray-800">{{ $order->user->name }}</p>
        <p class="text-gray-600">{{ $order->user->email }}</p>
      </div>
      <div>
        <h3 class="text-sm font-semibold text-gray-600 mb-1">📌 Trạng thái</h3>
        <div class="mb-3">
          @if($order->status === 'pending')
            <span class="badge badge-inactive">⏳ Chờ xử lý</span>
          @elseif($order->status === 'completed')
            <span class="badge badge-active">✓ Hoàn thành</span>
          @else
            <span class="badge" style="background: #fee2e2; color: #991b1b;">✗ Hủy</span>
          @endif
        </div>
      </div>
    </div>

    @if($order->customer_notes)
      <div class="p-4 bg-gray-50 rounded-lg border-l-4 border-blue-500">
        <h3 class="text-sm font-semibold text-gray-700 mb-1">📝 Ghi chú</h3>
        <p class="text-gray-700">{{ $order->customer_notes }}</p>
      </div>
    @endif
  </div>

  <!-- Order Items -->
  <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6 animate-fade-in" style="animation-delay: 0.2s;">
    <div class="p-6 border-b">
      <h3 class="text-lg font-bold text-gray-800">🛍️ Sản phẩm trong đơn</h3>
    </div>
    <div class="overflow-x-auto">
      <table>
        <thead>
          <tr class="border-b-2 border-gray-200 bg-gray-50">
            <th class="text-left">Sản phẩm</th>
            <th class="text-left">Kích thước</th>
            <th class="text-right">Đơn giá</th>
            <th class="text-right">Số lượng</th>
            <th class="text-right">Thành tiền</th>
          </tr>
        </thead>
        <tbody>
          @foreach($order->orderItems as $item)
            <tr>
              <td class="font-semibold text-gray-800">{{ $item->product->name }}</td>
              <td class="text-gray-600">{{ $item->size->name }}</td>
              <td class="text-right text-gray-700">{{ number_format($item->unit_price, 0, ',', '.') }}đ</td>
              <td class="text-right text-gray-700">{{ $item->quantity }}</td>
              <td class="text-right font-bold text-green-700">{{ number_format($item->subtotal, 0, ',', '.') }}đ</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <!-- Order Summary -->
  <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl shadow-lg p-8 mb-6 animate-fade-in" style="animation-delay: 0.3s;">
    <div class="flex justify-between items-center mb-6">
      <span class="text-xl font-semibold text-gray-800">Tổng cộng:</span>
      <span class="text-3xl font-bold text-green-700">{{ number_format($order->total_price, 0, ',', '.') }}đ</span>
    </div>
    
    @if($order->payment)
      <div class="p-4 bg-white rounded-lg border-2 border-green-200">
        <h3 class="text-sm font-semibold text-gray-700 mb-3">💳 Thanh toán</h3>
        <div class="grid grid-cols-2 gap-4 text-sm">
          <div>
            <p class="text-gray-600">Phương thức:</p>
            <p class="font-semibold text-gray-800">{{ $order->payment->payment_method }}</p>
          </div>
          <div>
            <p class="text-gray-600">Trạng thái:</p>
            <p class="font-semibold">
              @if($order->payment->status === 'completed')
                <span class="badge badge-active">✓ Đã thanh toán</span>
              @else
                <span class="badge badge-inactive">⏳ Chờ thanh toán</span>
              @endif
            </p>
          </div>
        </div>
      </div>
    @endif
  </div>

  <!-- Actions -->
  <div class="flex gap-4 animate-fade-in" style="animation-delay: 0.4s;">
    <a href="{{ route('orders.index') }}" class="flex-1 px-6 py-3 rounded-lg font-semibold border-2 border-gray-300 text-gray-700 hover:bg-gray-50 transition-colors text-center">
      ← Quay lại
    </a>
    
    @if(auth()->user()->isAdmin() && $order->status === 'pending')
      <form action="{{ route('orders.update', $order) }}" method="POST" class="flex-1">
        @csrf
        @method('PUT')
        <input type="hidden" name="status" value="completed">
        <button type="submit" class="w-full btn-primary text-white px-6 py-3 rounded-lg font-semibold">
          ✓ Đánh dấu hoàn thành
        </button>
      </form>
    @endif
  </div>
</div>
@endsection
