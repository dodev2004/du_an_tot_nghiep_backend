@extends("backend.index")
@section("style")
@include('backend.components.head')
<link rel="stylesheet" href="{{asset("backend/css/customize.css")}}">
<style>
    .welcome-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: calc(100vh - 100px);
        background: linear-gradient(135deg, #4A90E2, #50E3C2);
        color: #fff;
        text-align: center;
        border-radius: 10px;
        padding: 40px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }
    .welcome-title {
        font-size: 3em;
        font-weight: 700;
        margin-bottom: 15px;
        text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
    }
    .welcome-message {
        font-size: 1.5em;
        line-height: 1.8;
        max-width: 600px;
        margin: 0 auto 30px;
    }
    .welcome-button {
        align-items: center; /* Căn giữa theo chiều dọc */
        background-color: #fff;
        color: #4A90E2;
        font-size: 1.2em;
        font-weight: bold;
        padding: 10px 25px 30px;
        border-radius: 30px;
        border: none;
        transition: all 0.3s;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .welcome-button:hover {
        background-color: #50E3C2;
        color: #fff;
        transform: scale(1.05);
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    }
    .welcome-animation {
        animation: fadeIn 1.5s ease-in-out;
    }
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endsection

@section("content")
<div class="wrapper-content animated fadeInRight">
    <div class="welcome-container welcome-animation">
        <div>
            <h1 class="welcome-title">Chào mừng bạn đến với trang quản trị!</h1>
            <p class="welcome-message">
                Chúng tôi rất vui khi bạn gia nhập cộng đồng của chúng tôi. Khám phá và quản lý hệ thống của bạn dễ dàng hơn bao giờ hết.
            </p>
            @if (auth()->user()->hasPermission('viewDashboardOrder'))
                <a href="{{route('admin.dashboard')}}" class="btn welcome-button">Khám Phá Ngay</a>
            @elseif (auth()->user()->hasPermission('viewUser'))
            <a href="{{route('admin.users')}}" class="btn welcome-button">Khám Phá Ngay</a>

            @elseif (auth()->user()->hasPermission('viewCustomer'))
            <a href="{{route('admin.customer')}}" class="btn welcome-button">Khám Phá Ngay</a>

            @elseif (auth()->user()->hasPermission('viewPostCatelogue'))
            <a href="{{route('admin.post-catelogue')}}" class="btn welcome-button">Khám Phá Ngay</a>

            @elseif (auth()->user()->hasPermission('viewPost'))
            <a href="{{route('admin.post')}}" class="btn welcome-button">Khám Phá Ngay</a>

            @elseif (auth()->user()->hasPermission('viewProductCatelogue'))
            <a href="{{route('admin.product_catelogue')}}" class="btn welcome-button">Khám Phá Ngay</a>

            @elseif (auth()->user()->hasPermission('viewProduct'))
            <a href="{{route('admin.product')}}" class="btn welcome-button">Khám Phá Ngay</a>

            @elseif (auth()->user()->hasPermission('viewVariantCatelogue'))
            <a href="{{route('admin.variant_catelogue')}}" class="btn welcome-button">Khám Phá Ngay</a>

            @elseif (auth()->user()->hasPermission('viewAttributeValue'))
            <a href="{{route('admin.variant')}}" class="btn welcome-button">Khám Phá Ngay</a>

            @elseif (auth()->user()->hasPermission('viewContact'))
            <a href="{{route('admin.contact')}}" class="btn welcome-button">Khám Phá Ngay</a>

            @elseif (auth()->user()->hasPermission('viewComment'))
                <a href="{{route('admin.product_comment.users')}}" class="btn welcome-button">Khám Phá Ngay</a>

            @elseif (auth()->user()->hasPermission('viewReview'))
                <a href="{{route('admin.product_review')}}" class="btn welcome-button">Khám Phá Ngay</a>

            @elseif (auth()->user()->hasPermission('viewPromotion'))
                <a href="{{route('admin.promotions')}}" class="btn welcome-button">Khám Phá Ngay</a>

            @elseif (auth()->user()->hasPermission('viewShippingFee'))
                <a href="{{route('admin.shipping_fee')}}" class="btn welcome-button">Khám Phá Ngay</a>

            @elseif (auth()->user()->hasPermission('viewOrder'))
                <a href="{{route('admin.orders')}}" class="btn welcome-button">Khám Phá Ngay</a>

            @elseif (auth()->user()->hasPermission('viewInformation'))
                <a href="{{route('admin.viewInformation')}}" class="btn welcome-button">Khám Phá Ngay</a>

            @elseif (auth()->user()->hasPermission('viewAboutPage'))
                <a href="{{route('admin.viewAboutPage')}}" class="btn welcome-button">Khám Phá Ngay</a>

            @elseif (auth()->user()->hasPermission('viewBanner'))
                <a href="{{route('admin.viewBanner')}}" class="btn welcome-button">Khám Phá Ngay</a>

            @elseif (auth()->user()->hasPermission('viewBrand'))
                <a href="{{route('admin.brand')}}" class="btn welcome-button">Khám Phá Ngay</a>

            @elseif (auth()->user()->hasPermission('viewGroupPermission'))
                <a href="{{route('admin.group_permission')}}" class="btn welcome-button">Khám Phá Ngay</a>

            @elseif (auth()->user()->hasPermission('viewPermission'))
                <a href="{{route('admin.permission')}}" class="btn welcome-button">Khám Phá Ngay</a>

            @elseif (auth()->user()->hasPermission('viewRole'))
                <a href="{{route('admin.role')}}" class="btn welcome-button">Khám Phá Ngay</a>
            @endif

        </div>
    </div>
</div>
@endsection

@push("scripts")
@include('backend.components.scripts')
@include('backend.components.toastmsg')
<script src="{{asset("backend/js/framework/delete2.js")}}"></script>
@endpush
