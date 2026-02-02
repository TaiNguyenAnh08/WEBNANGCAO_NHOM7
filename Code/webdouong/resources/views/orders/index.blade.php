@extends('layouts.app')

@section('title', 'Đơn hàng')

@section('content')
<div class="max-w-7xl mx-auto px-8 py-12">
  <!-- Header -->
  <div class="mb-8 animate-fade-in">
    <h2 class="text-4xl font-bold text-gray-800 mb-2">🛒 Đơn hàng</h2>
    <p class="text-gray-600">
      @if(auth()->user()->isAdmin())
        Quản lý tất cả đơn hàng từ khách hàng
      @else
        Xem lịch sử đơn hàng của bạn
      @endif
    </p>
  </div>

  <!-- Orders Table -->
  <div class="bg-white rounded-xl shadow-lg overflow-hidden animate-fade-in" style="animation-delay: 0.1s;">
    @if($orders->count() > 0)
      <div class="overflow-x-auto">
        <table>
          <thead>
            <tr class="border-b-2 border-gray-200">
              <th class="text-left">Mã đơn</th>
              <th class="text-left">Khách hàng</th>
              <th class="text-left">Ngày</th>
              <th class="text-right">Tổng tiền</th>
              <th class="text-center">Trạng thái</th>
              <th class="text-center">Thao tác</th>
            </tr>
          </thead>
          <tbody>
            @foreach($orders as $order)
              <tr>
                <td class="font-semibold text-gray-800">{{ $order->order_number }}</td>
                <td class="text-gray-700">{{ $order->user->name }}</td>
                <td class="text-gray-600">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                <td class="text-right font-bold text-green-700">{{ number_format($order->total_price, 0, ',', '.') }}đ</td>
                <td class="text-center">
                  @if($order->status === 'pending')
                    <span class="badge badge-inactive">⏳ Chờ xử lý</span>
                  @elseif($order->status === 'completed')
                    <span class="badge badge-active">✓ Hoàn thành</span>
                  @else
                    <span class="badge" style="background: #fee2e2; color: #991b1b;">✗ Hủy</span>
                  @endif
                </td>
                <td class="text-center">
                  <div class="flex gap-2 justify-center">
                    <a href="{{ route('orders.show', $order) }}" class="p-2 hover:bg-blue-100 rounded-full transition-colors" title="Xem chi tiết">
                      <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                      </svg>
                    </a>
                    @if(auth()->user()->isAdmin() && $order->status === 'pending')
                      <form action="{{ route('orders.update', $order) }}" method="POST" class="inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="completed">
                        <button type="submit" class="p-2 hover:bg-green-100 rounded-full transition-colors" title="Đánh dấu hoàn thành">
                          <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                          </svg>
                        </button>
                      </form>
                    @endif
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="p-6 border-t">
        {{ $orders->links() }}
      </div>
    @else
      <div class="p-12 text-center">
        <div class="text-6xl mb-4">📭</div>
        <p class="text-gray-500 text-lg">
          @if(auth()->user()->isAdmin())
            Chưa có đơn hàng nào
          @else
            Bạn chưa có đơn hàng nào
          @endif
        </p>
      </div>
    @endif
  </div>
</div>
@endsection
