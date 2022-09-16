<div class="row">
    <div class="col-md-12">
        <div class="card card-custom gutter-b">
            <div class="card-header flex-wrap border-1">
                <div class="card-title">
                    <h3 class="card-label">
                        New Enquiries
                    </h3>
                </div>
                <div class="card-toolbar">
                    <a class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-toggle="collapse"
                        href="#enquiry-dealer" role="button" aria-expanded="true" aria-controls="custom_kt"
                        title="Toggle Card">
                        <i class="ki ki-arrow-down icon-nm"></i>
                    </a>
                </div>
            </div>
            <div id="enquiry-dealer" class="collapse show">
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
                                            <a href="{{ route('enquiries.index', ['date_to' => $value]) }}"
                                                target="_blank">{{ $date }}</a>
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                            if (isset($enquiries_by_dealer) && !empty($enquiries_by_dealer)) {
                                $ctn=1; foreach ($enquiries_by_dealer as $name => $data):
                                   // if (isset($dealer_list[$name])) {
                                ?>
                                <tr>
                                    <td>{{ $ctn++ }}</td>
                                    <td>
                                        <a href="{{ route('enquiries.index', ['dealer_id' => $dealer_list[$name]]) }}"
                                            target="_blank">{{ $name }}</a>
                                    </td>
                                    <?php
                                    for ($i = 0; $i < count($date_range); $i++) {
                                        $total_enquiries = $data[$date_range[$i]]['total_enquiries'] != 0 ? '<a href="' . route('enquiries.index', ['dealer_id' => $dealer_list[$name], 'date_to' => $date_range[$i]]) . '" target="_blank" style="color:brown;font-weight:bold;" title="Total Enquiries">' . $data[$date_range[$i]]['total_enquiries'] . '</a>' : '';

                                        if ($data[$date_range[$i]]['total_enquiries'] == 0) {
                                            echo '<td></td>';
                                        } else {
                                            echo '<td>' . $total_enquiries . '</td>';
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
                            <?php if(isset($total_enquiries_by_date) && !empty($total_enquiries_by_date)) { ?>
                            <tfoot>
                                <tr>
                                    <td colspan="2" style="font-size: 14px;font-weight: 600;">Total Enquiries</td>
                                    <?php
                                    for ($i = 0; $i < count($date_range); $i++) {
                                        echo '<td><label style="color: green; font-weight:bold;">' . $total_enquiries_by_date[$date_range[$i]]['total_enquiries'] . '</label></td>';
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
