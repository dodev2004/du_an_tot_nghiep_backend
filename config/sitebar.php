<?php
return [
    [
        "childrenlevel" => false,
        "name" => "Dashboards",
        "route" => "admin.dashboard",
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
        "childrenlevel" => true,
        "name" => "Quản lý phương thức thanh toán",
        "route" => "#",
        'children' =>
        [


            [
                "name" => "QL phương thức thanh toán",
                "route" => "admin.payment_methods"
            ],
        ]

    ],
    [
        "childrenlevel" => true,
        "name" => "Quản lý mã giảm giá",
        "route" => "",
        'children' =>
        [

            [
                "name" => "QL mã giảm giá",
                "route" => "admin.promotions"
            ],
        ]

    ],
    [
        "childrenlevel" => true,
        "name" => "Quản lý mã trang giới thiệu",
        "route" => "#",
        'children' =>
        [

            [
                "name" => "QL trang giới thiệu",
                "route" => "admin.about"
            ],
        ]

    ],
    [
        "childrenlevel" => false,
        "name" => "Quản lí nhãn hàng",
        "route" => "admin.brand",
    ],
    [
        "childrenlevel" => false,
        "name" => "Quản lí Thông tin liên hệ",
        "route" => "admin.information",

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
    ],
    [
        "childrenlevel" => true,
        "name" => "Quản lí khách hàng",
        "route" => "#",
        'children' =>
        [

            [
                "name" => " list khách hàng",
                "route" => "admin.customer"
            ],

        ]
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







];
//    Parent :
