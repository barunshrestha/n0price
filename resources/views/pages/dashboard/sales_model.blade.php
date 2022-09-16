<div class="row">
    <div class="col-md-12">
        <div class="card card-custom gutter-b">
            <div class="card-header flex-wrap border-1">
                <div class="card-title">
                    <h3 class="card-label">
                        Sales by Model
                    </h3>
                </div>
                <div class="card-toolbar">
                    <a class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-toggle="collapse"
                            href="#sales-model" role="button" aria-expanded="true" aria-controls="custom_kt"
                            title="Toggle Card">
                            <i class="ki ki-arrow-down icon-nm"></i>
                        </a>
                </div>
            </div>
            <div id="sales-model">
                <div class="card-body">
                    <div class="alert alert-info">
                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                    <strong>The following report displays no. of sales for a workshop for last 5 days.</strong>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th scope="col" style="width: 5%;" > S. # </th>
                                <th scope="col" style="width: 35%;" > Workshop </th>
                                <?php foreach ($date_range as $key => $value) : ?>
                                <th scope="col" style="width: 10%;">
                                    <?php
                                        if($key == 0) {
                                            $date = $value == $today ? 'Today' : 'Yesterday';
                                        } else {
                                            $date = $value;
                                        }
                                        ?>
                                        <a href="{{route('customers.registration_list',['date'=>$value])}}" target="_blank">{{$date}}</a>

                                </th>
                                <?php endforeach; ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                if (isset($sales_model_details) && !empty($sales_model_details)) {
                                    $ctn=1; foreach ($sales_model_details as $key => $val): ?>
                                    <tr>
                                        <td>{{$ctn++}}</td>
                                        <td><strong>{{$key}}</strong></td>
                                        @foreach($date_range as $key=>$value)
                                            <td>
                                                @if (isset($val[$value]))
                                                    @if(isset($val['id']))
                                                        <a href="{{route('customers.sales_model',['dealer_id' => $val['id'], 'date' =>$value)]}}" style="color:green; font-weight:bold;" title="New Sales" target="_blank">{{$val[$value]}}</a>
                                                    @else
                                                        <strong>{{$val[$value]}}</strong>
                                                    @endif
                                                @else
                                                    0
                                                @endif

                                            </td>
                                        @endforeach
                                    </tr>
                                    <?php endforeach; ?>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
