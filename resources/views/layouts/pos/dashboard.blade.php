<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>{{ ENV('APP_NAME')}}</title>
<!-- Tell the browser to be responsive to screen width -->
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Favicon -->
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/favicon-16x16.png') }}">

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

<!-- v4.0.0 -->
<link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">

<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/fontawesome/css/all.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/et-line-font/et-line-font.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/themify-icons/themify-icons.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/simple-lineicon/simple-line-icons.css') }}">

<!-- jQuery 3 --> 
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
 
<script src="{{ asset('assets/plugins/popper/popper.min.js') }}"></script>

<!-- v4.0.0-alpha.6 -->
<script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- template --> 
<script src="{{ asset('assets/js/adminkit.js') }}"></script>

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

</head>
<body class="sidebar-mini sidebar-collapse">
<div class="wrapper boxed-wrapper">
  <header class="main-header"> 
    <!-- Logo --> 
    <a href="index.html" class="logo blue-bg"> 
    <!-- mini logo for sidebar mini 50x50 pixels --> 
    <span class="logo-mini"><img src="{{ asset('assets/img/logo-n.png') }}" alt=""></span> 
    <!-- logo for regular state and mobile devices --> 
    <span class="logo-lg"><img src="{{ asset('assets/img/logo.png') }}" alt=""></span> </a> 
    <!-- Header Navbar -->
    <nav class="navbar blue-bg navbar-static-top"> 
      <!-- Sidebar toggle button-->
      <ul class="nav navbar-nav pull-left">
        <li><a class="sidebar-toggle" data-toggle="push-menu" href="#"></a> </li>
      </ul>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages -->
          <li class="dropdown messages-menu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa-light fa-envelope"></i>
            <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 0 new messages</li>
              <li>
                <ul class="menu">
                </ul>
              </li>
              <li class="footer"><a href="#">View All Messages</a></li>
            </ul>
          </li>
          <!-- Notifications  -->
          <li class="dropdown messages-menu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa-light fa-bell"></i>
            <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Notifications</li>
              <li>
                <ul class="menu">
                </ul>
              </li>
              <li class="footer"><a href="#">Check all Notifications</a></li>
            </ul>
          </li>
          <!-- User Account  -->
          <li class="dropdown user user-menu p-ph-res"> 
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"> 
              <img src="{{ asset('assets/img/img1.jpg') }}" class="user-image" alt="User Image"> 
              <span class="hidden-xs">{{ Auth::user()->name }}</span> 
            </a>
            <ul class="dropdown-menu">
              <li class="user-header">
                <p class="text-left">{{ Auth::user()->name }} <small>{{ Auth::user()->email }}</small> </p>
              </li>
              <li><a href="{{route('profile.edit')}}"><i class="fa-light fa-user mr-3"></i>Profile</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="route('logout')"><i class="fa-light fa-power-off mr-3"></i>Logout
                
                <form method="POST" action="{{ route('logout') }}" onclick="event.preventDefault();this.closest('form').submit();">
                @csrf
                </form>  
              </a></li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar"> 
    <!-- sidebar -->
    <div class="sidebar"> 
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="image text-center"><img src="{{ asset('assets/img/img1.jpg') }}" class="img-circle" alt="User Image"> </div>
        <div class="info">
          <p>Alexander Pierce</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a> </div>
      </div>
      
      <!-- sidebar menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">PERSONAL</li>
        <li class="treeview"> <a href="#"> <i class="icon-home"></i> <span>Dashboard</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li><a href="index.html"><i class="fa fa-angle-right"></i> Modern</a></li>
            <li><a href="index-crm.html"><i class="fa fa-angle-right"></i> CRM</a></li>
            <li><a href="index-analytics.html"><i class="fa fa-angle-right"></i> Analytics</a></li>
            <li><a href="index-ecommerce.html"><i class="fa fa-angle-right"></i> Ecommerce</a></li>
            <li><a href="index-medical.html"><i class="fa fa-angle-right"></i> Medical</a></li>
          </ul>
        </li>
        <li class="treeview"> <a href="#"> <i class="icon-grid"></i> <span>Apps</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li><a href="apps-calendar.html"><i class="fa fa-angle-right"></i> Calendar</a></li>
            <li><a href="apps-support-ticket.html"><i class="fa fa-angle-right"></i> Support Ticket</a></li>
            <li><a href="apps-contacts.html"><i class="fa fa-angle-right"></i> Contact / Employee</a></li>
            <li><a href="apps-contact-grid.html"><i class="fa fa-angle-right"></i> Contact  Grid</a></li>
            <li><a href="apps-contact-details.html"><i class="fa fa-angle-right"></i> Contact Detail</a></li>
          </ul>
        </li>
        <li class="treeview"> <a href="#"> <i class="ti-email"></i> <span>Inbox</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li><a href="apps-mailbox.html"><i class="fa fa-angle-right"></i> Mailbox</a></li>
            <li><a href="apps-mailbox-detail.html"><i class="fa fa-angle-right"></i> Mailbox Detail</a></li>
            <li><a href="apps-compose-mail.html"><i class="fa fa-angle-right"></i> Compose Mail</a></li>
          </ul>
        </li>
        <li class="treeview"> <a href="#"> <i class="icon-frame"></i> <span>UI Elements</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li><a href="ui-cards.html" class="active"><i class="fa fa-angle-right"></i> Cards</a></li>
            <li><a href="ui-user-card.html"><i class="fa fa-angle-right"></i> User Cards</a></li>
            <li><a href="ui-tab.html"><i class="fa fa-angle-right"></i> Tab</a></li>
            <li><a href="ui-grid.html"><i class="fa fa-angle-right"></i> Grid</a></li>
            <li><a href="ui-buttons.html"><i class="fa fa-angle-right"></i> Buttons</a></li>
            <li><a href="ui-notification.html"><i class="fa fa-angle-right"></i> Notification</a></li>
            <li><a href="ui-progressbar.html"><i class="fa fa-angle-right"></i> Progressbar</a></li>
            <li><a href="ui-range-slider.html"><i class="fa fa-angle-right"></i> Range slider</a></li>
            <li><a href="ui-timeline.html"><i class="fa fa-angle-right"></i> Timeline</a></li>
            <li><a href="ui-horizontal-timeline.html"> <i class="fa fa-angle-right"></i> Horizontal Timeline</a></li>
            <li><a href="ui-breadcrumb.html"><i class="fa fa-angle-right"></i> Breadcrumb</a></li>
            <li><a href="ui-typography.html"><i class="fa fa-angle-right"></i> Typography</a></li>
            <li><a href="ui-bootstrap-switch.html"><i class="fa fa-angle-right"></i> Bootstrap Switch</a></li>
            <li><a href="ui-tooltip-popover.html"><i class="fa fa-angle-right"></i> Tooltip &amp; Popover</a></li>
            <li><a href="ui-list-media.html"><i class="fa fa-angle-right"></i> List Media</a></li>
            <li><a href="ui-carousel.html"><i class="fa fa-angle-right"></i> Carousel</a></li>
          </ul>
        </li>
        <li class="header">FORMS, TABLE & WIDGETS</li>
        <li class="treeview"> <a href="#"> <i class="icon-note"></i> <span>Forms</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li><a href="form-elements.html"><i class="fa fa-angle-right"></i> Form Elements</a></li>
            <li><a href="form-validation.html"><i class="fa fa-angle-right"></i> Form Validation</a></li>
            <li><a href="form-wizard.html"><i class="fa fa-angle-right"></i> Form Wizard</a></li>
            <li><a href="form-layouts.html"><i class="fa fa-angle-right"></i> Form Layouts</a></li>
            <li><a href="form-uploads.html"><i class="fa fa-angle-right"></i> Form File Upload</a></li>
            <li><a href="form-summernote.html"><i class="fa fa-angle-right"></i> Summernote</a></li>
          </ul>
        </li>
        <li class="treeview"> <a href="#"> <i class="fa fa-table"></i> <span>Tables</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li><a href="table-basic.html"><i class="fa fa-angle-right"></i> Basic Tables</a></li>
            <li><a href="table-layout.html"><i class="fa fa-angle-right"></i> Table Layouts</a></li>
            <li><a href="table-data-table.html"><i class="fa fa-angle-right"></i> Data Tables</a></li>
            <li><a href="table-jsgrid.html"><i class="fa fa-angle-right"></i> Js Grid Table</a></li>
          </ul>
        </li>
        <li class="treeview"> <a href="#"> <i class="icon-layers"></i> <span>Widgets</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li><a href="widget-data.html"><i class="fa fa-angle-right"></i> Data Widgets</a></li>
            <li><a href="widget-apps.html"><i class="fa fa-angle-right"></i> Apps Widgets</a></li>
          </ul>
        </li>
        <li class="header">EXTRA COMPONENTS</li>
        <li class="treeview"> <a href="#"><i class="icon-chart"></i> <span>Charts</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li><a href="chart-morris.html"><i class="fa fa-angle-right"></i> Morris Chart</a></li>
            <li><a href="chart-chartist.html"><i class="fa fa-angle-right"></i> Chartis Chart</a></li>
            <li><a href="chart-knob.html"><i class="fa fa-angle-right"></i> Knob Chart</a></li>
            <li><a href="chart-chart-js.html"><i class="fa fa-angle-right"></i> Chartjs</a></li>
            <li><a href="chart-peity.html"><i class="fa fa-angle-right"></i> Peity Chart</a></li>
          </ul>
        </li>
        <li class="active treeview"> <a href="#"> <i class="icon-docs"></i> <span>Sample Pages</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li class="active"><a href="pages-blank.html"><i class="fa fa-angle-right"></i> Blank page</a></li>
            <li class="treeview"><a href="#"><i class="fa fa-angle-right"></i> Authentication <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
              <ul class="treeview-menu">
                <li><a href="pages-login.html"><i class="fa fa-angle-right"></i> Login 1</a></li>
                <li><a href="pages-login-2.html"><i class="fa fa-angle-right"></i> Login 2</a></li>
                <li><a href="pages-register.html"><i class="fa fa-angle-right"></i> Register</a></li>
                <li><a href="pages-register2.html"><i class="fa fa-angle-right"></i> Register 2</a></li>
                <li><a href="pages-lockscreen.html"><i class="fa fa-angle-right"></i> Lockscreen</a></li>
                <li><a href="pages-recover-password.html"><i class="fa fa-angle-right"></i> Recover password</a></li>
              </ul>
            </li>
            <li><a href="pages-profile.html"><i class="fa fa-angle-right"></i> Profile page</a></li>
            <li><a href="pages-invoice.html"><i class="fa fa-angle-right"></i> Invoice</a></li>
            <li><a href="pages-treeview.html"><i class="fa fa-angle-right"></i> Treeview</a></li>
            <li><a href="pages-pricing.html"><i class="fa fa-angle-right"></i> Pricing</a></li>
            <li><a href="pages-gallery.html"><i class="fa fa-angle-right"></i> Gallery</a></li>
            <li><a href="pages-faq.html"><i class="fa fa-angle-right"></i> Faqs</a></li>
            <li><a href="pages-404.html"><i class="fa fa-angle-right"></i> 404 Error Page</a></li>
          </ul>
        </li>
        <li class="treeview"> <a href="#"> <i class="icon-location-pin"></i> <span>Maps</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li><a href="map-google.html"><i class="fa fa-angle-right"></i> Google Maps</a></li>
            <li><a href="map-vector.html"><i class="fa fa-angle-right"></i> Vector Maps</a></li>
          </ul>
        </li>
        <li class="treeview"> <a href="#"> <i class="icon-energy"></i> <span>Icons</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li><a href="icon-fontawesome.html"><i class="fa fa-angle-right"></i> Fontawesome Icons</a></li>
            <li><a href="icon-themify.html"><i class="fa fa-angle-right"></i> Themify Icons</a></li>
            <li><a href="icon-linea.html"><i class="fa fa-angle-right"></i> Linea Icons</a></li>
            <li><a href="icon-weather.html"><i class="fa fa-angle-right"></i> Weather Icons</a></li>
            <li><a href="icon-simple-lineicon.html"><i class="fa fa-angle-right"></i> Simple Lineicons</a></li>
            <li><a href="icon-flag.html"><i class="fa fa-angle-right"></i> Flag Icons</a></li>
          </ul>
        </li>
        <li class="treeview"> <a href="#"> <i class="icon-action-redo"></i> <span>Multilevel</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-angle-right"></i> Level One</a></li>
            <li class="treeview"> <a href="#"><i class="fa fa-angle-right"></i> Level One <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-angle-right"></i> Level Two</a></li>
                <li class="treeview"> <a href="#" ><i class="fa fa-angle-right"></i> Level Two <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-angle-right"></i> Level Three</a></li>
                    <li><a href="#"><i class="fa fa-angle-right"></i> Level Three</a></li>
                  </ul>
                </li>
              </ul>
            </li>
            <li><a href="#"><i class="fa fa-angle-right"></i> Level One</a></li>
          </ul>
        </li>
      </ul>
    </div>
    <!-- /.sidebar --> 
  </aside>
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"> 
    <!-- Content Header (Page header) -->
    <div class="content-header sty-one">
      <h1>Blank page</h1>
      <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li><i class="fa fa-angle-right"></i> Blank page</li>
      </ol>
    </div>
    
    <!-- Main content -->
    <div class="content">
      <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                This is some text within a card block.
                            </div>
                        </div>
                    </div>
                </div>
    </div>
    <!-- /.content --> 
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">Version 1.0</div>
    Copyright © 2018 Yourdomian. All rights reserved.</footer>
</div>
<!-- ./wrapper --> 
</body>

<!-- Mirrored from uxliner.com/adminkit/demo/minisidebar/ltr/pages-blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 14 May 2021 18:47:41 GMT -->
</html>
