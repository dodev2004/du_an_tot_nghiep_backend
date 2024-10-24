@extends('backend.index')
@section("style")
@include('backend.components.head')
@include('backend.components.chartCss')
@endsection
@section("title")
@endsection
@section("content")
<div class="row  border-bottom white-bg dashboard-header">
    <div class="col-md-3">
        <h2>Welcome Amelia</h2>
        <small>You have 42 messages and 6 notifications.</small>
        <ul class="list-group clear-list m-t">
            <li class="list-group-item fist-item">
                <span class="pull-right">
                    09:00 pm
                </span>
                <span class="label label-success">1</span> Please contact me
            </li>
            <li class="list-group-item">
                <span class="pull-right">
                    10:16 am
                </span>
                <span class="label label-info">2</span> Sign a contract
            </li>
            <li class="list-group-item">
                <span class="pull-right">
                    08:22 pm
                </span>
                <span class="label label-primary">3</span> Open new shop
            </li>
            <li class="list-group-item">
                <span class="pull-right">
                    11:06 pm
                </span>
                <span class="label label-default">4</span> Call back to Sylvia
            </li>
            <li class="list-group-item">
                <span class="pull-right">
                    12:00 am
                </span>
                <span class="label label-primary">5</span> Write a letter to Sandra
            </li>
        </ul>
    </div>
    <div class="col-md-6">
        <div class="flot-chart dashboard-chart">
            <div class="flot-chart-content" id="flot-dashboard-chart"></div>
        </div>
        <div class="row text-left">
            <div class="col-xs-4">
                <div class=" m-l-md">
                <span class="h4 font-bold m-t block">$ 406,100</span>
                <small class="text-muted m-b block">Sales marketing report</small>
                </div>
            </div>
            <div class="col-xs-4">
                <span class="h4 font-bold m-t block">$ 150,401</span>
                <small class="text-muted m-b block">Annual sales revenue</small>
            </div>
            <div class="col-xs-4">
                <span class="h4 font-bold m-t block">$ 16,822</span>
                <small class="text-muted m-b block">Half-year revenue margin</small>
            </div>

        </div>
    </div>
    <div class="col-md-3">
        <div class="statistic-box">
        <h4>
            Project Beta prog   s
        </h4>
        <p>
            You have two project with not compleated task.
        </p>
            <div class="row text-center">
                <div class="col-lg-6">
                    <canvas id="doughnutChart2" width="80" height="80" style="margin: 18px auto 0"></canvas>
                    <h5 >Kolter</h5>
                </div>
                <div class="col-lg-6">
                    <canvas id="doughnutChart" width="80" height="80" style="margin: 18px auto 0"></canvas>
                    <h5 >Maxtor</h5>
                </div>
            </div>
            <div class="m-t">
                <small>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</small>
            </div>

        </div>
    </div>

</div>
<div class="row">
    <div class="col-lg-12">
        <div class="wrapper wrapper-content">
            <div class="row">
                <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>New data for the report</h5> <span class="label label-primary">IN+</span>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="fa fa-wrench"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-user">
                                    <li><a href="#">Config option 1</a>
                                    </li>
                                    <li><a href="#">Config option 2</a>
                                    </li>
                                </ul>
                                <a class="close-link">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div>

                                <div class="pull-right text-right">

                                    <span class="bar_dashboard">5,3,9,6,5,9,7,3,5,2,4,7,3,2,7,9,6,4,5,7,3,2,1,0,9,5,6,8,3,2,1</span>
                                    <br/>
                                    <small class="font-bold">$ 20 054.43</small>
                                </div>
                                <h4>NYS report new data!
                                    <br/>
                                    <small class="m-r"><a href="graph_flot.html"> Check the stock price! </a> </small>
                                </h4>
                                </div>
                            </div>
                        </div>
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Read below comments</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="fa fa-wrench"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-user">
                                    <li><a href="#">Config option 1</a>
                                    </li>
                                    <li><a href="#">Config option 2</a>
                                    </li>
                                </ul>
                                <a class="close-link">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content no-padding">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <p><a class="text-info" href="#">@Alan Marry</a> I belive that. Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                    <small class="block text-muted"><i class="fa fa-clock-o"></i> 1 minuts ago</small>
                                </li>
                                <li class="list-group-item">
                                    <p><a class="text-info" href="#">@Stock Man</a> Check this stock chart. This price is crazy! </p>
                                    <div class="text-center m">
                                        <span id="sparkline8"></span>
                                    </div>
                                    <small class="block text-muted"><i class="fa fa-clock-o"></i> 2 hours ago</small>
                                </li>
                                <li class="list-group-item">
                                    <p><a class="text-info" href="#">@Kevin Smith</a> Lorem ipsum unknown printer took a galley </p>
                                    <small class="block text-muted"><i class="fa fa-clock-o"></i> 2 minuts ago</small>
                                </li>
                                <li class="list-group-item ">
                                    <p><a class="text-info" href="#">@Jonathan Febrick</a> The standard chunk of Lorem Ipsum</p>
                                    <small class="block text-muted"><i class="fa fa-clock-o"></i> 1 hour ago</small>
                                </li>
                                <li class="list-group-item">
                                    <p><a class="text-info" href="#">@Alan Marry</a> I belive that. Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                    <small class="block text-muted"><i class="fa fa-clock-o"></i> 1 minuts ago</small>
                                </li>
                                <li class="list-group-item">
                                    <p><a class="text-info" href="#">@Kevin Smith</a> Lorem ipsum unknown printer took a galley </p>
                                    <small class="block text-muted"><i class="fa fa-clock-o"></i> 2 minuts ago</small>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <!-- đánh gía & bình luận -->
                            <div class="ibox-tools">
                                <div style="width: 65%; margin-left: 20%;">
                                    <canvas id="reviewRatingsDoughnutChart" ></canvas>
                                </div>
                            </div>
                            <div class="ibox-tools" style="margin-top: 70px;">
                                <div">
                                    <canvas id="topRatedProductsChart" width="1200" height="400"></canvas>
                                </div>
                                <div style="margin-top: 70px;">
                                    <canvas id="mostCommentedProductsChart" width="1200" height="400"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include("backend.components.footer")
        </div>
    </div>
</div>
<div class="small-chat-box fadeInRight animated">

    <div class="heading" draggable="true">
        <small class="chat-date pull-right">
            02.19.2015
        </small>
        Small chat
    </div>

    <div class="content">

        <div class="left">
            <div class="author-name">
                Monica Jackson <small class="chat-date">
                10:02 am
            </small>
            </div>
            <div class="chat-message active">
                Lorem Ipsum is simply dummy text input.
            </div>

        </div>
        <div class="right">
            <div class="author-name">
                Mick Smith
                <small class="chat-date">
                    11:24 am
                </small>
            </div>
            <div class="chat-message">
                Lorem Ipsum is simpl.
            </div>
        </div>
        <div class="left">
            <div class="author-name">
                Alice Novak
                <small class="chat-date">
                    08:45 pm
                </small>
            </div>
            <div class="chat-message active">
                Check this stock char.
            </div>
        </div>
        <div class="right">
            <div class="author-name">
                Anna Lamson
                <small class="chat-date">
                    11:24 am
                </small>
            </div>
            <div class="chat-message">
                The standard chunk of Lorem Ipsum
            </div>
        </div>
        <div class="left">
            <div class="author-name">
                Mick Lane
                <small class="chat-date">
                    08:45 pm
                </small>
            </div>
            <div class="chat-message active">
                I belive that. Lorem Ipsum is simply dummy text.
            </div>
        </div>


    </div>
    <div class="form-chat">
        <div class="input-group input-group-sm">
            <input type="text" class="form-control">
            <span class="input-group-btn"> <button
                class="btn btn-primary" type="button">Send
        </button> </span></div>
    </div>

</div>
<div id="small-chat">

    <span class="badge badge-warning pull-right">5</span>
    <a class="open-small-chat">
        <i class="fa fa-comments"></i>

    </a>
</div>
<div id="right-sidebar" class="animated">
    <div class="sidebar-container">

        <ul class="nav nav-tabs navs-3">

            <li class="active"><a data-toggle="tab" href="#tab-1">
                Notes
            </a></li>
            <li><a data-toggle="tab" href="#tab-2">
                Projects
            </a></li>
            <li class=""><a data-toggle="tab" href="#tab-3">
                <i class="fa fa-gear"></i>
            </a></li>
        </ul>

        <div class="tab-content">


            <div id="tab-1" class="tab-pane active">

                <div class="sidebar-title">
                    <h3> <i class="fa fa-comments-o"></i> Latest Notes</h3>
                    <small><i class="fa fa-tim"></i> You have 10 new message.</small>
                </div>

                <div>

                    <div class="sidebar-message">
                        <a href="#">
                            <div class="pull-left text-center">
                                <img alt="image" class="img-circle message-avatar" src="backend/img/a1.jpg">

                                <div class="m-t-xs">
                                    <i class="fa fa-star text-warning"></i>
                                    <i class="fa fa-star text-warning"></i>
                                </div>
                            </div>
                            <div class="media-body">

                                There are many variations of passages of Lorem Ipsum available.
                                <br>
                                <small class="text-muted">Today 4:21 pm</small>
                            </div>
                        </a>
                    </div>
                    <div class="sidebar-message">
                        <a href="#">
                            <div class="pull-left text-center">
                                <img alt="image" class="img-circle message-avatar" src="backend/img/a2.jpg">
                            </div>
                            <div class="media-body">
                                The point of using Lorem Ipsum is that it has a more-or-less normal.
                                <br>
                                <small class="text-muted">Yesterday 2:45 pm</small>
                            </div>
                        </a>
                    </div>
                    <div class="sidebar-message">
                        <a href="#">
                            <div class="pull-left text-center">
                                <img alt="image" class="img-circle message-avatar" src="backend/img/a3.jpg">

                                <div class="m-t-xs">
                                    <i class="fa fa-star text-warning"></i>
                                    <i class="fa fa-star text-warning"></i>
                                    <i class="fa fa-star text-warning"></i>
                                </div>
                            </div>
                            <div class="media-body">
                                Mevolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
                                <br>
                                <small class="text-muted">Yesterday 1:10 pm</small>
                            </div>
                        </a>
                    </div>
                    <div class="sidebar-message">
                        <a href="#">
                            <div class="pull-left text-center">
                                <img alt="image" class="img-circle message-avatar" src="backend/img/a4.jpg">
                            </div>

                            <div class="media-body">
                                Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the
                                <br>
                                <small class="text-muted">Monday 8:37 pm</small>
                            </div>
                        </a>
                    </div>
                    <div class="sidebar-message">
                        <a href="#">
                            <div class="pull-left text-center">
                                <img alt="image" class="img-circle message-avatar" src="backend/img/a8.jpg">
                            </div>
                            <div class="media-body">

                                All the Lorem Ipsum generators on the Internet tend to repeat.
                                <br>
                                <small class="text-muted">Today 4:21 pm</small>
                            </div>
                        </a>
                    </div>
                    <div class="sidebar-message">
                        <a href="#">
                            <div class="pull-left text-center">
                                <img alt="image" class="img-circle message-avatar" src="backend/img/a7.jpg">
                            </div>
                            <div class="media-body">
                                Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.
                                <br>
                                <small class="text-muted">Yesterday 2:45 pm</small>
                            </div>
                        </a>
                    </div>
                    <div class="sidebar-message">
                        <a href="#">
                            <div class="pull-left text-center">
                                <img alt="image" class="img-circle message-avatar" src="backend/img/a3.jpg">

                                <div class="m-t-xs">
                                    <i class="fa fa-star text-warning"></i>
                                    <i class="fa fa-star text-warning"></i>
                                    <i class="fa fa-star text-warning"></i>
                                </div>
                            </div>
                            <div class="media-body">
                                The standard chunk of Lorem Ipsum used since the 1500s is reproduced below.
                                <br>
                                <small class="text-muted">Yesterday 1:10 pm</small>
                            </div>
                        </a>
                    </div>
                    <div class="sidebar-message">
                        <a href="#">
                            <div class="pull-left text-center">
                                <img alt="image" class="img-circle message-avatar" src="backend/img/a4.jpg">
                            </div>
                            <div class="media-body">
                                Uncover many web sites still in their infancy. Various versions have.
                                <br>
                                <small class="text-muted">Monday 8:37 pm</small>
                            </div>
                        </a>
                    </div>
                </div>

            </div>

            <div id="tab-2" class="tab-pane">

                <div class="sidebar-title">
                    <h3> <i class="fa fa-cube"></i> Latest projects</h3>
                    <small><i class="fa fa-tim"></i> You have 14 projects. 10 not completed.</small>
                </div>

                <ul class="sidebar-list">
                    <li>
                        <a href="#">
                            <div class="small pull-right m-t-xs">9 hours ago</div>
                            <h4>Business valuation</h4>
                            It is a long established fact that a reader will be distracted.

                            <div class="small">Completion with: 22%</div>
                            <div class="progress progress-mini">
                                <div style="width: 22%;" class="progress-bar progress-bar-warning"></div>
                            </div>
                            <div class="small text-muted m-t-xs">Project end: 4:00 pm - 12.06.2014</div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="small pull-right m-t-xs">9 hours ago</div>
                            <h4>Contract with Company </h4>
                            Many desktop publishing packages and web page editors.

                            <div class="small">Completion with: 48%</div>
                            <div class="progress progress-mini">
                                <div style="width: 48%;" class="progress-bar"></div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="small pull-right m-t-xs">9 hours ago</div>
                            <h4>Meeting</h4>
                            By the readable content of a page when looking at its layout.

                            <div class="small">Completion with: 14%</div>
                            <div class="progress progress-mini">
                                <div style="width: 14%;" class="progress-bar progress-bar-info"></div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span class="label label-primary pull-right">NEW</span>
                            <h4>The generated</h4>
                            There are many variations of passages of Lorem Ipsum available.
                            <div class="small">Completion with: 22%</div>
                            <div class="small text-muted m-t-xs">Project end: 4:00 pm - 12.06.2014</div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="small pull-right m-t-xs">9 hours ago</div>
                            <h4>Business valuation</h4>
                            It is a long established fact that a reader will be distracted.

                            <div class="small">Completion with: 22%</div>
                            <div class="progress progress-mini">
                                <div style="width: 22%;" class="progress-bar progress-bar-warning"></div>
                            </div>
                            <div class="small text-muted m-t-xs">Project end: 4:00 pm - 12.06.2014</div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="small pull-right m-t-xs">9 hours ago</div>
                            <h4>Contract with Company </h4>
                            Many desktop publishing packages and web page editors.

                            <div class="small">Completion with: 48%</div>
                            <div class="progress progress-mini">
                                <div style="width: 48%;" class="progress-bar"></div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="small pull-right m-t-xs">9 hours ago</div>
                            <h4>Meeting</h4>
                            By the readable content of a page when looking at its layout.

                            <div class="small">Completion with: 14%</div>
                            <div class="progress progress-mini">
                                <div style="width: 14%;" class="progress-bar progress-bar-info"></div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span class="label label-primary pull-right">NEW</span>
                            <h4>The generated</h4>
                            <!--<div class="small pull-right m-t-xs">9 hours ago</div>-->
                            There are many variations of passages of Lorem Ipsum available.
                            <div class="small">Completion with: 22%</div>
                            <div class="small text-muted m-t-xs">Project end: 4:00 pm - 12.06.2014</div>
                        </a>
                    </li>

                </ul>

            </div>

            <div id="tab-3" class="tab-pane">

                <div class="sidebar-title">
                    <h3><i class="fa fa-gears"></i> Settings</h3>
                    <small><i class="fa fa-tim"></i> You have 14 projects. 10 not completed.</small>
                </div>

                <div class="setings-item">
            <span>
                Show notifications
            </span>
                    <div class="switch">
                        <div class="onoffswitch">
                            <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="example">
                            <label class="onoffswitch-label" for="example">
                                <span class="onoffswitch-inner"></span>
                                <span class="onoffswitch-switch"></span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="setings-item">
            <span>
                Disable Chat
            </span>
                    <div class="switch">
                        <div class="onoffswitch">
                            <input type="checkbox" name="collapsemenu" checked class="onoffswitch-checkbox" id="example2">
                            <label class="onoffswitch-label" for="example2">
                                <span class="onoffswitch-inner"></span>
                                <span class="onoffswitch-switch"></span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="setings-item">
            <span>
                Enable history
            </span>
                    <div class="switch">
                        <div class="onoffswitch">
                            <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="example3">
                            <label class="onoffswitch-label" for="example3">
                                <span class="onoffswitch-inner"></span>
                                <span class="onoffswitch-switch"></span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="setings-item">
            <span>
                Show charts
            </span>
                    <div class="switch">
                        <div class="onoffswitch">
                            <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="example4">
                            <label class="onoffswitch-label" for="example4">
                                <span class="onoffswitch-inner"></span>
                                <span class="onoffswitch-switch"></span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="setings-item">
            <span>
                Offline users
            </span>
                    <div class="switch">
                        <div class="onoffswitch">
                            <input type="checkbox" checked name="collapsemenu" class="onoffswitch-checkbox" id="example5">
                            <label class="onoffswitch-label" for="example5">
                                <span class="onoffswitch-inner"></span>
                                <span class="onoffswitch-switch"></span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="setings-item">
            <span>
                Global search
            </span>
                    <div class="switch">
                        <div class="onoffswitch">
                            <input type="checkbox" checked name="collapsemenu" class="onoffswitch-checkbox" id="example6">
                            <label class="onoffswitch-label" for="example6">
                                <span class="onoffswitch-inner"></span>
                                <span class="onoffswitch-switch"></span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="setings-item">
            <span>
                Update everyday
            </span>
                    <div class="switch">
                        <div class="onoffswitch">
                            <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="example7">
                            <label class="onoffswitch-label" for="example7">
                                <span class="onoffswitch-inner"></span>
                                <span class="onoffswitch-switch"></span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="sidebar-content">
                    <h4>Settings</h4>
                    <div class="small">
                        I belive that. Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                        And typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
                        Over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
                    </div>
                </div>

            </div>
        </div>

    </div>



</div>
    <!-- Thêm Chart.js và jQuery để vẽ biểu đồ -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- biểu đồ tròn đánh giá sao -->
<script>
    var ratingLabels = {!! json_encode($ratingLabels) !!}; // 1, 2, 3, 4, 5 sao
    var ratingCounts = {!! json_encode($ratingCounts) !!}; // Số lượng đánh giá theo từng mốc sao

    var ctx = document.getElementById('reviewRatingsDoughnutChart').getContext('2d');
    var reviewRatingsDoughnutChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['1 sao', '2 sao', '3 sao', '4 sao', '5 sao'],
            datasets: [{
                label: 'Lượt đánh giá',
                data: ratingCounts,
                backgroundColor: [  
                    'rgba(0, 204, 204, 0.8)',  
                    'rgba(0, 204, 153, 0.8)',   
                    'rgba(51, 153, 153, 0.8)',  
                    'rgba(51, 204, 0, 0.8)',    
                    'rgba(51, 153, 255, 0.8)'  
                ],  
                borderColor: [  
                    'rgba(0, 204, 204, 1)',  
                    'rgba(0, 204, 153, 1)', 
                    'rgba(51, 153, 153, 1)',  
                    'rgba(51, 204, 0, 1)',   
                    'rgba(51, 153, 255, 1)' 
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Tỷ lệ đánh giá theo sao'
                }
            }
        }
    });
</script>

<!-- Top 10 Sản phẩm có đánh giá trung bình sao cao nhất -->
<script>
    var productNames = {!! json_encode($topRatedProducts->pluck('product.name')) !!}; // Lấy tên sản phẩm
    var averageRatings = {!! json_encode($topRatedProducts->pluck('average_rating')) !!}; // Lấy đánh giá trung bình

    var ctx = document.getElementById('topRatedProductsChart').getContext('2d');
    var topRatedProductsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: productNames,
            datasets: [{
                label: 'Đánh giá trung bình bình luận có nhiều sao nhất',
                data: averageRatings,
                backgroundColor: 'rgba(255, 159, 64, 1)',
                borderColor: 'rgba(255, 159, 64, 1)',
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y',
            scales: {
                x: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Top 10 Sản phẩm có đánh giá trung bình sao cao nhất'
                }
            }
        }
    });
</script>

<!-- Top 10 Sản phẩm được bình luận nhiều nhất -->
<script>
    var productNames = {!! json_encode($mostCommentedProducts->pluck('product.name')) !!}; 
    var commentCounts = {!! json_encode($mostCommentedProducts->pluck('comment_count')) !!};

    var ctx = document.getElementById('mostCommentedProductsChart').getContext('2d');
    var mostCommentedProductsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: productNames,
            datasets: [{
                label: 'Số lượng bình luận',
                data: commentCounts,
                backgroundColor: 'rgba(75, 192, 192, 1)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y',
            scales: {
                x: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Top 10 Sản phẩm được bình luận nhiều nhất'
                }
            }
        }
    });
</script>

@endsection
@push('scripts')
    @include('backend.components.scripts')
    @include("backend.components.chartJs")
@endpush