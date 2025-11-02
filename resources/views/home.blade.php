<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Majestic Admin</title>

  <!-- plugins:css -->
  <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/base/vendor.bundle.base.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">
</head>
<body>
  <div class="container-scroller">

    <!-- NAVBAR -->
    @include('layouts.admin.navbar')
    <!-- END NAVBAR -->

    <div class="container-fluid page-body-wrapper">

      <!-- SIDEBAR -->
      @include('layouts.admin.sidebar')
      <!-- END SIDEBAR -->

      <!-- ============================== -->
      <!-- ====  DASHBOARD MULAI DARI SINI  ==== -->
      <!-- ============================== -->
      <div class="main-panel">
        <div class="content-wrapper">

          <!-- Header Selamat Datang -->
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="d-flex justify-content-between flex-wrap">
                <div class="d-flex align-items-end flex-wrap">
                  <div class="mr-md-3 mr-xl-5">
                    <h2>Welcome back,</h2>
                    <p class="mb-md-0">Your analytics dashboard template.</p>
                  </div>
                  <div class="d-flex">
                    <i class="mdi mdi-home text-muted hover-cursor"></i>
                    <p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;Dashboard&nbsp;/&nbsp;</p>
                    <p class="text-primary mb-0 hover-cursor">Analytics</p>
                  </div>
                </div>
                <div class="d-flex justify-content-between align-items-end flex-wrap">
                  <button type="button" class="btn btn-light bg-white btn-icon mr-3 d-none d-md-block">
                    <i class="mdi mdi-download text-muted"></i>
                  </button>
                  <button type="button" class="btn btn-light bg-white btn-icon mr-3 mt-2 mt-xl-0">
                    <i class="mdi mdi-clock-outline text-muted"></i>
                  </button>
                  <button type="button" class="btn btn-light bg-white btn-icon mr-3 mt-2 mt-xl-0">
                    <i class="mdi mdi-plus text-muted"></i>
                  </button>
                  <button class="btn btn-primary mt-2 mt-xl-0">Download report</button>
                </div>
              </div>
            </div>
          </div>

          <!-- Tabs Overview / Sales / Purchases -->
          <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body dashboard-tabs p-0">
                  <ul class="nav nav-tabs px-4" role="tablist">
                    <li class="nav-item"><a class="nav-link active" id="overview-tab" data-toggle="tab" href="#overview" role="tab">Overview</a></li>
                    <li class="nav-item"><a class="nav-link" id="sales-tab" data-toggle="tab" href="#sales" role="tab">Sales</a></li>
                    <li class="nav-item"><a class="nav-link" id="purchases-tab" data-toggle="tab" href="#purchases" role="tab">Purchases</a></li>
                  </ul>
                  <div class="tab-content py-0 px-0">

                    <!-- OVERVIEW -->
                    <div class="tab-pane fade show active" id="overview">
                      <div class="d-flex flex-wrap justify-content-xl-between">
                        <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                          <i class="mdi mdi-currency-usd mr-3 icon-lg text-danger"></i>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Revenue</small>
                            <h5 class="mr-2 mb-0">$577,545</h5>
                          </div>
                        </div>
                        <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                          <i class="mdi mdi-eye mr-3 icon-lg text-success"></i>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Total views</small>
                            <h5 class="mr-2 mb-0">9,833,550</h5>
                          </div>
                        </div>
                        <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                          <i class="mdi mdi-download mr-3 icon-lg text-warning"></i>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Downloads</small>
                            <h5 class="mr-2 mb-0">2,233,783</h5>
                          </div>
                        </div>
                        <div class="d-flex py-3 border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                          <i class="mdi mdi-flag mr-3 icon-lg text-danger"></i>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Flagged</small>
                            <h5 class="mr-2 mb-0">3,497,843</h5>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- SALES & PURCHASES (sama isinya) -->
                    <div class="tab-pane fade" id="sales"> <!-- copy isi #overview di sini kalau mau beda --> </div>
                    <div class="tab-pane fade" id="purchases"> <!-- copy isi #overview di sini kalau mau beda --> </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Chart + Total Sales -->
          <div class="row">
            <div class="col-md-7 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title">Cash deposits</p>
                  <p class="mb-4">To start a blog, think of a topic about and first brainstorm party is ways to write details</p>
                  <div id="cash-deposits-chart-legend" class="d-flex justify-content-center pt-3"></div>
                  <canvas id="cash-deposits-chart"></canvas>
                </div>
              </div>
            </div>

            <div class="col-md-5 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title">Total sales</p>
                  <h1>$ 28,835</h1>
                  <h4>Gross sales over the years</h4>
                  <p class="text-muted">Today, many people rely on computers to do homework, work, and create or store useful information.</p>
                  <div id="total-sales-chart-legend"></div>
                  <canvas id="total-sales-chart"></canvas>
                </div>
              </div>
            </div>
          </div>

          <!-- Tabel Recent Purchases -->
          <div class="row">
            <div class="col-md-12 stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title">Recent Purchases</p>
                  <div class="table-responsive">
                    <table id="recent-purchases-listing" class="table">
                      <thead>
                        <tr>
                          <th>Name</th><th>Status report</th><th>Office</th><th>Price</th><th>Date</th><th>Gross amount</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr><td>Jeremy Ortega</td><td>Levelled up</td><td>Catalinaborough</td><td>$790</td><td>06 Jan 2018</td><td>$2,274,253</td></tr>
                        <tr><td>Alvin Fisher</td><td>Ui design completed</td><td>East Mayra</td><td>$23,230</td><td>18 Jul 2018</td><td>$83,127</td></tr>
                        <tr><td>Emily Cunningham</td><td>support</td><td>Makennaton</td><td>$939</td><td>16 Jul 2018</td><td>$29,177</td></tr>
                        <tr><td>Minnie Farmer</td><td>support</td><td>Agustinaborough</td><td>$30</td><td>30 Apr 2018</td><td>$44,617</td></tr>
                        <tr><td>Betty Hunt</td><td>Ui design not completed</td><td>Lake Sandrafort</td><td>$571</td><td>25 Jun 2018</td><td>$78,952</td></tr>
                        <!-- baris lain tetap sama -->
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Footer Dashboard -->
          <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">
                Copyright © 2018 <a href="https://www.urbanui.com/" target="_blank">Urbanui</a>. All rights reserved.
              </span>
              <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">
                Hand-crafted & made with <i class="mdi mdi-heart text-danger"></i>
              </span>
            </div>
          </footer>

        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- main-panel ends -->
      <!-- ============================== -->
      <!-- ====  DASHBOARD SELESAI  ==== -->
      <!-- ============================== -->

    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="{{ asset('assets/vendors/base/vendor.bundle.base.js') }}"></script>
  <script src="{{ asset('assets/vendors/chart.js/Chart.min.js') }}"></script>
  <script src="{{ asset('assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>

  <!-- inject:js -->
  <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
  <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
  <script src="{{ asset('assets/js/template.js') }}"></script>

  <!-- Custom js -->
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
  <script src="{{ asset('assets/js/data-table.js') }}"></script>
  <script src="{{ asset('assets/js/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/js/dataTables.bootstrap4.js') }}"></script>
</body>
</html>