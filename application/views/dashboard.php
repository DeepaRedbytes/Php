<?php require_once('layouts/header.php'); ?>
  <div id="content-wrapper">
    <div class="container-fluid">
        <div class="row">
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card0 card-cascade cascading-admin-card">
              <div class="admin-up">
                <i class="fas fa-users primary-color-bg"></i>
                <div class="data">
                  <P>USERS</P><h4 class="font-weight-bold dark-grey-text"><?=$userCount;?></h4>
                </div>
              </div>
              <div class="card-body card-body-cascade"></div>
              <a class="card-footer text-black clearfix small z-1" href="user">
                <span class="float-left">View Details</span>
                <span class="float-right next-butn use-bg">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card0 card-cascade cascading-admin-card">
              <div class="admin-up">
                <i class="fas fa-cogs warning-color"></i>
                <div class="data">
                  <P>SERVICES</P><h4 class="font-weight-bold dark-grey-text"><?=$serviceCount;?></h4>
                  <P>NEW SERVICES</P><h4 class="font-weight-bold dark-grey-text"><?=$unreadserviceCount;?></h4>
                  
                </div>
              </div>
              <div class="card-body card-body-cascade"></div>
              <a class="card-footer text-black clearfix small z-1" href="service">
                <span class="float-left">View Details</span>
                <span class="float-right next-butn warning-color">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card0 card-cascade cascading-admin-card">
              <div class="admin-up">
                <i class="fas fa-info-circle light-blue lighten-1"></i>
                <div class="data">
                  <P>EVENTS</P><h4 class="font-weight-bold dark-grey-text"><?=$eventCount;?></h4>
                  <P>NEW EVENTS</P><h4 class="font-weight-bold dark-grey-text"><?=$unreadeventCount;?></h4>
                </div>
              </div>
              <div class="card-body card-body-cascade"></div>
              <a class="card-footer text-black clearfix small z-1" href="event">
                <span class="float-left">View Details</span>
                <span class="float-right next-butn light-blue lighten-1">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card0 card-cascade cascading-admin-card">
              <div class="admin-up">
                <i class="fas fa-ad cool-bg"></i>
                <div class="data">
                  <P>AD'S REQUEST</P><h4 class="font-weight-bold dark-grey-text"><?=$advertisementCount;?></h4>
                  <P>NEW AD'S</P><h4 class="font-weight-bold dark-grey-text"><?=$unreadadvertisementCount;?></h4>
                </div>
              </div>
              <div class="card-body card-body-cascade"></div>
              <a class="card-footer text-black clearfix small z-1" href="advertisement">
                <span class="float-left">View Details</span>
                <span class="float-right next-butn cool-bg">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card0 card-cascade cascading-admin-card">
              <div class="admin-up">
                <i class="fas fa-list-alt red accent-2"></i>
                <div class="data">
                  <P>CATEGORIES</P><h4 class="font-weight-bold dark-grey-text"><?=$categoryCount;?></h4>
                </div>
              </div>
              <div class="card-body card-body-cascade"></div>
              <a class="card-footer text-black clearfix small z-1" href="category">
                <span class="float-left">View Details</span>
                <span class="float-right next-butn red accent-2">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
        </div>
    </div>
  </div>
    <?php require_once('layouts/footer.php'); ?>