<?php
    $final_schedule_servicing_count_model = $data['final_schedule_servicing_count_model'];
    $total_schedule_inprogress_servicing_model = $data['total_schedule_inprogress_servicing_model'];
    $total_schedule_completed_servicing_model = $data['total_schedule_completed_servicing_model'];
?>
<div class="row">
    <div class="col-md-12">
        <div class="card card-custom gutter-b">
            <div class="card-header flex-wrap border-1">
                <div class="card-title">
                    <h3 class="card-label">
                        Servicings (In Progress/ Completed) by model
                    </h3>
                </div>
                <div class="card-toolbar">
                    <a class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-toggle="collapse"
                            href="#servicing-by-model" role="button" aria-expanded="true" aria-controls="custom_kt"
                            title="Toggle Card">
                            <i class="ki ki-arrow-down icon-nm"></i>
                        </a>
                </div>
            </div>
            <div id="servicing-by-model" class="collapse show">

                <div class="card card-body">
                    <div class="alert alert-info">
                      <i class="fa fa-info-circle" aria-hidden="true"></i>
                      <strong>The following report displays no. of servicings In Progress/Completed for a workshop for last 5 days.</strong>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th scope="col" style="width: 5%;" > S. # </th>
                                <th scope="col" style="width: 35%;" > Model </th>
                                <?php foreach ($date_range as $key => $value) : ?>
                                <th scope="col" style="width: 10%;">
                                    <?php
                                        if($key == 0) {
                                            $date = $value == $today ? 'Today' : 'Yesterday';
                                        } else {
                                            $date = $value;
                                        }
                                        ?>
                                        <a href="{{route('service_coupons.servicing_details',['date'=>$date])}}" target="_blank" title="In Progress Servicing">{{$date}}</a>

                                </th>
                                <?php endforeach; ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                if (isset($final_schedule_servicing_count_model) && !empty($final_schedule_servicing_count_model)) {
                                    $ctn=1; foreach ($final_schedule_servicing_count_model as $name => $servicing): ?>
                                    <tr>
                                        <td><?php echo $ctn++; ?></td>
                                        <td><?php echo  $name ; ?></td>
                                        <?php for ($i=0; $i<count($date_range); $i++){

                                        $link_for_inprogress =  $servicing[$date_range[$i]]['inprogress'] != 0 ? '<a href="'.route("service_coupons.servicing_details",['workshop_id'=>null,'date'=>$date_range[$i],'status'=>2]).'" target="_blank" style="color:brown;font-weight:bold" title="In Progress Servicing">'.$servicing[$date_range[$i]]['inprogress'].'</a>':0;
                                        $link_for_completed  =  $servicing[$date_range[$i]]['completed'] != 0 ? '<a href="'.route("service_coupons.servicing_details",['workshop_id'=>null,'date'=>$date_range[$i],'status'=>2]).'" target="_blank" style="color:green;font-weight:bold" title="Completed Servicing">'.$servicing[$date_range[$i]]['completed'].'</a>':0;

                                      if($servicing[$date_range[$i]]['inprogress'] == 0 && $servicing[$date_range[$i]]['completed'] == 0){
                                          echo '<td></td>';
                                      }else {
                                          echo '<td>'. $link_for_inprogress .' / '. $link_for_completed .'</td>';
                                      }

                                        }?>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php } else { ?>
                                    <tr>
                                        <td colspan=<?php echo (count($date_range) + 2);?>>No Data Available in Table!</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <?php if(isset($total_schedule_inprogress_servicing_model) && !empty($total_schedule_inprogress_servicing_model)) { ?>
                            <tfoot>
                            <tr>
                                <td colspan="2" style="font-size: 14px;font-weight: 600;">Total Servicings (In Progress/Completed)</td>
                                <?php for ($i=0; $i<count($date_range); $i++){

                                        echo '<td><label style="color: brown; font-weight:bold;">'.$total_schedule_inprogress_servicing_model[$date_range[$i]]['inprogress'].'</label> / <label style="color: green; font-weight:bold;">'.$total_schedule_completed_servicing_model[$date_range[$i]]['completed'].'</label></td>';

                                }?>
                            </tr>
                            </tfoot>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
