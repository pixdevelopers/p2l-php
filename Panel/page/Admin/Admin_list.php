<?php
/**
 * Created by Mohammad reza Moshaver.
 * Date: 1/23/2018 AD
 * Time: 15:50
 */
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

############ Initial requirements ############
require_once('../../class/General/General.class.php');
require_once('../../class/UserGroups/UserGroups.class.php');
require_once('../../class/Users/Users.class.php');
$General = new General();
$UserGroups = new UserGroups();
$Users = new Users();
############ Initial requirements ############

############ Check login ############
if(isset($_GET['Logout'])){
    $Users->AdminLogout();
}
$CheckLogin = $General->AdminCheckLogin();
############ Check login ############

############ Check Params & Privilege to show page ############
$show_page = '1';
$ParamError = '0';

if($CheckLogin != ''){
    $show_page = '0';
    $CheckLogin_Error = explode('_',$CheckLogin);
    $error = $CheckLogin_Error['1'];
}
elseif($General->CheckPrivilege('Admin_Manage') == '0'){
    $show_page = '0';
    $error = 'Your account doesn\'t have sufficient privilege to this part! ';
}
elseif(true) {
    $show_page = '1';
}
else {
    $show_page = '0';
    $ParamError = '1';
    $error = 'Parameter error';
}
############ Check Params & Privilege to show page ############
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PSD2Live - User Dashboard</title>
    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="../../assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="../../assets/css/custom.css" rel="stylesheet" type="text/css">

    <link href="../../assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="../../assets/css/core.css" rel="stylesheet" type="text/css">
    <link href="../../assets/css/components.css" rel="stylesheet" type="text/css">
    <link href="../../assets/css/colors.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->
    <!-- Core JS files -->
    <script type="text/javascript" src="../../assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="../../assets/js/core/libraries/jquery.min.js"></script>
    <script type="text/javascript" src="../../assets/js/core/libraries/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->
    <!-- Theme JS files -->
    <script type="text/javascript" src="../../assets/js/plugins/visualization/d3/d3.min.js"></script>
    <script type="text/javascript" src="../../assets/js/plugins/visualization/d3/d3_tooltip.js"></script>
    <script type="text/javascript" src="../../assets/js/plugins/forms/styling/switchery.min.js"></script>
    <script type="text/javascript" src="../../assets/js/plugins/forms/styling/uniform.min.js"></script>
    <script type="text/javascript" src="../../assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
    <script type="text/javascript" src="../../assets/js/plugins/ui/moment/moment.min.js"></script>
    <script type="text/javascript" src="../../assets/js/plugins/pickers/daterangepicker.js"></script>
    <script type="text/javascript" src="../../assets/js/plugins/ui/nicescroll.min.js"></script>
    <script type="text/javascript" src="../../assets/js/core/app.js"></script>
    <script type="text/javascript" src="../../assets/js/plugins/ui/ripple.min.js"></script>
    <!-- /theme JS files -->
    <!-- LazyLoad -->
    <script type="text/javascript" src="../../assets/js/pages/chat_layouts.js"></script>
    <!-- LazyLoad -->
</head>

<body class="navbar-top">
<!-- Main navbar -->
<div class="navbar navbar-inverse navbar-fixed-top bg-slate">
    <div class="navbar-header">
        <a class="navbar-brand" href="index.html"><img src="../../assets/images/logo_light.png" alt=""></a>
        <ul class="nav navbar-nav visible-xs-block">
            <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
            <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
        </ul>
    </div>
    <div class="navbar-collapse collapse" id="navbar-mobile">
        <div class="navbar-right">
            <p class="navbar-text">Morning, Victoria!</p>
            <p class="navbar-text"><span class="label bg-success-400">Online</span></p>
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-bell2"></i>
                        <span class="visible-xs-inline-block position-right">Activity</span>
                        <span class="status-mark border-orange-400"></span>
                    </a>
                    <div class="dropdown-menu dropdown-content">
                        <div class="dropdown-content-heading">
                            Activity
                            <ul class="icons-list">
                                <li><a href="#"><i class="icon-menu7"></i></a></li>
                            </ul>
                        </div>
                        <ul class="media-list dropdown-content-body width-350">
                            <li class="media">
                                <div class="media-left">
                                    <a href="#" class="btn bg-success-400 btn-rounded btn-icon btn-xs"><i class="icon-mention"></i></a>
                                </div>
                                <div class="media-body">
                                    <a href="#">Taylor Swift</a> mentioned you in a post "Angular JS. Tips and tricks"
                                    <div class="media-annotation">4 minutes ago</div>
                                </div>
                            </li>
                            <li class="media">
                                <div class="media-left">
                                    <a href="#" class="btn bg-pink-400 btn-rounded btn-icon btn-xs"><i class="icon-paperplane"></i></a>
                                </div>
                                <div class="media-body">
                                    Special offers have been sent to subscribed users by <a href="#">Donna Gordon</a>
                                    <div class="media-annotation">36 minutes ago</div>
                                </div>
                            </li>
                            <li class="media">
                                <div class="media-left">
                                    <a href="#" class="btn bg-blue btn-rounded btn-icon btn-xs"><i class="icon-plus3"></i></a>
                                </div>
                                <div class="media-body">
                                    <a href="#">Chris Arney</a> created a new <span class="text-semibold">Design</span> branch in <span class="text-semibold">Limitless</span> repository
                                    <div class="media-annotation">2 hours ago</div>
                                </div>
                            </li>
                            <li class="media">
                                <div class="media-left">
                                    <a href="#" class="btn bg-purple-300 btn-rounded btn-icon btn-xs"><i class="icon-truck"></i></a>
                                </div>
                                <div class="media-body">
                                    Shipping cost to the Netherlands has been reduced, database updated
                                    <div class="media-annotation">Feb 8, 11:30</div>
                                </div>
                            </li>
                            <li class="media">
                                <div class="media-left">
                                    <a href="#" class="btn bg-warning-400 btn-rounded btn-icon btn-xs"><i class="icon-bubble8"></i></a>
                                </div>
                                <div class="media-body">
                                    New review received on <a href="#">Server side integration</a> services
                                    <div class="media-annotation">Feb 2, 10:20</div>
                                </div>
                            </li>
                            <li class="media">
                                <div class="media-left">
                                    <a href="#" class="btn bg-teal-400 btn-rounded btn-icon btn-xs"><i class="icon-spinner11"></i></a>
                                </div>
                                <div class="media-body">
                                    <strong>January, 2016</strong> - 1320 new users, 3284 orders, $49,390 revenue
                                    <div class="media-annotation">Feb 1, 05:46</div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-bubble8"></i>
                        <span class="visible-xs-inline-block position-right">Messages</span>
                        <span class="status-mark border-orange-400"></span>
                    </a>
                    <div class="dropdown-menu dropdown-content width-350">
                        <div class="dropdown-content-heading">
                            Messages
                            <ul class="icons-list">
                                <li><a href="#"><i class="icon-compose"></i></a></li>
                            </ul>
                        </div>
                        <ul class="media-list dropdown-content-body">
                            <li class="media">
                                <div class="media-left">
                                    <img src="../../assets/images/placeholder.jpg" class="img-circle img-sm" alt="">
                                    <span class="badge bg-danger-400 media-badge">5</span>
                                </div>
                                <div class="media-body">
                                    <a href="#" class="media-heading">
                                        <span class="text-semibold">James Alexander</span>
                                        <span class="media-annotation pull-right">04:58</span>
                                    </a>
                                    <span class="text-muted">who knows, maybe that would be the best thing for me...</span>
                                </div>
                            </li>
                            <li class="media">
                                <div class="media-left">
                                    <img src="../../assets/images/placeholder.jpg" class="img-circle img-sm" alt="">
                                    <span class="badge bg-danger-400 media-badge">4</span>
                                </div>
                                <div class="media-body">
                                    <a href="#" class="media-heading">
                                        <span class="text-semibold">Margo Baker</span>
                                        <span class="media-annotation pull-right">12:16</span>
                                    </a>
                                    <span class="text-muted">That was something he was unable to do because...</span>
                                </div>
                            </li>
                            <li class="media">
                                <div class="media-left"><img src="../../assets/images/placeholder.jpg" class="img-circle img-sm" alt=""></div>
                                <div class="media-body">
                                    <a href="#" class="media-heading">
                                        <span class="text-semibold">Jeremy Victorino</span>
                                        <span class="media-annotation pull-right">22:48</span>
                                    </a>
                                    <span class="text-muted">But that would be extremely strained and suspicious...</span>
                                </div>
                            </li>
                            <li class="media">
                                <div class="media-left"><img src="../../assets/images/placeholder.jpg" class="img-circle img-sm" alt=""></div>
                                <div class="media-body">
                                    <a href="#" class="media-heading">
                                        <span class="text-semibold">Beatrix Diaz</span>
                                        <span class="media-annotation pull-right">Tue</span>
                                    </a>
                                    <span class="text-muted">What a strenuous career it is that I've chosen...</span>
                                </div>
                            </li>
                            <li class="media">
                                <div class="media-left"><img src="../../assets/images/placeholder.jpg" class="img-circle img-sm" alt=""></div>
                                <div class="media-body">
                                    <a href="#" class="media-heading">
                                        <span class="text-semibold">Richard Vango</span>
                                        <span class="media-annotation pull-right">Mon</span>
                                    </a>
                                    <span class="text-muted">Other travelling salesmen live a life of luxury...</span>
                                </div>
                            </li>
                        </ul>
                        <div class="dropdown-content-footer">
                            <a href="#" data-popup="tooltip" title="All messages"><i class="icon-menu display-block"></i></a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- /main navbar -->
<!-- Page container -->
<div class="page-container">
    <!-- Page content -->
    <div class="page-content">
        <!-- Main sidebar -->
        <div class="sidebar sidebar-main sidebar-default sidebar-fixed">
            <div class="sidebar-content">
                <?php include ('../../menu.php'); ?>
            </div>
        </div>
        <!-- /main sidebar -->
        <!-- Main content -->
        <div class="content-wrapper">
            <!-- Content area -->
            <div class="content">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-flat" style="padding-top: 15px;">
                            <?php if($show_page == '1') { ?>

                                <table border="1" width="100%">
                                    <tr>
                                        <td>No</td>
                                        <td>Name</td>
                                        <td>Username</td>
                                        <td>Member of</td>
                                        <td>Supervisor</td>
                                        <td>Status</td>
                                        <td>Actions</td>
                                    </tr>
                                    <?php
                                    $i = '1';
                                    $List = $Users->SelectAdmin('','','','','','','');
                                    while($row = mysqli_fetch_assoc($List)){

                                        if($row['GroupID'] != '') {
                                            $GroupInfo = $UserGroups->SelectUserGroups('1', '', $row['GroupID'], '', '', '', '', '1');
                                            $row_Group = mysqli_fetch_assoc($GroupInfo);
                                            $GroupName = $row_Group['Name'];
                                        }
                                        else{
                                            $GroupName = '------';
                                        }
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $row['Name']; ?></td>
                                            <td><?php echo $row['Username']; ?></td>
                                            <td><?php echo $GroupName; ?></td>
                                            <td>
                                                <?php if($row['IsSuperadmin'] == '1'){
                                                    echo 'YES';
                                                }
                                                else{
                                                    echo 'NO';
                                                }?>
                                            </td>
                                            <td>
                                                <?php if($row['Status'] == '1'){
                                                    echo 'Enable';
                                                }
                                                else{
                                                    echo 'Disable';
                                                }?>
                                            </td>
                                            <td>
                                                <a href="Admin_edit.php?ID=<?php echo $row['ID']; ?>">Edit</a>&nbsp;&nbsp;
                                                <a href="Admin_action.php?action=delete&ID=<?php echo $row['ID']; ?>" target="_blank">Delete</a>&nbsp;&nbsp;
                                                <a href="Admin_ChangePass.php?ID=<?php echo $row['ID']; ?>">Change password</a>&nbsp;&nbsp;
                                            </td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                    ?>
                                </table>
                                <div style="clear: both; padding-bottom: 15px;"></div>
                                <?php
                            }
                            else {
                                ?>
                                <div class="panel-heading">
                                    <h5 class="panel-title"><?php echo $error; ?></h5>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /content area -->
        </div>
        <!-- /main content -->
    </div>
    <!-- /page content -->
</div>
<!-- /page container -->
</body>

</html>

