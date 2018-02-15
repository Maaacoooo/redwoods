
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?=$title?> &middot; <?=$site_title?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <?php $this->load->view('inc/css')?>
   
</head>
<body class="hold-transition skin-red sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  <header class="main-header">
    <?php $this->load->view('inc/header')?>
  </header>

  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <?php $this->load->view('inc/left_nav')?>    
  </aside>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$title?>        
      </h1>
      <ol class="breadcrumb">
        <li class="active"><?=$title?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      
      <div class="row">
        <div class="col-xs-12">
          <?=$this->sessnotif->showNotif()?>
        </div><!-- /.col-xs-12 -->
      </div><!-- /.row -->

      <?php if ($passwordverify): ?>
      <div class="row">
        <div class="col-lg-12">
          <div class="callout callout-danger">
            <div class="row">
              <div class="col-lg-6">
                <h4><i class="fa fa-warning"></i> Change your password!</h4>
                <p>Hi <?=$user['name']?>! Welcome and Thank you for using <?=APP_NAME?>! <br />
                The system has detected that you are currently using the system's default password. <br />
                Please change your password immediately for your privacy and account security
                </p>
                <p>To change your password,
                    <ol>
                      <li>Go to upper right of your screen</li>
                      <li>Click <em>Your Name</em></li>
                      <li>Go to <em>Profile</em></li>
                      <li>Click the <em>Settings Tab</em></li>
                    </ol>
                </p>
                <a href="<?=base_url('settings/profile')?>" class="btn btn-outline btn-flat pull-right" style="text-decoration: none"><i class="fa fa-wrench"></i> Change Password</a>
              </div><!-- /.col-lg-6 -->
            </div><!-- /.row -->
          </div><!-- /.callout callout-danger -->
        </div><!-- /.col-lg-12 -->
      </div><!-- /.row -->
      <?php endif ?>

      <div class="row">
        <div class="col-lg-9 col-sm-12">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Overdue Loans</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                  <i class="fa fa-minus"></i></button>      
              </div>
            </div>
            <div class="box-body">
               <?php if ($overdue): ?>
              <div class="box-body table-responsive no-padding">
                <table class="table table-striped table-condensed">             
                  <tbody>
                    <?php foreach ($overdue as $od): ?>
                      <tr>
                        <td><a href="<?=base_url('loans/view/'.$od['id'])?>"><?=$od['lastname'].', '.$od['firstname']?></a></td>
                        <td><a href="<?=base_url('loans/view/'.$od['id'])?>"><?=$od['id']?></a></td>
                        <td><a href="<?=base_url('loans/view/'.$od['id'])?>"><?=moneytize($od['borrowed_amount'])?> <span class="badge bg-red">OVERDUE</span></a></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>                       
                </table><!-- /.table table-bordered -->
              </div><!-- /.box-body -->
              <?php else: ?>
                <div class="box-body">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="well">
                        <strong><i class="icon fa fa-ban"></i> Oops! No Results Found</strong><br />
                        The has found no results. If you feel something wrong, please contact the System Administrator.
                      </div>
                    </div><!-- /.col-sm-12 -->
                  </div><!-- /.row -->   
                </div><!-- /.box-body -->     
              <?php endif; ?>             
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
            </div>
            <!-- /.box-footer-->
          </div>
          <!-- /.box -->

          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Active Loans</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                  <i class="fa fa-minus"></i></button>      
              </div>
            </div>
            <div class="box-body">
              <?php if ($active): ?>
              <div class="box-body table-responsive no-padding">
                <table class="table table-striped table-condensed">             
                  <tbody>
                    <?php foreach ($active as $res): ?>
                      <tr>
                        <td><a href="<?=base_url('loans/view/'.$res['id'])?>"><?=$res['lastname'].', '.$res['firstname']?></a></td>
                        <td><a href="<?=base_url('loans/view/'.$res['id'])?>"><?=$res['id']?></a></td>
                        <td><a href="<?=base_url('loans/view/'.$res['id'])?>"><?=moneytize($res['borrowed_amount'])?></a></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>                       
                </table><!-- /.table table-bordered -->
              </div><!-- /.box-body -->
              <?php else: ?>
                <div class="box-body">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="well">
                        <strong><i class="icon fa fa-ban"></i> Oops! No Results Found</strong><br />
                        The has found no results. If you feel something wrong, please contact the System Administrator.
                      </div>
                    </div><!-- /.col-sm-12 -->
                  </div><!-- /.row -->   
                </div><!-- /.box-body -->     
              <?php endif; ?>             
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
            </div>
            <!-- /.box-footer-->
          </div>
          <!-- /.box -->
        </div><!-- /.col-lg-9 col-sm-12 -->
        <div class="col-lg-3 col-sm-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Quick Options</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>      
              </div>
            </div>
            <div class="box-body">
              <a href="<?=base_url('borrowers/create')?>" class="btn btn-block btn-flat btn-primary">Register Borrower</a>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
            </div>
            <!-- /.box-footer-->
          </div>
          <!-- /.box -->
        </div><!-- /.col-lg-3 col-sm-12 -->
      </div><!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">    
    <?php $this->load->view('inc/footer')?>    
  </footer>

</div>
<!-- ./wrapper -->

    <?php $this->load->view('inc/js')?>    
  
</body>
</html>
