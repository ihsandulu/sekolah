<!-- My Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modal Header</h4>
            </div>
            <div class="modal-body">
                <p>Some text in the modal.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="iModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close btn btn-xs btn-danger" data-dismiss="modal" style="padding:5px;">&times;</button>
                <img id="imgmodal" src="<?= base_url("assets/images/global/image.gif"); ?>" style="width:auto; height:100%;" />
            </div>
        </div>

    </div>
</div>

<!-- Loading -->
<div id="loading" class="fa fa fa-spinner fa-pulse fa-3x fa-fw" style="display:none; position:fixed; left:50%; top:50%; transform:translate(-50%,-50%);"></div>

<div id="navbar" class="navbar navbar-default ace-save-state">
    <div class="navbar-container ace-save-state" id="navbar-container">
        <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
            <span class="sr-only">Toggle sidebar</span>

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>
        </button>

        <div class="navbar-header pull-left">
            <a href="index.html" class="navbar-brand">
                <small>
                    <img src="<?= base_url("assets/images/global/" . $identity->identity_picture); ?>" style="height:25px; width:auto;">
                    <?= $identity->identity_name; ?>
                </small>
            </a>
        </div>

        <div class="navbar-buttons navbar-header pull-right" role="navigation">
            <ul class="nav ace-nav">

                <li class="light-blue dropdown-modal">
                    <a data-toggle="dropdown" href="#" class="dropdown-toggle" id="userdetail">
                        <?php if ($this->session->userdata("user_picture") == "") {
                            $imgprofil = "user.gif";
                        } else {
                            $imgprofil = $this->session->userdata("user_picture");
                        } ?>
                        <img class="nav-user-photo" src="<?= base_url("assets/images/user_picture/" . $imgprofil); ?>" alt="Jason's Photo" style="height:40px; width:auto;" />
                        <span class="user-info">
                            <small>Welcome,</small>
                            <?= ucfirst($this->session->userdata("user_name")); ?>
                        </span>

                        <i class="ace-icon fa fa-caret-down"></i>
                    </a>

                    <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close" role="menu" aria-labelledby="userdetail">
                        <li role="presentation">
                            <?php
                            if ($this->session->userdata("position_id") == 3) {
                                $urlprofile = "guru";
                            }
                            if ($this->session->userdata("position_id") == 4) {
                                $urlprofile = "siswa";
                            }
                            if ($this->session->userdata("position_id") == 2 || $this->session->userdata("position_id") == 1) {
                                $urlprofile = "admin";
                            }
                            if ($this->session->userdata("position_id") == 5) {
                                $urlprofile = "petugastabungan";
                            }
                            ?>
                            <a role="menuitem" href="<?= site_url($urlprofile . "?id=" . $this->session->userdata("user_id")); ?>">
                                <i class="ace-icon fa fa-user"></i>
                                Profile
                            </a>
                        </li>

                        <li class="divider"></li>

                        <li role="presentation">
                            <a role="menuitem" href="<?= site_url("logout"); ?>">
                                <i class="ace-icon fa fa-power-off"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div><!-- /.navbar-container -->
</div>

<div class="main-container ace-save-state" id="main-container">
    <script type="text/javascript">
        try {
            ace.settings.loadState('main-container')
        } catch (e) {}
    </script>

    <div id="sidebar" class="sidebar                  responsive                    ace-save-state">
        <script type="text/javascript">
            try {
                ace.settings.loadState('sidebar')
            } catch (e) {}
        </script>

        <ul class="nav nav-list">
            <li class="active">
                <a href="<?= site_url(); ?>">
                    <i class="menu-icon fa fa-tachometer"></i>
                    <span class="menu-text"> Dashboard </span>
                </a>

                <b class="arrow"></b>
            </li>
            <?php if ($this->session->userdata("position_id") == 1 || $this->session->userdata("position_id") == 2) { ?>
                <li class="">
                    <a href="#" class="dropdown-toggle">
                        <i class="menu-icon fa fa-desktop"></i>
                        <span class="menu-text">
                            Master
                        </span>

                        <b class="arrow fa fa-angle-down"></b>
                    </a>

                    <b class="arrow"></b>

                    <ul class="submenu">
                        <?php if ($this->session->userdata("position_id") == "1" || $this->session->userdata("position_id") == "2") { ?>
                            <li class="">
                                <a href="<?= site_url("position"); ?>">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Position
                                </a>

                                <b class="arrow"></b>
                            </li>
                        <?php } ?>
                        <li class="">
                            <a href="#" class="dropdown-toggle">
                                <i class="menu-icon fa fa-caret-right"></i>

                                User
                                <b class="arrow fa fa-angle-down"></b>
                            </a>

                            <b class="arrow"></b>

                            <ul class="submenu">
                                <li class="">
                                    <a href="<?= site_url("admin"); ?>">
                                        <i class="menu-icon fa fa-caret-right"></i>
                                        Admin
                                    </a>

                                    <b class="arrow"></b>
                                </li>

                                <li class="">
                                    <a href="<?= site_url("guru"); ?>">
                                        <i class="menu-icon fa fa-caret-right"></i>
                                        Teacher
                                    </a>

                                    <b class="arrow"></b>
                                </li>

                                <li class="">
                                    <a href="<?= site_url("petugastabungan"); ?>">
                                        <i class="menu-icon fa fa-caret-right"></i>
                                        Savings Officer
                                    </a>

                                    <b class="arrow"></b>
                                </li>

                                <li class="">
                                    <a href="<?= site_url("siswa"); ?>">
                                        <i class="menu-icon fa fa-caret-right"></i>
                                        Student
                                    </a>

                                    <b class="arrow"></b>
                                </li>

                                <li class="">
                                    <a href="<?= site_url("telpon"); ?>">
                                        <i class="menu-icon fa fa-caret-right"></i>
                                        Telephone
                                    </a>

                                    <b class="arrow"></b>
                                </li>
                            </ul>
                        </li>

                        <?php if ($this->session->userdata("position_id") == "1" || $this->session->userdata("position_id") == "2") { ?>
                            <li class="">
                                <a href="<?= site_url("matpelgroup"); ?>">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Subjects Group
                                </a>

                                <b class="arrow"></b>
                            </li>
                        <?php } ?>

                        <?php if ($this->session->userdata("position_id") == "1" || $this->session->userdata("position_id") == "2") { ?>
                            <li class="">
                                <a href="<?= site_url("matpel"); ?>">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Subjects
                                </a>

                                <b class="arrow"></b>
                            </li>
                        <?php } ?>

                        <?php if ($this->session->userdata("position_id") == "1" || $this->session->userdata("position_id") == "2") { ?>
                            <li class="">
                                <a href="<?= site_url("sumatif"); ?>">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Sumatif
                                </a>

                                <b class="arrow"></b>
                            </li>
                        <?php } ?>

                        <?php if ($this->session->userdata("position_id") == "1" || $this->session->userdata("position_id") == "2") { ?>
                            <li class="">
                                <a href="<?= site_url("tabungankode"); ?>">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Account Code
                                </a>

                                <b class="arrow"></b>
                            </li>
                        <?php } ?>

                        <?php if ($this->session->userdata("position_id") == "1" || $this->session->userdata("position_id") == "2") { ?>
                            <li class="">
                                <a href="<?= site_url("kelas"); ?>">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Class
                                </a>

                                <b class="arrow"></b>
                            </li>
                        <?php } ?>

                        <li class="">
                            <a href="<?= site_url("jamabsen"); ?>">
                                <i class="menu-icon fa fa-clock-o"></i>
                                Attandance Time
                            </a>

                            <b class="arrow"></b>
                        </li>

                        <li class="">
                            <a href="<?= site_url("sekolah"); ?>">
                                <i class="menu-icon fa fa-caret-right"></i>
                                School
                            </a>

                            <b class="arrow"></b>
                        </li>

                        <li class="">
                            <a target="_self" href="<?= site_url("printtemplateabsenguru"); ?>">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Barcode Kelas
                            </a>

                            <b class="arrow"></b>
                        </li>

                        <li class="">
                            <a target="_self" href="<?= site_url("printtemplatebarcode"); ?>">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Student Barcode Print
                            </a>

                            <b class="arrow"></b>
                        </li>

                        <li class="">
                            <a target="_self" href="<?= site_url("mpelanggaran"); ?>">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Violation Name
                            </a>

                            <b class="arrow"></b>
                        </li>

                        <!--  <li class="">
                        <a href="<?= site_url("grup"); ?>">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Group
                        </a>

                        <b class="arrow"></b>
                    </li> -->

                        <li class="">
                            <a href="<?= site_url("backup"); ?>">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Backup Database
                            </a>

                            <b class="arrow"></b>
                        </li>

                        <li class="">
                            <a href="<?= site_url("restore"); ?>">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Restore Database
                            </a>

                            <b class="arrow"></b>
                        </li>
                    </ul>
                </li>
            <?php } ?>
            <?php if ($this->session->userdata("position_id") != 4) { ?>
                <li class="">
                    <a href="#" class="dropdown-toggle">
                        <i class="menu-icon fa fa-list"></i>
                        <span class="menu-text"> Transaction </span>

                        <b class="arrow fa fa-angle-down"></b>
                    </a>

                    <b class="arrow"></b>
                    <ul class="submenu">
                        <?php if ($this->session->userdata("position_id") != 5) { ?>
                            <li class="">
                                <a href="<?= site_url("attandanceg"); ?>">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Absen Guru
                                </a>
                                <b class="arrow"></b>
                            </li>
                        <?php } ?>
                        <!-- <li class="">
                        <a href="<?= site_url("grupt"); ?>">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Group
                        </a>

                        <b class="arrow"></b>
                    </li> -->
                        <?php if ($this->session->userdata("position_id") != 4 && $this->session->userdata("position_id") != 5) { ?>
                            <li class="">
                                <a href="<?= site_url("catatan"); ?>">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Student Note
                                </a>

                                <b class="arrow"></b>
                            </li>
                        <?php } ?>
                        <?php if ($this->session->userdata("position_id") != 3 && $this->session->userdata("position_id") != 5) { ?>
                            <li class="">
                                <a href="<?= site_url("transaction"); ?>">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Transaction
                                </a>

                                <b class="arrow"></b>
                            </li>
                        <?php } ?>
                        <?php if ($this->session->userdata("position_id") != 3) { ?>
                            <li class="">
                                <a href="<?= site_url("tabungan"); ?>">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Account
                                </a>

                                <b class="arrow"></b>
                            </li>
                        <?php } ?>
                        <?php if ($this->session->userdata("position_id") != 5) { ?>
                            <li class="">
                                <a href="<?= site_url("nilai"); ?>">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Score
                                </a>

                                <b class="arrow"></b>
                            </li>
                        <?php } ?>
                        <?php if ($this->session->userdata("position_id") != 5) { ?>
                            <li class="">
                                <a href="<?= site_url("attandance"); ?>">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Attendance
                                </a>
                                <b class="arrow"></b>
                            </li>
                        <?php } ?>
                        <?php if ($this->session->userdata("position_id") != 5) { ?>
                            <li class="">
                                <a href="<?= site_url("pelanggaran"); ?>">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Violation
                                </a>
                                <b class="arrow"></b>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
            <?php } ?>

            <li class="">
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-pencil-square-o"></i>
                    <span class="menu-text"> Report </span>

                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <b class="arrow"></b>

                <ul class="submenu">
                    <?php if ($this->session->userdata("position_id") == 4) { ?>
                        <li class="">
                            <a href="<?= site_url("attandanceg"); ?>">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Absen Guru
                            </a>
                            <b class="arrow"></b>
                        </li>
                    <?php } ?>
                    <?php if ($this->session->userdata("position_id") != 5) { ?>
                        <li class="">
                            <a href="<?= site_url("rraport"); ?>">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Raport
                            </a>

                            <b class="arrow"></b>
                        </li>
                    <?php } ?>
                    <?php if ($this->session->userdata("position_id") != 3 && $this->session->userdata("position_id") != 5) { ?>
                        <li class="">
                            <a href="<?= site_url("transaction?laporan=ok"); ?>">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Transaction
                            </a>

                            <b class="arrow"></b>
                        </li>
                    <?php } ?>
                    <?php if ($this->session->userdata("position_id") != 3) { ?>
                        <li class="">
                            <a href="<?= site_url("tabungan?laporan=ok&type=current"); ?>">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Account
                            </a>

                            <b class="arrow"></b>
                        </li>
                    <?php } ?>
                    <?php if ($this->session->userdata("position_id") != 5) { ?>
                        <li class="">
                            <!-- <a href="<?= site_url("rabsensi"); ?>">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Attendance
                        </a> -->
                            <a href="<?= site_url("rabsen"); ?>">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Attendance
                            </a>

                            <b class="arrow"></b>
                        </li>
                    <?php } ?>
                    <?php if ($this->session->userdata("position_id") != 5) { ?>
                        <li class="">
                            <a href="<?= site_url("pelanggaran?laporan=ok"); ?>">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Violation
                            </a>
                            <b class="arrow"></b>
                        </li>
                    <?php } ?>
                    <!-- <li class="">
                        <a href="<?= site_url("rnilai"); ?>">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Scores
                        </a>

                        <b class="arrow"></b>
                    </li>   -->

                </ul>
            </li>


        </ul><!-- /.nav-list -->

        <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
            <i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
        </div>
    </div>
    <?php //print_r($_SESSION);
    ?>