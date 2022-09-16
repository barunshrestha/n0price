<?php
$final_servicing_count = $data['final_servicing_count'];
$total_inprogress_servicing = $data['total_inprogress_servicing'];
$total_completed_servicing = $data['total_completed_servicing'];
?>
<div class="row">
    <div class="col-md-12">
        <div class="card card-custom gutter-b">
            <div class="card-header flex-wrap border-1">
                <div class="card-title">
                    <h3 class="card-label">
                        Servicings (In Progress/ Completed)
                    </h3>
                </div>
                <div class="card-toolbar">
                    <a class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-toggle="collapse"
                        href="#all-servicing" role="button" aria-expanded="true" aria-controls="custom_kt"
                        title="Toggle Card">
                        <i class="ki ki-arrow-down icon-nm"></i>
                    </a>
                </div>
            </div>
            <div id="all-servicing" class="collapse show">
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                        <strong>The following report displays no. of servicings In Progress/Completed for a workshop for
                            last 5 days.</strong>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="kt_datatable">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 5%;"> S. # </th>
                                    <th scope="col" style="width: 35%;"> Workshop </th>
                                    <?php foreach ($date_range as $key => $value) : ?>
                                    <th scope="col" style="width: 10%;">
                                        <?php
                                        if ($key == 0) {
                                            $date = $value == $today ? 'Today' : 'Yesterday';
                                        } else {
                                            $date = $value;
                                        }
                                        ?>
                                        <a href="{{ route('servicecoupons.servicing_details', ['date' => $value]) }}"
                                            target="_blank">{{ $date }}</a>

                                    </th>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                            if (isset($final_servicing_count) && !empty($final_servicing_count)) {
                                $ctn=1; foreach ($final_servicing_count as $name => $servicing): ?>
                                <tr>
                                    <td><?php echo $ctn++; ?></td>
                                    <td><a href="{{ route('servicecoupons.servicing_details', ['date' => null, 'workshop_id' => $dealer_list[$name]]) }}"
                                            target="_blank">{{ $name }}</a></td>
                                    <?php for ($i = 0; $i < count($date_range); $i++) {
                                        $link_for_inprogress = $servicing[$date_range[$i]]['inprogress'] != 0 ? '<a href="' . route('servicecoupons.servicing_details', ['workshop_id' => $dealer_list[$name], 'date' => $date_range[$i], 'status' => 2]) . '" target="_blank" style="color:brown;font-weight:bold" title="In Progress Servicing">' . $servicing[$date_range[$i]]['inprogress'] . '</a>' : 0;
                                        $link_for_completed = $servicing[$date_range[$i]]['completed'] != 0 ? '<a href="' . route('servicecoupons.servicing_details', ['workshop_id' => $dealer_list[$name], 'date' => $date_range[$i], 'status' => 2]) . '" target="_blank" style="color:green;font-weight:bold" title="Completed Servicing">' . $servicing[$date_range[$i]]['completed'] . '</a>' : 0;

                                        if ($servicing[$date_range[$i]]['inprogress'] == 0 && $servicing[$date_range[$i]]['completed'] == 0) {
                                            echo '<td></td>';
                                        } else {
                                            echo '<td>' . $link_for_inprogress . ' / ' . $link_for_completed . '</td>';
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
                            <?php if(isset($total_inprogress_servicing) && !empty($total_inprogress_servicing)) { ?>
                            <tfoot>
                                <tr>
                                    <td colspan="2" style="font-size: 14px;font-weight: 600;">Total Servicings (In
                                        Progress/Completed)</td>
                                    <?php for ($i = 0; $i < count($date_range); $i++) {
                                        echo '<td><label style="color: brown; font-weight:bold;">' . $total_inprogress_servicing[$date_range[$i]]['inprogress'] . '</label> / <label style="color: green; font-weight:bold;">' . $total_completed_servicing[$date_range[$i]]['completed'] . '</label></td>';
                                    } ?>
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

@section('scripts')
    <!-- <script src="{{ asset('js/pages/crud/ktdatatable/base/html-table.js') }}" type="text/javascript"></script> -->
    <script src="{{ asset('js/pages/crud/datatables/extensions/buttons.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pages/widgets.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        var datatable = $('#kt_datatable').KTDatatable({
            data: {
                saveState: {
                    cookie: false
                }
            },
            columns: [{
                    field: "No",
                    width: 20,
                },
                {
                    field: "E-mail",
                    width: 200,
                },

            ],
            search: {
                input: $('#kt_datatable_search_query'),
                key: 'generalSearch'
            }
        });
    </script>

    <style>
        .flagged {}
    </style>
@endsection
