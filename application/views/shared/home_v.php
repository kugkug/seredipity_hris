<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang='en'>
    <head></head>

    <body>
        
       <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?=$datacnt['nAppCnt']?></h3>

              <p>New Applicants</p>
            </div>
            <div class="icon">
              <i class="fa fa-users" style="font-size: .8em !important;"></i>
            </div>
            <a href="applications" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?=$datacnt['nEmpCnt']?></h3>

              <p>Employees</p>
            </div>
            <div class="icon">
              <i class="fa fa-users" style="font-size: .8em !important;"></i>
            </div>
            <a href="workers" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?=$datacnt['nCliCnt']?></h3>

               <p>Partners</p>
            </div>
            <div class="icon">
              <i class="fa fa-institution" style="font-size: .8em !important;"></i>
            </div>
            <a href="company" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?=$datacnt['nReqCnt']?></h3>

              <p>Client's Requests</p>
            </div>
            <div class="icon">
              <i class="fa fa-institution" style="font-size: .8em !important;"></i>
            </div>
            <a href="requests" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>

      <section>
        <div class="row">
            <div class="col-md-6">
              <div class="box box-info">
                <div class="box-header">
                  <i class="fa fa-users"></i>

                  <h3 class="box-title">Applicant Status</h3>
                </div>
                <div class="box-body">
                  <table class="table tabl-bordered">
                    <tr>
                      <th>Status</th>
                      <th>Count</th>
                    </tr>
                  
                  <?php

                    foreach (APPSTAT as $sKey => $sValue) {
                      
                      if (isset($datacnt['status'][$sKey])) {
                        $sCount = "<strong>".$datacnt['status'][$sKey]."</strong>";
                      } else {
                        $sCount = "-";
                      }

                ?>
                    <tr>
                      <td><?=$sValue;?></td>
                      <td><?=$sCount;?></td>
                    </tr>
              
              <?php
                  }

              ?>
            </table>
            </div>
          </div>
          </div>
        </div>
      </section>
    </body>
</html>