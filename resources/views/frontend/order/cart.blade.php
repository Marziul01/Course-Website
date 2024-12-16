@extends('frontend.master')

@section('title')
    | Cart
@endsection


@section('content')

<div class="section py-5">
    <h2>আপনার কার্ট</h2>
    @if(isset($comboApplied) && $comboApplied)
        <div class="alert alert-success">
            {{ $comboMessage }}
        </div>
    @endif
    @if($cartItems->isEmpty())
        <p>আপনার কার্ট খালি.</p>
    @else
    <div class="d-flex flex-column justify-content-end align-items-end w-100">
        <div class="card card-body w-100">
            <table class="table">
                <thead>
                    <tr>
                        <th>কোর্স</th>
                        <th>বিভাগ</th>
                        <th>মূল্য</th>
                        <th>মুছে ফেলুন</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                        <tr>
                            <td>{{ $item->course->title }}</td>
                            <td>{{ $item->course->category->name ?? 'Combo package' }}</td>
                            <td class="convert-number">৳{{ $item->course->sale_price ?? $item->course->price }}</td>
                            <td>
                                <button class="btn btn-danger btn-sm remove-from-cart" data-id="{{ $item->id }}">Remove</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card card-body w-25 mt-3 cartpagetotal">
            <div class="text-right">
                <h4 class="convert-number">মোট: ৳{{ $total }}</h4>
            </div>

            <!-- Checkout Button -->
            <div class="mt-4">
                <a href="{{ route('checkout') }}" class="btn registerbtn">চেকআউটে এগিয়ে যান</a>
            </div>
        </div>
    </div>

    @endif
</div>


@endsection


@section('customJs')

<script>
    // Handle remove from cart
    $('.remove-from-cart').click(function() {
        var id = $(this).data('id');
        $.ajax({
            url: '{{ route("cart.remove") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: id,
            },
            success: function(response) {
                toastr.success(response.message);
                location.reload();
            }
        });
    });
</script>


@endsection
