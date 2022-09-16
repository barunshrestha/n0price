<div class="row">
    <div class="col-md-12">
        <div class="card card-custom gutter-b">
            <div class="card-header flex-wrap border-1">
                <div class="card-title">
                    <h3 class="card-label">
                        Dispatch of the vehicles
                    </h3>
                </div>
                <div class="card-toolbar">
                    <a class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-toggle="collapse"
                        href="#dispatch-dealer" role="button" aria-expanded="true" aria-controls="custom_kt"
                        title="Toggle Card">
                        <i class="ki ki-arrow-down icon-nm"></i>
                    </a>
                </div>
            </div>
            <div id="dispatch-dealer" class="collapse show">
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                        <strong>The following report displays no. of enquiries registered by a workshop for last 5
                            days.</strong>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 5%;"> S. # </th>
                                    <th scope="col" style="width: 35%;"> Dealer </th>
                                    @foreach ($date_range as $key => $value)
                                        <th scope="col" style="width: 10%;">
                                            <?php
                                            if ($key == 0) {
                                                $date = $value == $today ? 'Today' : 'Yesterday';
                                            } else {
                                                $date = $value;
                                            }
                                            ?>
                                            <a href="{{ route('vehicles.new_reg_vehicles', ['date' => $value]) }}"
                                                target="_blank">{{ $date }}</a>
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                            if (isset($final_array) && !empty($final_array)) {
                                $ctn=1; foreach ($final_array as $name => $vehicles):
                                ?>
                                <tr>
                                    <td>{{ $ctn++ }}</td>
                                    <td>
                                        <a href="{{ route('vehicles.new_reg_vehicles', ['workshop_id' => $dealer_list[$name]]) }}"
                                            target="_blank">{{ $name }}</a>
                                    </td>
                                    <?php
                                    for ($i = 0; $i < count($date_range); $i++) {
                                        if ($vehicles[$date_range[$i]] != 0) {
                                            echo '<td><a href="' . route('vehicles.new_reg_vehicles', ['workshop_id' => $dealer_list[$name], 'date' => $date_range[$i]]) . '" target="_blank" style="color:green;font-weight:bold;" title="New Vehicles">' . $vehicles[$date_range[$i]] . '</a></td>';
                                        } else {
                                            echo '<td></td>';
                                        }
                                    } ?>
                                </tr>
                                <?php endforeach; ?>
                                <?php } else { ?>
                                <tr>
                                    <td colspan=<?php echo count($date_range) + 2; ?>>No Data Available in Table!</td>
                                </tr>
                                <?php } ?>
                            </tbody>
                            <?php if(isset($total_new_reg_vehicles) && !empty($total_new_reg_vehicles)) { ?>
                            <tfoot>
                                <tr>
                                    <td colspan="2" style="font-size: 14px;font-weight: 600;">Total</td>
                                    <?php
                                    for ($i = 0; $i < count($date_range); $i++) {
                                        echo '<td><label style="color: green; font-weight:bold;">' . $total_new_reg_vehicles[$date_range[$i]]['new_reg_vehicles'] . '</label></td>';
                                    }
                                    ?>
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
