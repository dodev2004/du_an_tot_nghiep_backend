@extends('backend.index')
@section('style')
@include('backend.components.head')
   
    <style>
        .form-user_create .row .col-md-6 {
            flex: 0 0 auto !important;
            margin-bottom: 4px;

        }

        .form-user_create .row .col-md-6>p {
            margin: 0;
        }

        .select2-selection {}

        .select2-selection__rendered {
            font-size: 14px !important;
            line-height: 1.42857143 !important;
            height: 34px !important;
        }

        .select2-container .select2-selection--single {
            height: 34px !important;
            padding: 6px 12px;
            color: #333;
        }

        .select2-container--default .select2-selection--single {
            border-radius: 0;
            border: 1px solid #e5e6e7;
        }

        .select2-container {
            width: 100% !important;


        }

        .select2-selection__rendered {
            padding: 0 !important;
        }
    </style>
@endsection
@section('title')
    {{ $title }}
@endsection
@section('content')
    @include('backend.components.breadcrumb')
    <div class="wrapper wrapper-content animated fadeInRight">
        @include('backend.promotion.components.formadd')
    </div>
@endsection
@push("scripts")
@include('backend.components.scripts');
<script>
    function handleDiscountTypeChange() {
    const discountType = document.getElementById('discount_type').value;
    const discountValue = document.getElementById('discount_value');
    const giaTriGiamToiDa = document.getElementById('gia_tri_giam_toi_da');

    if (discountType === 'percentage') {
        discountValue.placeholder = 'Nhập phần trăm giảm giá';
        giaTriGiamToiDa.disabled = false;
        discountValue.max = 100;
    } else {
        discountValue.placeholder = 'Nhập giá tiền';
        giaTriGiamToiDa.disabled = true;
        giaTriGiamToiDa.value = '';
        discountValue.removeAttribute('max');
    }
}

// Gọi hàm khi trang được tải để set giá trị ban đầu
document.addEventListener('DOMContentLoaded', function() {
    handleDiscountTypeChange();
});
</script>
@endpush
