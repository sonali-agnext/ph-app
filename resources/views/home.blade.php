@extends('layouts.admin.app')

@section('content')
@php
$role_id = Auth::user()->role_id;
$officer = Auth::user()->officer();
$district_id = 0;
$tehsil_id = 0;
if(!empty($officer)){
  if($role_id == 4){
    $district_id = $officer->assigned_district;
  }
  if($role_id == 5){
    $tehsil_id = $officer->assigned_tehsil;
  }
}
@endphp
<div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">

            <!-- Sales Card -->
            <!-- <div class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Farmers <span>| Today</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-cart"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{\App\Models\Farmer::count()}}</h6>
                      <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span>

                    </div>
                  </div>
                </div>

              </div>
            </div> -->
            <!-- End Sales Card -->

            <!-- Revenue Card -->
            <!-- <div class="col-xxl-4 col-md-6">
              <div class="card info-card revenue-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Revenue <span>| This Month</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="ps-3">
                      <h6>$3,264</h6>
                      <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span>

                    </div>
                  </div>
                </div>

              </div>
            </div> -->
            <!-- End Revenue Card -->

            <!-- Customers Card -->
            <div class="col-xxl-4 col-md-6">

              <div class="card info-card customers-card">

                <!-- <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div> -->

                <div class="card-body">
                  <h5 class="card-title">Farmers </h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                      <h6>@if(!empty($tehsil_id))
                        {{\App\Models\Farmer::where('tehsil_id', $tehsil_id)->count()}}
                        @elseif(!empty($district_id))
                        {{\App\Models\Farmer::where('district_id', $district_id)->count()}}
                        @else
                        {{\App\Models\Farmer::count()}}
                        @endif</h6>
                      <!-- <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span> -->

                    </div>
                  </div>

                </div>
              </div>

            </div><!-- End Customers Card -->
          @if($role_id == 1 || $role_id == 3)
            <!-- Customers Card -->
            <div class="col-xxl-4 col-md-6">

              <div class="card info-card customers-card">

                <!-- <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div> -->

                <div class="card-body">
                  <h5 class="card-title">Schemes <span>| This Year</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{\App\Models\Scheme::count()}}</h6>
                      <!-- <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span> -->

                    </div>
                  </div>

                </div>
              </div>

            </div><!-- End Customers Card -->
          @endif
            <!-- Customers Card -->
            <div class="col-xxl-4 col-md-6">

              <div class="card info-card customers-card">

                <div class="card-body">
                  <h5 class="card-title">Applied Schemes <span>| This Year</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{\App\Models\AppliedScheme::count()}}</h6>

                    </div>
                  </div>

                </div>
              </div>

            </div><!-- End Customers Card -->
          @php $inProgress = (Auth::user()->appliedScheme()); @endphp
            <!-- Reports -->
            <!-- <div class="col-12">
              <div class="card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Reports <span>/Today</span></h5> -->

                  <!-- Line Chart -->
                  <!-- <div id="reportsChart"></div>

                  <script>
                    document.addEventListener("DOMContentLoaded", () => {
                      new ApexCharts(document.querySelector("#reportsChart"), {
                        series: [{
                          name: 'Sales',
                          data: [31, 40, 28, 51, 42, 82, 56],
                        }, {
                          name: 'Revenue',
                          data: [11, 32, 45, 32, 34, 52, 41]
                        }, {
                          name: 'Customers',
                          data: [15, 11, 32, 18, 9, 24, 11]
                        }],
                        chart: {
                          height: 350,
                          type: 'area',
                          toolbar: {
                            show: false
                          },
                        },
                        markers: {
                          size: 4
                        },
                        colors: ['#4154f1', '#2eca6a', '#ff771d'],
                        fill: {
                          type: "gradient",
                          gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.3,
                            opacityTo: 0.4,
                            stops: [0, 90, 100]
                          }
                        },
                        dataLabels: {
                          enabled: false
                        },
                        stroke: {
                          curve: 'smooth',
                          width: 2
                        },
                        xaxis: {
                          type: 'datetime',
                          categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z", "2018-09-19T06:30:00.000Z"]
                        },
                        tooltip: {
                          x: {
                            format: 'dd/MM/yy HH:mm'
                          },
                        }
                      }).render();
                    });
                  </script> -->
                  <!-- End Line Chart -->
<!-- 
                </div>

              </div>
            </div> -->
            <!-- End Reports -->

            <!-- Recent In review application -->
            <div class="col-12">
              <div class="card recent-sales overflow-auto">

                <!-- <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div> -->

                <div class="card-body">
                  <h5 class="card-title">In Review Application <span>| This week</span></h5>
                  <table id="example" class="table table-borderless datatable" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">Sr No</th>
                                <th scope="col">Application Number</th>
                                <th scope="col">Farmer Name</th>
                                <th scope="col">Days Left</th>
                                <th scope="col">Status</th>
                                <th scope="col">Date Applied</th>
                                <th scope="col">Block</th>
                                <th scope="col">District</th>
                                <th scope="col">Stage</th>
                                <!-- <th>Father's/Husband's Name</th> -->
                                
                                <!-- <th>City</th> -->
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($inProgress as $key => $farmer)
                            <tr>
                                <td>{{ ($key+1) }}</td>
                                <td>{{ $farmer->application_number }}</td>
                                <td>{{ $farmer->name }}</td>
                                <td>@if($role_id == 5 && $farmer->stage != 'Tehsil')
                                    --
                                    @elseif($role_id == 4 && $farmer->stage != 'District')
                                    --
                                    @elseif($farmer->stage == 'State')
                                    --
                                    @else
                                    @if($farmer->stage == 'District' && !empty($farmer->district_updated)  && ($farmer->district_status == "Resubmit" || $farmer->district_status == "Auto Approved"))
                                        @php
                                            $date1= date('Y-m-d',strtotime($farmer->district_updated.'+7 day'));
                                            $date2= date('Y-m-d');
                                            $date11 = date_create($date1);
                                            $date22 = date_create($date2);

                                            $dateDifference = date_diff($date11, $date22)->format('%d');
                                        @endphp
                                        @if($dateDifference == 1)
                                        <span class="badge bg-primary badge-pill badge-number" style="background: #F47564 !important;">{{$dateDifference}}</span>
                                        @elseif($dateDifference == 2)
                                        <span class="badge bg-primary badge-pill badge-number" style="background: #F6A69B !important; color:#000;">{{$dateDifference}}</span>
                                        @elseif($dateDifference == 3)
                                        <span class="badge bg-primary badge-pill badge-number" style="background: #F8C699 !important; color:#000;">{{$dateDifference}}</span>
                                        @elseif($dateDifference == 4)
                                        <span class="badge bg-primary badge-pill badge-number" style="background: #FBDDC2 !important; color:#000;">{{$dateDifference}}</span>
                                        @elseif($dateDifference == 5)
                                        <span class="badge bg-primary badge-pill badge-number" style="background: #C4FFE6 !important; color:#000;">{{$dateDifference}}</span>
                                        @elseif($dateDifference == 6)
                                        <span class="badge bg-primary badge-pill badge-number" style="background: #DDFFF1 !important; color:#000;">{{$dateDifference}}</span>
                                        @elseif($dateDifference == 7)
                                        <span class="badge bg-primary badge-pill badge-number" style="background: #fff !important; border: 1px solid #222222 !important; color:#000;">{{$dateDifference}}</span>
                                        @endif
                                    @endif
                                    @if($farmer->stage == 'Tehsil' && !empty($farmer->tehsil_updated)  && ($farmer->applied_status == "Resubmit" || $farmer->applied_status == "Auto Approved"))
                                        @php
                                            $date1= date('Y-m-d',strtotime($farmer->tehsil_updated.'+7 day'));
                                            $date2= date('Y-m-d');
                                            $date11 = date_create($date1);
                                            $date22 = date_create($date2);

                                            $dateDifference = date_diff($date11, $date22)->format('%d');
                                            
                                        @endphp
                                        @if($dateDifference == 1)
                                        <span class="badge bg-primary badge-pill badge-number" style="background: #F47564 !important;">{{$dateDifference}}</span>
                                        @elseif($dateDifference == 2)
                                        <span class="badge bg-primary badge-pill badge-number" style="background: #F6A69B !important; color:#000;">{{$dateDifference}}</span>
                                        @elseif($dateDifference == 3)
                                        <span class="badge bg-primary badge-pill badge-number" style="background: #F8C699 !important; color:#000;">{{$dateDifference}}</span>
                                        @elseif($dateDifference == 4)
                                        <span class="badge bg-primary badge-pill badge-number" style="background: #FBDDC2 !important; color:#000;">{{$dateDifference}}</span>
                                        @elseif($dateDifference == 5)
                                        <span class="badge bg-primary badge-pill badge-number" style="background: #C4FFE6 !important; color:#000;">{{$dateDifference}}</span>
                                        @elseif($dateDifference == 6)
                                        <span class="badge bg-primary badge-pill badge-number" style="background: #DDFFF1 !important; color:#000;">{{$dateDifference}}</span>
                                        @elseif($dateDifference == 7)
                                        <span class="badge bg-primary badge-pill badge-number" style="background: #fff !important; border: 1px solid #222222 !important; color:#000;">{{$dateDifference}}</span>
                                        @endif
                                        @endif
                                        

                                        @if($farmer->stage == 'Tehsil' && empty($farmer->tehsil_updated) && ($farmer->applied_status == "Resubmit") || $farmer->applied_status == "In Progress")
                                        @php
                                            $date1= date('Y-m-d',strtotime($farmer->aupdated_at.'+7 day'));
                                            $date2= date('Y-m-d');
                                            $date11 = date_create($date1);
                                            $date22 = date_create($date2);

                                            $dateDifference = date_diff($date11, $date22)->format('%d');
                                        @endphp 
                                        @if($dateDifference == 1)
                                        <span class="badge bg-primary badge-pill badge-number" style="background: #F47564 !important;">{{$dateDifference}}</span>
                                        @elseif($dateDifference == 2)
                                        <span class="badge bg-primary badge-pill badge-number" style="background: #F6A69B !important; color:#000;">{{$dateDifference}}</span>
                                        @elseif($dateDifference == 3)
                                        <span class="badge bg-primary badge-pill badge-number" style="background: #F8C699 !important; color:#000;">{{$dateDifference}}</span>
                                        @elseif($dateDifference == 4)
                                        <span class="badge bg-primary badge-pill badge-number" style="background: #FBDDC2 !important; color:#000;">{{$dateDifference}}</span>
                                        @elseif($dateDifference == 5)
                                        <span class="badge bg-primary badge-pill badge-number" style="background: #C4FFE6 !important; color:#000;">{{$dateDifference}}</span>
                                        @elseif($dateDifference == 6)
                                        <span class="badge bg-primary badge-pill badge-number" style="background: #DDFFF1 !important; color:#000;">{{$dateDifference}}</span>
                                        @elseif($dateDifference == 7)
                                        <span class="badge bg-primary badge-pill badge-number" style="background: #fff !important; border: 1px solid #222222 !important; color:#000;">{{$dateDifference}}</span>
                                        @endif
                                        @endif
                                        
                                        @if($farmer->stage == 'District' && empty($farmer->district_updated) && ($farmer->district_status == "Resubmit" || $farmer->district_status == "In Progress"))
                                        @php
                                            $date1= date('Y-m-d',strtotime($farmer->tehsil_updated.'+7 day'));
                                            $date2= date('Y-m-d');
                                            $date11 = date_create($date1);
                                            $date22 = date_create($date2);

                                            $dateDifference = date_diff($date11, $date22)->format('%d');
                                        @endphp

                                        @if($dateDifference == 1)
                                        <span class="badge bg-primary badge-pill badge-number" style="background: #F47564 !important;">{{$dateDifference}}</span>
                                        @elseif($dateDifference == 2)
                                        <span class="badge bg-primary badge-pill badge-number" style="background: #F6A69B !important; color:#000;">{{$dateDifference}}</span>
                                        @elseif($dateDifference == 3)
                                        <span class="badge bg-primary badge-pill badge-number" style="background: #F8C699 !important; color:#000;">{{$dateDifference}}</span>
                                        @elseif($dateDifference == 4)
                                        <span class="badge bg-primary badge-pill badge-number" style="background: #FBDDC2 !important; color:#000;">{{$dateDifference}}</span>
                                        @elseif($dateDifference == 5)
                                        <span class="badge bg-primary badge-pill badge-number" style="background: #C4FFE6 !important; color:#000;">{{$dateDifference}}</span>
                                        @elseif($dateDifference == 6)
                                        <span class="badge bg-primary badge-pill badge-number" style="background: #DDFFF1 !important; color:#000;">{{$dateDifference}}</span>
                                        @elseif($dateDifference == 7)
                                        <span class="badge bg-primary badge-pill badge-number" style="background: #fff !important; border: 1px solid #222222 !important; color:#000;">{{$dateDifference}}</span>
                                        @endif
                                        @endif
                                    @endif
                                </td>
                                <td>@if($farmer->stage == 'Tehsil'){{ $farmer->applied_status }}@else {{$farmer->district_status}} @endif</td>
                                <td>{{ date('d-m-Y',strtotime($farmer->acreated_at)) }}</td>
                                <td>{{ $farmer->tehsil_name }}</td>
                                <td>{{ $farmer->district_name }}</td>
                                <td>{{ $farmer->stage }}</td>
                                <td><a href="{{ route('view-applied-scheme',['id' => $farmer->apply_id])}}"><i class="bi bi-eye-fill"></i></a> </td>
                            </tr>
                            
                            @empty
                            <tr>
                                <td colspan="10">No Record Found</td>
                            </tr>
                            @endforelse                    
                        </tbody>
                    </table>                 

                </div>

              </div>
            </div>
            <!-- End Recent Sales -->

            <!-- Top Selling -->
            <!-- <div class="col-12">
              <div class="card top-selling overflow-auto">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body pb-0">
                  <h5 class="card-title">Top Selling <span>| Today</span></h5>

                  <table class="table table-borderless">
                    <thead>
                      <tr>
                        <th scope="col">Preview</th>
                        <th scope="col">Product</th>
                        <th scope="col">Price</th>
                        <th scope="col">Sold</th>
                        <th scope="col">Revenue</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row"><a href="#"><img src="{{ asset('img/product-1.jpg')}}" alt=""></a></th>
                        <td><a href="#" class="text-primary fw-bold">Ut inventore ipsa voluptas nulla</a></td>
                        <td>$64</td>
                        <td class="fw-bold">124</td>
                        <td>$5,828</td>
                      </tr>
                      <tr>
                        <th scope="row"><a href="#"><img src="{{ asset('img/product-2.jpg') }}" alt=""></a></th>
                        <td><a href="#" class="text-primary fw-bold">Exercitationem similique doloremque</a></td>
                        <td>$46</td>
                        <td class="fw-bold">98</td>
                        <td>$4,508</td>
                      </tr>
                      <tr>
                        <th scope="row"><a href="#"><img src="{{ asset('img/product-3.jpg')}}" alt=""></a></th>
                        <td><a href="#" class="text-primary fw-bold">Doloribus nisi exercitationem</a></td>
                        <td>$59</td>
                        <td class="fw-bold">74</td>
                        <td>$4,366</td>
                      </tr>
                      <tr>
                        <th scope="row"><a href="#"><img src="{{ asset('img/product-4.jpg')}}" alt=""></a></th>
                        <td><a href="#" class="text-primary fw-bold">Officiis quaerat sint rerum error</a></td>
                        <td>$32</td>
                        <td class="fw-bold">63</td>
                        <td>$2,016</td>
                      </tr>
                      <tr>
                        <th scope="row"><a href="#"><img src="{{ asset('img/product-5.jpg')}}" alt=""></a></th>
                        <td><a href="#" class="text-primary fw-bold">Sit unde debitis delectus repellendus</a></td>
                        <td>$79</td>
                        <td class="fw-bold">41</td>
                        <td>$3,239</td>
                      </tr>
                    </tbody>
                  </table>

                </div>

              </div> -->
            <!-- </div> -->
            <!-- End Top Selling -->

          </div>
        </div><!-- End Left side columns -->

      </div>
    </section>
@endsection
