<?php
return [
    [
        "childrenlevel" => false,
        "name" => "Thống kê",
        "route" => "admin.dashboard",
        "permission" => "viewDashboardOrder", // Thêm quyền
        "icon" => "fa-desktop",
    ],
    [
        "childrenlevel" => true,
        "name" => "Quản lý nhân sự",
        "route" => "#",
        'children' =>
        [
            // [
            //     "name" => "Nhóm nhân viên",
            //     "route" => 'admin.user_catelogue',

            // ],
            [
                "childrenlevel" => false,
                "name" => "Quản lý nhân viên",
                "route" => 'admin.users',
                "permission" => "viewUser", // Thêm quyền
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
                "childrenlevel" => false,
                "name" => "Quản Lý chuyên mục ",
                "route" => 'admin.post-catelogue',
                "permission" => "viewPostCatelogue", // Thêm quyền
            ],
            [
                "childrenlevel" => false,
                "name" => "Quản lý bài viết",
                "route" => 'admin.post',
                "permission" => "viewPost", // Thêm quyền
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
                "childrenlevel" => false,
                "name" => "Danh mục sản phẩm",
                "route" => 'admin.product_catelogue',
                "permission" => "viewProductCatelogue", // Thêm quyền
            ],
            [
                "childrenlevel" => false,
                "name" => "Sản phẩm",
                "route" => "admin.product",
                "permission" => "viewProduct", // Thêm quyền
            ],
            [
                "childrenlevel" => false,
                "name" => "Danh mục biến thể",
                "route" => "admin.variant_catelogue",
                "permission" => "viewVariantCatelogue", // Thêm quyền
            ],
            [
                "childrenlevel" => false,
                "name" => "Thuộc tính biến thể",
                "route" => "admin.variant",
                "permission" => "viewAttributeValue", // Thêm quyền
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
                "childrenlevel" => false,
                "name" => "Phản hồi đánh giá",
                "route" => 'admin.product_comment.users',
                "permission" => "viewComment", // Thêm quyền
            ],
            [
                "childrenlevel" => false,
                "name" => "Quản lý đánh giá",
                "route" => 'admin.product_review',
                "permission" => "viewReview", // Thêm quyền
            ],
        ]

    ],
    [
        "childrenlevel" => true,
        "name" => "Thông tin thanh toán",
        "route" => "#",

        'children' =>
        [
            // [
            //     "name" => "Hình thức thanh toán",
            //     "route" => "admin.payment_methods",
            // ],
            [
                "childrenlevel" => false,
                "name" => "Mã giảm giá",
                "route" => 'admin.promotions',
                "permission" => "viewPromotion", // Thêm quyền
            ],
            [
                "childrenlevel" => false,
                "name" => "Phí vận chuyển",
                "route" => "admin.shipping_fee",
                "permission" => "viewShippingFee", // Thêm quyền
            ],
        ]
    ],


    [
        "childrenlevel" => false,
        "name" => "Quản lý đơn hàng",
        "route" => "admin.orders",
        "permission" => "viewOrder", // Thêm quyền
    ],

    [
        "childrenlevel" => true,
        "name" => "Thông tin & Hỗ trợ",
        "route" => "#",
        'children' =>
        [

            [
                "childrenlevel" => false,
                "name" => "Hỗ Trợ người dùng",
                "route" => "admin.contact",
                "permission" => "viewContact", // Thêm quyền
            ],
            [
                "childrenlevel" => false,
                "name" => " Quản lý trang liên hệ",
                "route" => "admin.information",
                "permission" => "viewInformation", // Thêm quyền
            ],
            [
                "childrenlevel" => false,
                "name" => "Quản lý trang giới thiệu",
                "route" => "admin.about",
                "permission" => "viewAboutPage", // Thêm quyền
            ],
            [
                "childrenlevel" => false,
                "name" => "Quản lý banner",
                "route" => "admin.banner",
                "permission" => "viewBanner", // Thêm quyền
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
                "childrenlevel" => false,
                "name" => " Quản lý khách hàng",
                "route" => "admin.customer",
                "permission" => "viewCustomer", // Thêm quyền
            ],
            [
                "childrenlevel" => false,
                "name" => "Quản lý nhãn hàng",
                "route" => "admin.brand",
                "permission" => "viewBrand", // Thêm quyền
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
                "childrenlevel" => false,
                "name" => " quản lý nhóm quyền",
                "route" => "admin.group_permission",
                "permission" => "viewGroupPermission", // Thêm quyền
            ],
            [
                "childrenlevel" => false,
                "name" => " quản lý quyền",
                "route" => "admin.permission",
                "permission" => "viewPermission", // Thêm quyền
            ],
            [
                "childrenlevel" => false,
                "name" => "Quản lý vai trò",
                "route" => "admin.role",
                "permission" => "viewRole", // Thêm quyền
            ],
        ]
    ],








];
//    Parent :
