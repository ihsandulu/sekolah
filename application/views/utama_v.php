<!DOCTYPE html>
<html>
<head>
<?php require_once("meta.php");?>
<style>
.bigger{font-size:14px !important;}
</style>
</head>

<body class="no-skin">
<?php require_once("header.php");?>
	


    <div class="main-content">
        <div class="main-content-inner">
            <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                <ul class="breadcrumb">
                    <li>
                        <i class="ace-icon fa fa-home home-icon"></i>
                        <a href="#">Home</a>
                    </li>
                    <li class="active">Dashboard</li>
                </ul><!-- /.breadcrumb -->                
            </div>

            <div class="page-content">

                <div class="page-header">
                    <h1>
                        Dashboard
                    </h1>
                </div><!-- /.page-header -->

                <div class="row">
                    <div class="col-xs-12">
                        <div class="alert alert-block alert-success">
                            <button type="button" class="close" data-dismiss="alert">
                                <i class="ace-icon fa fa-times"></i>
                            </button>

                            <i class="ace-icon fa fa-star"></i>

                            Welcome 
                                <?=$this->session->userdata("user_name");?> to
                            <strong class="green"> Smart School's System
                                <small>(v2.0)</small>
                            </strong> [&copy; <?=date("Y");?>].
                        </div>
                        <div class="alert alert-block alert-success row">
                            <div class="col-md-4">
                                <a href="<?=base_url("absen?type=1&color=green;");?>" class="btn btn-block btn-success">
                                    Absensi Masuk
                                </a>   
                            </div> 
                            <div class="col-md-4">                        
                                <a href="<?=base_url("absen?type=2&color=orange;");?>" class="btn btn-block btn-warning">
                                    Absensi Keluar
                                </a>   
                            </div>   
                            <div class="col-md-4">                        
                                <a href="<?=base_url("pelunasanwa?color=blue;");?>" class="btn btn-block btn-primary">
                                    Alert Pelunasan
                                </a>   
                            </div>                            
                        </div>
                        <div class="row">
                            <div class="space-6"></div>
                            <div class="col-sm-7 infobox-container">
                                <div class="infobox infobox-blue">
                                    <div class="infobox-icon">
                                        <i class="ace-icon fa fa-twitter"></i>
                                    </div>
                                    <div class="infobox-data">
                                        <span class="infobox-data-number">
										<?php
										if($this->session->userdata("sekolah_id")>0){
											$this->db->where("sekolah_id",$this->session->userdata("sekolah_id"));
										}
										$teachers = $this->db
                                        ->where("position_id","3")
                                        ->get("user")->num_rows();
										echo $teachers;
										?>
										</span>
                                        <div class="infobox-content">Teachers</div>
                                    </div>
                                </div>								
                                <div class="infobox infobox-green">
                                    <div class="infobox-icon">
                                        <i class="ace-icon fa fa-comments"></i>
                                    </div>
                                    <div class="infobox-data">
                                        <span class="infobox-data-number">
										<?php
										if($this->session->userdata("sekolah_id")>0){
											$this->db->where("sekolah_id",$this->session->userdata("sekolah_id"));
										}
										$student = $this->db
                                        ->where("position_id","4")->get("user")->num_rows();
										echo $student;
										?>
										</span>
                                        <div class="infobox-content">Student</div>
                                    </div>
                                </div>
                                <div class="infobox infobox-red">
                                    <div class="infobox-icon">
                                        <i class="ace-icon fa fa-flask"></i>
                                    </div>
                                    <div class="infobox-data">
                                        <span class="infobox-data-number">
										<?php
										if($this->session->userdata("sekolah_id")>0){
											$this->db->where("sekolah_id",$this->session->userdata("sekolah_id"));
										}
										$matpel = $this->db->get("matpel")->num_rows();
										echo $matpel;
										?>
										</span>
                                        <div class="infobox-content">Lessons</div>
                                    </div>
                                </div>
                                <div class="space-6"></div>
                                <div class="infobox infobox-green infobox-small infobox-dark">
                                    <div class="infobox-progress">
                                        <div class="easy-pie-chart percentage" data-percent="61" data-size="39">
                                            <span class="percent">
											<?php 
											//cek jml siswa
											$jml=$this->db
											->where("sekolah_id",$this->session->userdata("sekolah_id"))
											->where("position_id","4")
											->get("user")
											->num_rows();
											$absen=$this->db
											->where("absen_date",date("Y-m-d"))
											->where("sekolah_id",$this->session->userdata("sekolah_id"))
											->get("absen")
											->num_rows();
											
											if($jml==0){$jml=1;}
											//echo $this->db->last_query();
											echo number_format($absen/$jml*100,1,",",".");
											?>
											</span>%
                                        </div>
                                    </div>

                                    <div class="infobox-data">
                                        <div class="infobox-content">Attendance</div>
                                        <div class="infobox-content"><?=date("d M y");?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="vspace-12-sm"></div>
                            <div class="col-sm-5">
                                <div class="widget-box">
                                    <div class="widget-header widget-header-flat widget-header-small">
                                        <h5 class="widget-title">
                                            <i class="ace-icon fa fa-signal"></i>
                                            Number of logins
                                        </h5>
                                        <div class="widget-toolbar no-border">
                                            <div class="inline dropdown-hover">
                                                <button class="btn btn-minier btn-primary">
                                                    This day
                                                </button>

                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <div id="piechart-placeholder"></div>
                                            <div class="hr hr8 hr-double"></div>
                                            <div class="clearfix">
												<?php $jmllogin=$this->db
												->where("sekolah_id",$this->session->userdata("sekolah_id"))
												->where("login_date",date("Y-m-d"))
												->get("login");
												if($jmllogin->num_rows()>0){
													$login_siswa=$jmllogin->row()->login_siswa;
													$login_guru=$jmllogin->row()->login_guru;
													$login_admin=$jmllogin->row()->login_admin;
												}else{
													$login_siswa=0;
													$login_guru=0;
													$login_admin=0;
												}
												?>
                                                <div class="grid3">
                                                    <span class="grey">
                                                        <i class="ace-icon fa fa-grav fa-2x blue"></i>
                                                        &nbsp; Student
                                                    </span>
                                                    <h4 class="bigger pull-right"><?=number_format($login_siswa,0,",",".");?></h4>
                                                </div>

                                                <div class="grid3">
                                                    <span class="grey">
                                                        <i class="ace-icon fa fa-blind fa-2x purple"></i>
                                                        &nbsp; Teacher
                                                    </span>
                                                    <h4 class="bigger pull-right"><?=number_format($login_guru,0,",",".");?></h4>
                                                </div>

                                                <div class="grid3">
                                                    <span class="grey">
                                                        <i class="ace-icon fa fa-user-secret fa-2x red"></i>
                                                        &nbsp; Admin
                                                    </span>
                                                    <h4 class="bigger pull-right"><?=number_format($login_admin,0,",",".");?></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>	
                    </div>                    
                    <div class="col-md-7">
                        <div class="col-md-12" style="border:#FDDABB dashed 1px; margin-bottom:30px; padding:10px;">
                            <form id="sp" method="get" class="form-inline" action="">
                                
                                <?php if(isset($_POST['type'])&&$_POST['type']=="Kredit"){$display="display:inline;";}else{$display="display:none;";}?>
                                <div class="form-group" style="<?=$display;?>" id="divkelas">
                                <label for="kelas">Class:</label>
                                <select id="kelas" name="kelas">
                                    <option value="" <?=($this->input->get("kelas")=="")?"selected":"";?>>All</option>
                                    <?php $kelas=$this->db
                                    ->join("kelas","kelas.kelas_id=kelas_sekolah.kelas_id","left")
                                    ->where("kelas_sekolah.sekolah_id",$this->session->userdata("sekolah_id"))
                                    ->get("kelas_sekolah");
                                    foreach($kelas->result() as $kelas){?>
                                    <option value="<?=$kelas->kelas_id;?>" <?=($this->input->get("kelas")==$kelas->kelas_id)?"selected":"";?>><?=$kelas->kelas_name;?></option>
                                    <?php }?>
                                </select>
                                </div>
                                <?php 
                                if(isset($_GET['absen_date'])&&$_GET['absen_date']!=""){
                                    $absen_date=$this->input->get("absen_date");
                                }else{
                                    $absen_date=date("Y-m-d");
                                }
                                ?>
                                <div class="form-group">
                                <label for="absen_date">Tanggal:</label>
                                <input id="absen_date" name="absen_date" type="date" value="<?=$absen_date;?>"/>
                                </div>		
                                <div class="form-group">
                                <label for="nama">Nama:</label>
                                <input id="nama" name="nama" type="text" value="<?=$this->input->get("nama");?>"/>
                                </div>										  
                                <!--  <button type="submit" class="btn btn-success fa fa-search" onMouseOver="search()"> Search</button> -->											  
                                <button type="submit" class="btn btn-success fa fa-search" > Search</button>
                                
                            </form> 
                        </div>	
                        <table id="table" class="table table-striped">
                            <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Sekolah</th>
                                <th>Kelas</th>
                                <th>Nama</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if(isset($_GET['nama'])&&$_GET['nama']!=""){
                                    $this->db->like("user_name",$this->input->get("nama"),"both");
                                } 
                                
                                $this->db->where("absen_date",$absen_date);
                                $absen=$this->db
                                ->join("sekolah","sekolah.sekolah_id=absen.sekolah_id","left")
                                ->join("user","user.user_id=absen.user_id","left")
                                ->join("kelas","kelas.kelas_id=user.kelas_id","left")
                                ->order_by("kelas.kelas_id","ASC")
                                ->order_by("user.user_name","ASC")
                                ->get("absen");
                                // echo $this->db->last_query();
                                if($absen->num_rows()>0){
                                    foreach ($absen->result() as $absen) {	
                                    ?>
                                    <tr>
                                        <td><?=$absen->absen_date;?></td>
                                        <td><?=$absen->sekolah_name;?></td>
                                        <td><?=$absen->kelas_name;?></td>
                                        <td><?=$absen->user_name;?></td>
                                        <td>Hadir</td>
                                    </tr>
                                    <?php
                                    }			
                                } 
                                ?>
                                <?php 
                                
                                $this->db->where("absen_date",$absen_date);
                                $absen=$this->db
                                ->order_by("user_id","ASC")
                                ->get("absen");
                                $userid=array();
                                foreach ($absen->result() as $absen) {$userid[]=$absen->user_id;}
                                $userid1 = implode(",",$userid);
                                $userid2 = explode(",", $userid1);

                                if(isset($_GET['nama'])&&$_GET['nama']!=""){
                                    $this->db->like("user_name",$this->input->get("nama"),"both");
                                } 
                                $user=$this->db
                                ->select("*,user.user_id AS user_id")
                                ->join("sekolah","sekolah.sekolah_id=user.sekolah_id","left")
                                ->join("telpon","telpon.user_id=user.user_id","left")
                                ->join("kelas","kelas.kelas_id=user.kelas_id","left")
                                ->where_not_in("user.user_id",$userid2)
                                ->where("telpon.user_id IS NOT NULL",null)
                                ->where("telpon.telpon_type","1")
                                ->order_by("user.kelas_id","ASC")
                                ->order_by("user_name","ASC")
                                ->get("user");
                                // echo $this->db->last_query();
                                if($user->num_rows()>0){
                                    foreach ($user->result() as $user) {	
                                    ?>
                                    <tr>
                                        <td><?=$absen_date;?></td>
                                        <td><?=$user->sekolah_name;?></td>
                                        <td><?=$user->kelas_name;?></td>
                                        <td><?=$user->user_name;?></td>
                                        <td>Tidak Hadir</td>
                                    </tr>
                                    <?php
                                    }			
                                } 
                                ?>
                            </tbody>
                        </table>
                        <script>
                        $(document).ready(function() {
                            $('#table').DataTable( {
                               dom: 'Bfrtip',
                                buttons: [
                                    { extend: 'pdf', className: 'btn-danger text-white' },
                                    { extend: 'print', className: 'btn-warning text-white' },
                                    { extend: 'excel', className: 'btn-success text-white' }
                                ]
                            } );
                        } );
                        </script>
                    </div>                  
                    <div class="col-md-5 well">
                        <h3 class="">Jam kirim notifikasi tidak masuk sekolah.</h3>
                        <?php 
                        $kelas_sekolah=$this->db
                        ->join("kelas","kelas.kelas_id=kelas_sekolah.kelas_id","left")
                        ->where("kelas_sekolah.sekolah_id",$this->session->userdata("sekolah_id"))
                        ->get("kelas_sekolah");	
                        // echo $this->db->last_query();
                        foreach ($kelas_sekolah->result() as $kelas_sekolah) {
                        ?>
                        <form method="post">
                            <div class="form-group">
                                <label for="kelas_sekolah_notifabsen">Kelas <?=$kelas_sekolah->kelas_name;?></label>
                                <input type="time" class="form-control" id="kelas_sekolah_notifabsen" name="kelas_sekolah_notifabsen" value="<?=$kelas_sekolah->kelas_sekolah_notifabsen;?>">
                                <input type="hidden" name="kelas_sekolah_id" value="<?=$kelas_sekolah->kelas_sekolah_id;?>"/>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                        <?php }?>
                    </div> 
                </div>
            </div>
        </div>
    </div>

    

  

<?php require_once("footer.php");?>	
</body>

</html>
