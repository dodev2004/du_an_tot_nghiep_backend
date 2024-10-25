<?php
return [
    [
        "childrenlevel" => true,
        "name" => "Thống kê",
        "route" => "admin.dashboard",
        "icon" => "fa-desktop",
        'children' =>
        [
            [
            "name" => "Thống kê đơn hàng",
            "route" => 'admin.dashboard_order',
            ],
            [
                "name" => "Thống kê sản phẩm",
                "route" => 'admin.dashboard_order',
            ],
            [
                            "name" => "Thống kê mã giảm giá",
                            "route" => 'admin.promotion.statistics',

            ],
        ],
       
        

    ],
    [
        "childrenlevel" => true,
        "name" => "Quản lý thành viên",
        "route" => "#",
        'children' =>
        [
            [
                "name" => "QL nhóm  thành viên",
                "route" => 'admin.user_catelogue',

            ],
            [
                "name" => "QL thành viên",
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
                "name" => "QL chuyên mục ",
                "route" => 'admin.post-catelogue',

            ],
            [
                "name" => "QL bài viết",
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
                "name" => "QL danh mục sản phẩm",
                "route" => 'admin.product_catelogue',

            ],
            [
                "name" => "QL sản phẩm",
                "route" => "admin.product"
            ],
            [
                "name" => "QL danh mục biến thể",
                "route" => "admin.variant_catelogue"
            ],
            [
                "name" => "QL biến thể",
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
                "name" => "QL bình luận",
                "route" => 'admin.product_comment.users',
            ],
            [
                "name" => "QL đánh giá",
                "route" => 'admin.product_review',
            ],
        ]

    ],
    [
        "childrenlevel" => false,
        "name" => "Quản lý phương thức thanh toán",
        "route" => "admin.payment_methods",

    ],
    [
        "childrenlevel" => false,
        "name" => "Quản lý mã giảm giá",
        "route" => "admin.promotions"

    ],


    [
        "childrenlevel" => false,
        "name" => "Quản lý trang giới thiệu",
        "route" => "admin.about",
    ],


    [
        "childrenlevel" => false,
        "name" => "Quản lí nhãn hàng",
        "route" => "admin.brand",
    ],

    [
        "childrenlevel" => false,
        "name" => "Quản lí đơn hàng",
        "route" => "admin.orders",
    ],


    [
        "childrenlevel" => false,
        "name" => "Quản lí phí ship",
        "route" => "admin.shipping_fee",
    ],
    [

        "childrenlevel" => false,
        "name" => "Quản lí form liên hệ",
        "route" => "admin.contact",

        "childrenlevel" => true,
        "name" => "Quản lí liên hệ",
        "route" => "#",
        'children' =>
        [

            [
                "name" => " QL form liên hệ",
                "route" => "admin.contact"
            ],
            [
                "name" => " QL form thông tin liên hệ",
                "route" => "admin.information"
            ],

        ]


    ],
    [
        "childrenlevel" => false,
        "name" => "Quản lí khách hàng",
        "route" => "admin.customer",
    ],
    [
        "childrenlevel" => true,
        "name" => "Quản lí quyền",
        "route" => "#",
        'children' =>
        [

            [
                "name" => " quản lí nhóm quyền",
                "route" => "admin.group_permission"
            ],
            [
                "name" => " quản lí quyền",
                "route" => "admin.permission"
            ],

        ]
    ],
    [
        "childrenlevel" => false,
        "name" => "Quản lí vai trò",
        "route" => "admin.role",
    ],







];
//    Parent :
