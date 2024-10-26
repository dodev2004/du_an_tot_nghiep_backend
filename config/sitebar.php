<?php
return [
    [
        "childrenlevel" => true,
        "name" => "Thống kê",
        "route" => "#",
        "icon" => "fa-desktop",
        'children' =>
        [
            [
                "name" => "Thống kê đơn hàng",
                "route" => 'admin.dashboard_order',
            ],
            [
                "name" => "Thống kê sản phẩm",
                "route" => 'admin.dashboard',
            ],
            [
                "name" => "Thống kê mã giảm giá",
                "route" => 'admin.promotion.statistics',

            ],
        ],

    ],
    [
        "childrenlevel" => true,
        "name" => "Quản lý nhân sự",
        "route" => "#",
        'children' =>
        [
            [
                "name" => "Nhóm nhân viên",
                "route" => 'admin.user_catelogue',

            ],
            [
                "name" => "Quản lý nhân viên",
                "route" => 'admin.users',

            ],
        ]
    ],
    [
        "childrenlevel" => true,
        "name" => "Quản lý bài viết",
        "route" => "#",
        'children' =>
        [
            [
                "name" => "Quản Lý chuyên mục ",
                "route" => 'admin.post-catelogue',

            ],
            [
                "name" => "Quản lý bài viết",
                "route" => 'admin.post',

            ],
        ]
    ],
    [
        "childrenlevel" => true,
        "name" => "Quản lý sản phẩm",
        "route" => "#",
        'children' =>
        [
            [
                "name" => "Danh mục sản phẩm",
                "route" => 'admin.product_catelogue',

            ],
            [
                "name" => "Sản phẩm",
                "route" => "admin.product"
            ],
            [
                "name" => "Danh mục biến thể",
                "route" => "admin.variant_catelogue"
            ],
            [
                "name" => "Thuộc tính biến thể",
                "route" => "admin.variant"
            ],
        ]

    ],
    [
        "childrenlevel" => true,
        "name" => "Quản lý phản hồi",
        "route" => "#",
        'children' =>
        [
            [
                "name" => "Quản lý bình luận",
                "route" => 'admin.product_comment.users',
            ],
            [
                "name" => "Quản Lý đánh giá",
                "route" => 'admin.product_review',
            ],
        ]

    ],
    [
        "childrenlevel" => true,
        "name" => "Thông tin thanh toán",
        "route" => "#",

        'children' =>
        [
            [
                "name" => "Hình thức thanh toán",
                "route" => "admin.payment_methods",
            ],
            [
                "name" => "Mã giảm giá",
                "route" => 'admin.promotions',
            ],
            [
                "name" => "Phí vận chuyển",
                "route" => "admin.shipping_fee",
            ],
        ]
    ],


    [
        "childrenlevel" => false,
        "name" => "Quản lý đơn hàng",
        "route" => "admin.orders",
    ],

    [
        "childrenlevel" => true,
        "name" => "Thông tin & Hỗ trợ",
        "route" => "#",
        'children' =>
        [

            [
                "name" => "Hỗ Trợ người dùng",
                "route" => "admin.contact"
            ],
            [
                "name" => " Quản lỷ trang liên hệ",
                "route" => "admin.information"
            ],
            [
                "name" => "Quản lý trang giới thiệu",
                "route" => "admin.about",
            ],
        ]

    ],
    [
        "childrenlevel" => true,
        "name" => "Thông tin khách hàng",
        "route" => "#",
        'children' =>
        [

            [
                "name" => " Quản lý khách hàng",
                "route" => "admin.customer"
            ],
            [
                "childrenlevel" => false,
                "name" => "Quản lý nhãn hàng",
                "route" => "admin.brand",
            ],

        ]
    ],
    [
        "childrenlevel" => true,
        "name" => "Quản lý phân quyền",
        "route" => "#",
        'children' =>
        [

            [
                "name" => " quản lý nhóm quyền",
                "route" => "admin.group_permission"
            ],
            [
                "name" => " quản lý quyền",
                "route" => "admin.permission"
            ],
            [
                "name" => "Quản lý vai trò",
                "route" => "admin.role",
            ],
        ]
    ],








];
//    Parent :
