<?php
session_start();

// Access Control & Authentication: Ensuring only authenticated admin users can access the page.
if (!isset($_SESSION['admin_id'])) {
    header("Location: ./login.php");
    exit;
}

require_once('DBConnection.php');

// Default page is 'home' if not specified in URL
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>
<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ucwords(str_replace('_', ' ', $page)) ?> | Student Quarterly Grading System</title>
    
    <!-- Compliance: Using secure, modern web standards and practices -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap">
    <!-- Icons -->
    <link rel="stylesheet" href="templates/assets/vendor/fonts/boxicons.css">
    <!-- Core CSS -->
    <link rel="stylesheet" href="templates/assets/vendor/css/core.css" class="template-customizer-core-css">
    <link rel="stylesheet" href="templates/assets/vendor/css/theme-default.css" class="template-customizer-theme-css">
    <link rel="stylesheet" href="templates/assets/css/demo.css">
    

<!-- Security Policies and Procedures -->
    <link rel="stylesheet" href="templates/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css">
    <script src="templates/assets/vendor/js/helpers.js"></script>

    
    <script src="templates/assets/js/config.js"></script>
    <link rel="stylesheet" href="./Font-Awesome-master/css/all.min.css">
    <link rel="stylesheet" href="templates/css/bootstrap.min.css">
    <link rel="stylesheet" href="./select2/css/select2.min.css">
    <script src="./js/jquery-3.6.0.min.js"></script>
    <script src="./js/popper.min.js"></script>
    <script src="./select2/js/select2.full.min.js"></script>
    <link rel="stylesheet" href="./DataTables/datatables.min.css">
    <script src="./DataTables/datatables.min.js"></script>
    <script src="./Font-Awesome-master/js/all.min.js"></script>
    <script src="./js/script.js"></script>
</head>
<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="index.html" class="app-brand-link">
                        <span class="app-brand-logo demo">

                            <!-- Risk Management: Displaying a logo which helps in identifying the organization -->
                            <a href="javascript:void(0);">
                                <img src="image/logo.png" alt="Logo" class="w-px-40 h-auto rounded-circle">
                            </a>
                        </span>
                        <span class="app-brand-text demo menu-text fw-bolder ms-2">SQGS</span>
                    </a>
                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>
                <div class="menu-inner-shadow"></div>
                <ul class="menu-inner py-1">
                    
                    <!-- Access Control: Ensuring only authorized users can access specific sections of the application -->
                    <!-- Dashboard -->
                    <li class="menu-item <?php echo ($page == 'home') ? 'active' : '' ?>">
                        <a href="./?page=home" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home-circle"></i>
                            <div data-i18n="Analytics">Home</div>
                        </a>
                    </li>
                    <!-- Other menu items -->
                    <li class="menu-item <?php echo ($page == 'class') ? 'active' : '' ?>">
                        <a href="./?page=class" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-chalkboard"></i>
                            <div data-i18n="Class">Class</div>
                        </a>
                    </li>
                    <li class="menu-item <?php echo ($page == 'students') ? 'active' : '' ?>">
                        <a href="./?page=students" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-user"></i>
                            <div data-i18n="Students">Students</div>
                        </a>
                    </li>
                    <li class="menu-item <?php echo ($page == 'assessments') ? 'active' : '' ?>">
                        <a href="./?page=assessments" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-list-ol"></i>
                            <div data-i18n="Assessments">Assessments</div>
                        </a>
                    </li>
                    <li class="menu-item <?php echo ($page == 'marks') ? 'active' : '' ?>">
                        <a href="./?page=marks" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-edit-alt"></i>
                            <div data-i18n="Marks">Marks</div>
                        </a>
                    </li>
                    <li class="menu-item <?php echo ($page == 'reports') ? 'active' : '' ?>">
                        <a href="./?page=reports" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-bar-chart-alt-2"></i>
                            <div data-i18n="Reports">Reports</div>
                        </a>
                    </li>
                    <li class="menu-item <?php echo ($page == 'users') ? 'active' : '' ?>">
                        <a href="./?page=users" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-group"></i>
                            <div data-i18n="Users">Users</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="./?page=maintenance" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-wrench"></i>
                            <div data-i18n="Maintenance">Maintenance</div>
                        </a>
                    </li>
                </ul>
            </aside>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>
                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">Student Quarterly Grading System
                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <!-- User Dropdown -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="avatar avatar-online">
                                        <img src="image/logo.png" alt="Logo" class="w-px-40 h-auto rounded-circle">
                                    </div>
                                </a>

                                <!-- Authentication: User greeting to show authenticated user -->
                                
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <span class="fw-semibold d-block">Hello <?php echo $_SESSION['fullname'] ?></span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="./?page=manage_account">
                                            <i class="bx bx-user me-2"></i>
                                            <span class="align-middle">Manage Account</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="./Actions.php?a=logout">
                                            <i class="bx bx-power-off me-2"></i>
                                            <span class="align-middle">Logout</span>
                                        </a>
                                    </li>
                                </ul>
                                <!-- /Dropdown Menu -->
                            </li>
                            <!--/ User Dropdown -->
                        </ul>
                    </div>
                </nav>
                <!-- / Navbar -->

                <div class="container py-3" id="page-container">

                     <!-- Confidentiality & Risk Management: Displaying session flash data to inform users about important actions -->
        <?php 

            if(isset($_SESSION['flashdata'])):
        ?>
        <div class="dynamic_alert alert alert-<?php echo $_SESSION['flashdata']['type'] ?>">
        <div class="float-end"><a href="javascript:void(0)" class="text-dark text-decoration-none" onclick="$(this).closest('.dynamic_alert').hide('slow').remove()">x</a></div>
            <?php echo $_SESSION['flashdata']['msg'] ?>
        </div>
        <?php unset($_SESSION['flashdata']) ?>
        <?php endif; ?>

        <!-- Authentication: Include specific page based on user navigation -->
        <?php
            include $page.'.php';
        ?>
    </div>
    </main>
    <div class="modal fade" id="uni_modal" role='dialog' data-bs-backdrop="static" data-bs-keyboard="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title"></h5>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer py-1">
            <button type="button" class="btn btn-sm rounded-0 btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
            <button type="button" class="btn btn-sm rounded-0 btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        </div>
        </div>
    </div>
    <div class="modal fade" id="uni_modal_secondary" role='dialog' data-bs-backdrop="static" data-bs-keyboard="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title"></h5>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer py-1">
            <button type="button" class="btn btn-sm rounded-0 btn-primary" id='submit' onclick="$('#uni_modal_secondary form').submit()">Save</button>
            <button type="button" class="btn btn-sm rounded-0 btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        </div>
        </div>
    </div>
    <div class="modal fade" id="confirm_modal" role='dialog'>
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header py-2">
            <h5 class="modal-title">Confirmation</h5>
        </div>
        <div class="modal-body">
            <div id="delete_content"></div>
        </div>
        <div class="modal-footer py-1">
            <button type="button" class="btn btn-primary btn-sm rounded-0" id='confirm' onclick="">Continue</button>
            <button type="button" class="btn btn-secondary btn-sm rounded-0" data-bs-dismiss="modal">Close</button>
        </div>
        </div>
        </div>
    </div>

                
            </div>
            <!-- / Layout container -->
        </div>
      
    </div>
    <!-- Core JS -->
    <script src="templates/assets/vendor/js/bundle.js"></script>
    <script src="templates/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="templates/assets/vendor/js/sidebar.js"></script>
    <!-- App JS -->
    <script src="templates/assets/js/demo.js"></script>
    <!-- Bootstrap Bundle JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>
